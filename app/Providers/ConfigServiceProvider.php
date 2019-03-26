<?php

/**
 * Created By Rian Eka Cahya
 * Email : rian@onedeca.com 
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class ConfigServiceProvider extends ServiceProvider
{

    const CONFIG_FOLDER_NAME = 'config';
    
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $configPath = App::basePath(self::CONFIG_FOLDER_NAME);

        if (!is_dir($configPath)) {
            throw new FileNotFoundException("The config folder is missing.\nCreate it on the root folder of your project and add the config files there.");
        }

        collect(scandir($configPath))->each(function ($item, $key) {
            App::configure(basename($item, '.php'));
        });
    }

}
