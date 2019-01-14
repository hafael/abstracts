<?php

namespace Hafael\Abstracts\Console;

use Illuminate\Support\Str;
use Hafael\Abstracts\Console\Partials\JobPartial;

class JobBootstrap extends Bootstrap
{
    
    use JobPartial;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abstracts:job
                            {name : Resource Name (folder and namespace)}
                            {--className= : Class Name}
                            {--namespace=App\\ : Root Namespace}
                            {--folder=src/ : App Root Folder}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Job files';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function customHandle()
    {

        $this->makeFolders();

        $this->scaffoldJobFiles();

    }


    /**
     * Gera a estrutura de diretórios.
     *
     */
    public function makeFolders()
    {
        $directoryList = [
            $this->resourcePath,
            $this->resourcePath.'/Jobs',
        ];

        $this->info('Diretórios gerados:');
        foreach($directoryList as $folder) {
            if ($this->makeDirectories($folder))
                $this->line($folder);
        }
    }


}
