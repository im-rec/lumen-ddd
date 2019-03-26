<?php

namespace App\Middleware;

use closure;
use Illuminate\Support\Facades\File;

class ApiLogger
{
	private $startTime;

	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \Closure  $next
	* @return mixed
	*/

	public function handle($request, Closure $next)
	{
		$this->startTime = microtime(true);

    	return $next($request);
	}


	public function terminate($request, $response)
	{	
		if (env('LOG_API', true)) {
			$version = $request->fullUrl();
			$version = explode('/', $version);
			$version = (isset($version[3]) ? $version[3] . '-' : '');

			$endTime = microtime(true);
			$filename = $version . 'api-logger-' . date('d-m-y') . '.log';
			$dataToLog  = 'Time: '   . gmdate("F j, Y, g:i a") . "\n";
			$dataToLog .= 'Duration: ' . number_format($endTime - LUMEN_START, 3) . "\n";

			$dataToLog .= 'IP Address: ' . $request->ip() . "\n";
			$dataToLog .= 'URL: '    . $request->fullUrl() . "\n";
			$dataToLog .= 'Method: ' . $request->method() . "\n";
			$dataToLog .= 'Input: '  . $request->getContent() . "\n";
			$dataToLog .= 'Output: ' . $response->getContent() . "\n";

			File::append( storage_path('logs' . DIRECTORY_SEPARATOR . $filename), $dataToLog . "\n" . str_repeat("=", 100) . "\n\n");
		}
	}
}