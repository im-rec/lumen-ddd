<?php

namespace Src\v1\Auth\Usecase;

use Illuminate\Http\Response;

use Src\v1\Auth\Exception\CommonLoginException;

use Src\v1\Auth\Repository\LoginRepository;

use Illuminate\Support\Facades\Config;
use Lib\EncryptionLib;

class LoginUsecase {

	public function loginLogic($request){

		$loginWith  = $request["login_with"];
		$thirdparty = false;

		// Login with thirdparty
		if(in_array($loginWith, Config::get('custom.social_login'))){
			$thirdparty = true;
			$token      = $request["token"];
		}

		if (!$thirdparty) {
			$email   = $request["email"];
			$password   = $request["password"];
		}

		// Get Data User
		$user = LoginRepository::getDataUser($email);

		if (!$user) {
			throw new CommonLoginException("Login Failed.", Response::HTTP_UNAUTHORIZED);
		}

		if (!$thirdparty) {
			if(! \PasswordHash::CheckPassword($password, $user->password)){
				throw new CommonLoginException("Login Failed.", Response::HTTP_UNAUTHORIZED);
			}
		}

		if($this->_setStatelessSession($user)){
			return [
				"id_user" => EncryptionLib::encrypt($user->id_user),
				"email" => $user->email,
				"name" => $user->name
			];
		}else{
			throw new CommonLoginException("Set session login failed.", Response::HTTP_BAD_REQUEST);
		}
	}

	private function _setStatelessSession($user){
		$refresh_token = GetGlobalParam('v1-refresh-token');

		$old = \RedisLib::get(REFRESH_TOKEN_PREFIX . $refresh_token);

		if(count($old) == 0){
			throw new CommonLoginException("Refresh token has been expired.", Response::HTTP_PRECONDITION_FAILED);
		}

		// Populate Data User
		$data_user = [
			"id_user" => $user->id_user,
			"email" => $user->email,
			"name" => $user->name
		];

		// Populate New Refresh Token Data
		$data_refresh = [
			"access_token" => $old["access_token"],
			"token_type"   => "Bearer",
			"expires_in"   => EXP_REFRESH_TOKEN,
			"start_time"   => time(),
			"login"		   => $data_user
		];

		return (\RedisLib::setMulti(REFRESH_TOKEN_PREFIX . $refresh_token, EXP_REFRESH_TOKEN, $data_refresh) ? true : false);
	}

}