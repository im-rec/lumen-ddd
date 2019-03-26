<?php

namespace Src\v1\Oauth\Usecase;

use Src\v1\Oauth\Repository\TokenRepository;

use Src\v1\Oauth\Exception\CommonTokenException;

use Firebase\JWT\JWT;

class TokenUsecase {

	public function generateToken($request){

		$client = TokenRepository::getClient($request['client_id']);

		if(!$client){
			throw new CommonTokenException("Something wrong, client_id not found.", Response::HTTP_BAD_REQUEST);
		}

		// check jika cllient secret gak match
		if(! \PasswordHash::CheckPassword($request['client_secret'], $client->client_secret)){
			throw new CommonTokenException("Something wrong, client_id and client_secret did not match", Response::HTTP_UNAUTHORIZED);
		}

		$time = time();

		$data_refresh = [
			"token_type"   => "Bearer",
			"expires_in"   => EXP_REFRESH_TOKEN,
			"start_time"   => $time,
		];

		if(isset($request['refresh_token'])){
			$old = \RedisLib::get(REFRESH_TOKEN_PREFIX . $request['refresh_token']);

			if(count($old) == 0){
				throw new CommonTokenException("Refresh token has been expired.", Response::HTTP_PRECONDITION_FAILED);
			}

			// Jika User sudah login, copy data user dari refresh token lama ke refresh token baru
			if(isset($old["login"])){
				$data_refresh["login"] = $old["login"];
			}

			// Delete old refresh token
			\RedisLib::deleteAll(REFRESH_TOKEN_PREFIX . $request['refresh_token']);
		}

		// generate refresh token code
		$refresh_token = generateRandomUuid(6);

		// generate access token
		$payload = [
            'refresh' => $refresh_token,
            'type' => "Bearer", 
            'iat' => $time,
            'exp' => $time + EXP_ACCESS_TOKEN
        ];

        $access_token = JWT::encode($payload, env('APP_KEY'), JWT_ALGORITHM);

        $data_refresh["access_token"] = $access_token;

        // Save data refresh token ke redis
        \RedisLib::setMulti(REFRESH_TOKEN_PREFIX . $refresh_token, EXP_REFRESH_TOKEN, $data_refresh);

        return [
        	"access_token" => $access_token,
        	"refresh_token" => $refresh_token,
        	"token_type" => TOKEN_TYPE,
        	"expire" => EXP_ACCESS_TOKEN
        ];

	}

	public function createClientCredential(){
		$client_id = bin2hex(openssl_random_pseudo_bytes(16));
		$client_secret = bin2hex(openssl_random_pseudo_bytes(32));

		$data = array(
			"client_id" => $client_id,
			"client_secret" => \PasswordHash::HashPassword($client_secret),
			"status" => GetReferential("oauth_client", "status", "ENABLED"),
			"created_at" => dateSekarang()
		);

		if(! TokenRepository::insertClientCredentials($data)){
			throw new CommonTokenException("Create Client Credentials Failed.", Response::HTTP_BAD_REQUEST);
		}

		return [
			"client_id" => $client_id,
			"client_secret" => $client_secret
		];
	}

}