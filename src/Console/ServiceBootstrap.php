<?php

namespace Hafael\Abstracts\Console;

use Illuminate\Support\Str;
use Hafael\Abstracts\Console\Partials\ServicePartial;

class ServiceBootstrap extends Bootstrap
{
    
    use ServicePartial;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abstracts:service
                            {name : Resource Name (folder and namespace)}
                            {--className= : Class Name}
                            {--namespace=App\\ : Root Namespace}
                            {--folder=src/ : App Root Folder}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Code Generator for Resources grouped by entity and context.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function customHandle()
    {

        $this->makeFolders();

        $this->scaffoldServiceFiles();

    }


    /**
     * Gera a estrutura de diretórios.
     *
     */
    public function makeFolders()
    {
        $directoryList = [
            $this->resourcePath,
            $this->resourcePath.'/Services',
        ];

        $this->info('Diretórios gerados:');
        foreach($directoryList as $folder) {
            if ($this->makeDirectories($folder))
                $this->line($folder);
        }
    }


}
