<?php
/**
 * Created by Rian Eka Cahya.
 * Email: rian.eka.cahya@gmail.com
 * Date: 6/12/18
 * Time: 03:17
 * Copyright (c) 2018 PT. onedeca.com
 */

namespace Lib;

use Illuminate\Support\Facades\Config;

class EncryptionLib
{

	public static function encrypt($str)
	{

		$key = Config::get('app.key');
		$iv = Config::get('app.key_iv');

		$str = self::pkcs5Pad($str);

		$encrypted = openssl_encrypt($str, 'AES-128-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);

		return bin2hex($encrypted);
	}

	public static function decrypt($code)
	{

		$key = Config::get('app.key');
		$iv = Config::get('app.key_iv');

		$code = self::hex2bin($code);
		$decrypted = openssl_decrypt($code, 'AES-128-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv);
		$ut = utf8_encode(trim($decrypted));

		return self::pkcs5Unpad($ut);
	}

	private static function hex2bin($hexdata)
	{
		$bindata = "";
		for ($i = 0; $i < strlen($hexdata); $i += 2) {
			$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
		}

		return $bindata;
	}

	private static function pkcs5Pad($text)
	{
		$blocksize = 16;
		$pad = $blocksize - (strlen($text) % $blocksize);

		return $text . str_repeat(chr($pad), $pad);
	}

	private static function pkcs5Unpad($text)
	{
		if (strlen($text) > 0) {
			$pad = ord($text{strlen($text) - 1});

			if ($pad > strlen($text)) {
				return $text;
			}

			if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
				return $text;
			}

			return substr($text, 0, -1 * $pad);
		}

		return false;
	}
}