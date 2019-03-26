<?php

/**
 * Created By Rian Eka Cahya
 * Email : rian@onedeca.com	
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FacadesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('PasswordHash', '\Lib\PasswordHash');
        $this->app->bind('RedisLib', '\Lib\RedisLib');
    }
}
