<?php

namespace App\Middleware;

use Illuminate\Http\Response;

use closure;

class LoginV1Middleware
{
	public function handle($request, Closure $next)
	{
		$refresh_token = GetGlobalParam("v1-refresh-token");
		
		$data = \RedisLib::get(REFRESH_TOKEN_PREFIX . $refresh_token);

		if(count($data) == 0){
            return response()->json([
                'meta' => [
					'code' => Response::HTTP_PRECONDITION_FAILED,
					'status' => false,
					'message' => 'Refresh token has been expired.'
				]
            ], Response::HTTP_PRECONDITION_FAILED);
		}

		if(!isset($data["login"])){
			return response()->json([
                'meta' => [
					'code' => Response::HTTP_UNAUTHORIZED,
					'status' => false,
					'message' => 'Access is denied.'
				]
            ], Response::HTTP_UNAUTHORIZED);
		}

		SetGlobalParam("v1-data-user", $data["login"]);

    	return $next($request);
	}
}