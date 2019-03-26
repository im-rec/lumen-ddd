<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseBuilder{

	protected function generateResponse($data = array(), $code = Response::HTTP_OK, $message = '', $status=true){

		if (!empty($data)) {
			$return['data'] = $data;
		}

		$return['meta'] = [
			'code' => $code,
			'status' => $status,
			'message' => $message
		];

		return response()->json($return, $code);
	}
}