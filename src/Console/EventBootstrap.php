<?php

namespace Hafael\Abstracts\Console;

use Illuminate\Support\Str;
use Hafael\Abstracts\Console\Partials\EventPartial;
use Hafael\Abstracts\Console\Partials\ListenerPartial;

class EventBootstrap extends Bootstrap
{
    
    use EventPartial,
        ListenerPartial;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abstracts:event
                            {name : Resource Name (folder and namespace)}
                            {--className= : Class Name}
                            {--namespace=App\\ : Root Namespace}
                            {--folder=src/ : App Root Folder}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Event files';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function customHandle()
    {

        $this->makeFolders();

        $this->scaffoldEventFiles();
        $this->scaffoldListenerFiles();

    }


    /**
     * Gera a estrutura de diretórios.
     *
     */
    public function makeFolders()
    {
        $directoryList = [
            $this->resourcePath,
            $this->resourcePath.'/Events',
            $this->resourcePath.'/Listeners',
        ];

        $this->info('Diretórios gerados:');
        foreach($directoryList as $folder) {
            if ($this->makeDirectories($folder))
                $this->line($folder);
        }
    }


}
