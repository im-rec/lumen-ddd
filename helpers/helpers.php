<?php

if(! function_exists("generateRandomUuid")){
	function generateRandomUuid($totalLoop = 10){
		$x      = 1;
		$result = [];
		do {
			$result[] = \Illuminate\Support\Str::Uuid();
			$x += 1;
		} while ($x <= $totalLoop);
		return join("-", $result);
	}
}

if(! function_exists("SetGlobalParam")){
	function SetGlobalParam($key, $value){
		\App()->bind($key, function() use ($value) {
			return $value;
		});
	}
}

if(! function_exists("GetGlobalParam")){
	function GetGlobalParam($key){
		return (\App()->bound($key) ? \App($key) : NULL);
	}
}

if(! function_exists("GetReferential")){
	function GetReferential($tabel, $field, $name){
		$data = \DB::table('referential_master')
				->select(DB::raw('id'))
				->where('table_name', '=', $tabel)
				->where('field_name', '=', $field)
				->where('name', '=', $name)
				->where('status', '=', 1)
				->first();
		return (isset($data->id) ? $data->id : NULL);
	}
}


if(! function_exists("dateSekarang")){
	function dateSekarang($act = 1, $param = FALSE) {   
		if ($act == 1) {
			return date("Y-m-d H:i:s");
		} else if ($act == 2) {
			return date("Y-m-d");
		} else if ($act == 3) {
			return date("d F Y H:i", strtotime($param));
		} else if ($act == 4) {
			return date("d F Y", strtotime($param));
		} else if ($act == 5) {
			return date("Y/m/d");
		} else if ($act == 6) {
			return date("d/m/Y H:i");
		} else if ($act == 7) {
			$paramex = explode("/", substr($param, 0, 10));
			$jam = substr($param, 11, 6);
			return "{$paramex[2]}-{$paramex[1]}-{$paramex[0]} {$jam}";
		} else if ($act == 8) {
			return date("d M Y");
		} else if ($act == 9) {
			return date("Ymd");
		} else if ($act == 10) {
			$paramex = explode("/", substr($param, 0, 10));
			return "{$paramex[2]}-{$paramex[1]}-{$paramex[0]}";
		} else if ($act == 11) {
			$paramex = explode("-", substr($param, 0, 10));
			return "{$paramex[2]}-{$paramex[1]}-{$paramex[0]}";
		} else if ($act == 12) {
			return date("d F Y H:i:s", strtotime($param));
		} else if ($act == 13) {
			return date("d F Y", strtotime($param));
		} else if ($act == 14) {
			return date("H:i", strtotime($param));
		} else if ($act == 15) { 
			return date("d", strtotime($param));
		} else if ($act == 16) {
			return date("m", strtotime($param));
		} else if ($act == 17) {
			return date("Y", strtotime($param));
		} else if ($act == 18) {
			return date("Y-m-d H:i:s", strtotime($param));
		} else if ($act == 19) {
			return date("Y-m-d", strtotime($param));
		} else if ($act == 20) {
			return date("Y-m-d H:i", strtotime($param));
		} else if ($act == 21) {
			return date("d F Y H:i", strtotime($param));
		}
	}
}

if(!function_exists("clean_text_and_space")) {
	function clean_text_and_space( $teks, $separator = "" ) {
		$find = array( '|<(.*?)>|', '|</(.*?)>|', '|[_]{1,}|', '|[ ]{1,}|', '|[^a-zA-Z0-9\/\:\-.]|', '|[-]{2,}|', '|[,]|', '|:|', '|quot|', '|039|', '|[.]{2,}|', '|[.]{3,}|', '|[/]|' );
		$replace = array( $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator, $separator );

		$newname = preg_replace( $find, $replace, $teks );

		return $newname;
	}
}

if(!function_exists("currency")){
	function currency($price){
		return number_format($price, 0, ',', '.');
	}
}

if(!function_exists("decimals")){
	function decimals($number){
		return number_format($number, 2, ',', '.');
	}
}