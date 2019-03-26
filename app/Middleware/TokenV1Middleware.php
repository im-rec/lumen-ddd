<?php

namespace App\Middleware;

use Illuminate\Http\Response;

use closure;

use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class TokenV1Middleware
{
	public function handle($request, Closure $next)
	{
		$token = $request->bearerToken();

		if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'meta' => [
					'code' => Response::HTTP_BAD_REQUEST,
					'status' => false,
					'message' => 'Token not provided.'
				]
            ], Response::HTTP_BAD_REQUEST);
        }

        try {
            $credentials = JWT::decode($token, env('APP_KEY'), [JWT_ALGORITHM]);
            SetGlobalParam("v1-refresh-token", $credentials->refresh);
        } catch(ExpiredException $e) {
            return response()->json([
                'meta' => [
					'code' => Response::HTTP_FORBIDDEN,
					'status' => false,
					'message' => 'Provided token is expired.'
				]
            ], Response::HTTP_FORBIDDEN);
        } catch(\Exception $e) {
            return response()->json([
                'meta' => [
					'code' => Response::HTTP_BAD_REQUEST,
					'status' => false,
					'message' => 'An error while decoding token.'
				]
            ], Response::HTTP_BAD_REQUEST);
        }
        
    	return $next($request);
	}
}