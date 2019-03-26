<?php

  namespace App\Middleware;

  use Illuminate\Http\Response;

  use Closure;

  class BasicAuthMiddleware
  {
      public function handle($request, Closure $next) {
          if($request->getUser() != env('HTTP_USER') || $request->getPassword() != env('HTTP_PASSWORD')) {
              $headers = array('WWW-Authenticate' => 'Basic');
              return response()->json([
                'meta' => [
                  'code' => Response::HTTP_UNAUTHORIZED,
                  'status' => false,
                  'message' => 'Access is denied.'
                ]
              ], Response::HTTP_UNAUTHORIZED);
          }
          return $next($request);
      }
  }