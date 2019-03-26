<?php

/**
 * Created By Rian Eka Cahya
 * Email : rian@onedeca.com	
 */

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

use Illuminate\Support\ServiceProvider;

class CleanArchitectureProvider extends ServiceProvider
{

	public function boot()
    {
    	$VersionDir = base_path() . '/src';
    	$VersionDirectories = array_map('basename', File::directories($VersionDir));

    	// Loop Version
        foreach ($VersionDirectories as $VersionName) {
        	$ModulesDir = base_path() . '/src/' . $VersionName;
            $ModuleDirectories = array_map('basename', File::directories($ModulesDir));

            // Loop Module
            foreach ($ModuleDirectories as $moduleName) {

            	// Register Module
                $modulePath = $ModulesDir . '/' . $moduleName . '/';
                if (File::exists($modulePath . "Delivery/routes.php")) {
                    $namespace = 'Src\\' . $VersionName . '\\' . $moduleName . '\Delivery\Controllers';
                    \Route::group(['prefix' => $VersionName, 'namespace' => $namespace], function() use ($modulePath, $moduleName) {
                        \Route::group(['prefix'  => strtolower($moduleName)], function() use ($modulePath) {
                            require $modulePath . "Delivery/routes.php";
                        });
                    });
                }
            }
        }
    }

}