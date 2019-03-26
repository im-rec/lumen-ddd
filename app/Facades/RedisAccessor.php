<?php

/**
 * Created By Rian Eka Cahya
 * Email : rian@onedeca.com	
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RedisAccessor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'RedisLib';
    }
}
