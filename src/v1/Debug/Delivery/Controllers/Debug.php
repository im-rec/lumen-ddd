<?php

namespace Src\v1\Debug\Delivery\Controllers;

use App\Http\Controllers\Controller;

use Src\v1\Debug\Application\Jobs\BelajarJobs;
use Src\v1\Debug\Application\Events\BelajarEvent;
use Src\v1\Debug\Application\Events\BelajarEventQueue;

class Debug extends Controller
{

	public function index(){

		event(new BelajarEventQueue("rian"));
		event(new BelajarEvent("rian"));
		dispatch(new BelajarJobs("rian"));
	}
}