<?php

namespace Hafael\Abstracts\Console;

use Illuminate\Support\Str;
use Hafael\Abstracts\Console\Partials\ControllerPartial;
use Hafael\Abstracts\Console\Partials\ApiControllerPartial;

class ControllerBootstrap extends Bootstrap
{
    
    use ControllerPartial,
        ApiControllerPartial;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abstracts:controller
                            {name : Resource Name (folder and namespace)}
                            {--className= : Class Name}
                            {--api=true : RESTful API support}
                            {--namespace=App\\ : Root Namespace}
                            {--folder=src/ : App Root Folder}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Controller files';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function customHandle()
    {

        if(!$this->option('api')) {
            $this->useApiFiles = $this->ask('Want to generate files for restful api feature? [Y|n]', true);
        }

        $this->makeFolders();

        $this->scaffoldControllerFiles();

        if ($this->useApiFiles) {
            $this->scaffoldControllerApiSingleFiles();
        }

    }


    /**
     * Gera a estrutura de diretórios.
     *
     */
    public function makeFolders()
    {
        $directoryList = [
            $this->resourcePath,
            $this->resourcePath.'/Http/Controllers',
        ];

        if($this->useApiFiles){
            $directoryList = array_merge($directoryList, [
                $this->resourcePath.'/Http/Controllers/Api',
                $this->resourcePath.'/Http/Transformers',
                $this->resourcePath.'/Http/Requests',
            ]);
        }

        $this->info('Diretórios gerados:');
        foreach($directoryList as $folder) {
            if ($this->makeDirectories($folder))
                $this->line($folder);
        }
    }


}
