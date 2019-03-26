<?php

/**
 * Created By Rian Eka Cahya
 * Email : rian@onedeca.com	
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Input\InputOption;

class ModuleCommand extends Command
{

	public function __construct()
    {
        parent::__construct();
    }

	 /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:create {ModuleName} {--apiversion=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create Module";

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {

    	if(! $this->option('apiversion')){
    		return $this->error('Parameter API Version harus di isi');
    	}

        $path = base_path() . '/src/' . $this->option('apiversion') . '/' . $this->argument('ModuleName');

    	if(File::exists($path)) {
    		return $this->error('Module ' . $this->argument('ModuleName') . ' Directory Already Exists.');
    	}

    	$this->_CreateFolder($path);
    	$this->_CreateRoutes($path);
    }

    private function _CreateFolder($path){
    	$folder = array("Application", "Delivery", "Exception", "Repository", "Usecase");

    	foreach ($folder as $val) {
    		File::makeDirectory($path . '/' . $val, $mode = 0755, true, true);

            switch ($val) {
                case "Application":
                    $subfolder = array("Events", "Jobs", "Listeners");
                    foreach ($subfolder as $valsub) {
                        File::makeDirectory($path . '/' . $val . '/' . $valsub, $mode = 0755, true, true);
                    }
                    break;
                case "Delivery":
                    $subfolder = array("Controllers", "Validations");
                    foreach ($subfolder as $valsub) {
                        File::makeDirectory($path . '/' . $val . '/' . $valsub, $mode = 0755, true, true);
                    }
                    break;
                case "Repository":
                    File::makeDirectory($path . '/' . $val . '/Implement', $mode = 0755, true, true);
                    break;
            }
    	}
    }

    private function _CreateRoutes($path){
    	$stub = File::get(__DIR__.'/stubs/routes.stub');
    	File::put($path . '/Delivery/routes.php', $stub);
    }

}