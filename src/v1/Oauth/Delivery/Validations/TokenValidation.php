<?php

namespace Src\v1\Oauth\Delivery\Validations;

use Src\v1\Oauth\Exception\CommonTokenException;

use Validator;

class TokenValidation
{

	public static function RequestTokenValidation($request){
		$validator = Validator::make($request, [
            'grant_type' => 'required|string|in:client_credentials,refresh_token',
            'client_id' => 'required|alpha_num',
            'client_secret' => 'required|alpha_num',
            'refresh_token' => 'required_if:grant_type,refresh_token'
        ]);

        if ($validator->fails()) {
			throw new CommonTokenException("Your request parameter is incorrect.", Response::HTTP_BAD_REQUEST);
        }
	}
}