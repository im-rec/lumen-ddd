<?php

/**
 * Created By Rian Eka Cahya
 * Email : rian@onedeca.com	
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class HashAccessor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PasswordHash';
    }
}
