<?php

namespace Src\v1\Auth\Delivery\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ResponseBuilder;
use Illuminate\Http\Request;

use Src\v1\Auth\Delivery\Validations\LoginValidation;
use Src\v1\Auth\Usecase\LoginUsecase;


class Login extends Controller
{
	use ResponseBuilder;

	public function Login(Request $request, LoginUsecase $usecase){
		LoginValidation::RequestLoginValidation($request->all());

		$data = $usecase->loginLogic($request->all());

		return $this->generateResponse($data);
	}
}