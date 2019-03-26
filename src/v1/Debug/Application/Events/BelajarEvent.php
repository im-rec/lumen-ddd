<?php

namespace Src\v1\Debug\Application\Events;

class BelajarEvent
{
	public $pesan;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($pesan)
    {
        $this->pesan = $pesan;
    }
}
