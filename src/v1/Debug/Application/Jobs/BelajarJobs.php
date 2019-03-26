<?php

namespace Src\v1\Debug\Application\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BelajarJobs implements ShouldQueue
{

    use InteractsWithQueue, Queueable;

    protected $pesan;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($pesan)
    {
        $this->pesan = $pesan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Ini dari jobs' . $this->pesan);
    }
}
