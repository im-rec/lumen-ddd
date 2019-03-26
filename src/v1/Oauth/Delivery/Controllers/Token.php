<?php

namespace Src\v1\Oauth\Delivery\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ResponseBuilder;
use Illuminate\Http\Request;

use Src\v1\Oauth\Delivery\Validations\TokenValidation;
use Src\v1\Oauth\Usecase\TokenUsecase;

class Token extends Controller
{
	use ResponseBuilder;

	public function GenerateToken(Request $request, TokenUsecase $usecase){
		TokenValidation::RequestTokenValidation($request->all());

		$data = $usecase->generateToken($request->all());

		return $this->generateResponse($data);
		
	}

	public function RegisterClient(TokenUsecase $usecase){
		$data = $usecase->createClientCredential();

		return $this->generateResponse($data);
	}

}