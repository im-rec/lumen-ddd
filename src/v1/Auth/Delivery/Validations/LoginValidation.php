<?php

namespace Src\v1\Auth\Delivery\Validations;

use Src\v1\Auth\Exception\CommonLoginException;
use Illuminate\Support\Facades\Config;

use Validator;

class LoginValidation
{

	public static function RequestLoginValidation($request){
		$validator = Validator::make($request, [
            'email' => 'email|required_if:login_with,host',
            'password' => 'string|required_if:login_with,host',
            'login_with' => 'required|alpha|in:' . implode(",",Config::get("custom.login_with")),
            'token' => 'required_unless:login_with,host'
        ]);

        if ($validator->fails()) {
            throw new CommonLoginException("Your request parameter is incorrect.", Response::HTTP_BAD_REQUEST);
        }
	}
}