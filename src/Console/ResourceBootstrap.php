<?php

namespace Hafael\Abstracts\Console;

use Illuminate\Support\Str;
use Hafael\Abstracts\Console\Partials\ModelPartial;
use Hafael\Abstracts\Console\Partials\ControllerPartial;
use Hafael\Abstracts\Console\Partials\ApiControllerPartial;
use Hafael\Abstracts\Console\Partials\EventPartial;
use Hafael\Abstracts\Console\Partials\ListenerPartial;
use Hafael\Abstracts\Console\Partials\JobPartial;
use Hafael\Abstracts\Console\Partials\PolicyPartial;
use Hafael\Abstracts\Console\Partials\RepositoryPartial;
use Hafael\Abstracts\Console\Partials\ServicePartial;

class ResourceBootstrap extends Bootstrap
{
    
    use ModelPartial,
        ControllerPartial,
        ApiControllerPartial,
        EventPartial,
        ListenerPartial,
        JobPartial,
        PolicyPartial,
        RepositoryPartial,
        ServicePartial;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'abstracts:resource
                            {name : Resource Name (folder and namespace)}
                            {--className= : Class Name}
                            {--api=true : RESTful API support}
                            {--namespace=App\\ : Root Namespace}
                            {--folder=src/ : App Root Folder}
                            {--additionalFiles : Additional scaffolding (Events, Jobs, Listeners) }
                            {--onlyFolders : Only generate directories }';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gerador de código para Recursos agrupados por entidade e contexto.';


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function customHandle()
    {

        if(!$this->option('api')) {
            $this->useApiFiles = $this->ask('Deseja gerar arquivos para recurso api restful? [Y|n]', true);
        }

        if(!$this->option('additionalFiles')) {
            $this->useAdditionalFiles = $this->confirm('Deseja gerar arquivos adicionais (Events, Jobs, Listeners)? [y|N]', false);
        }

        $this->makeFolders();

        if(!$this->option('onlyFolders')){

            $this->scaffoldModel();
            $this->scaffoldRepositoryFiles();
            $this->scaffoldControllerFiles();
            $this->scaffoldServiceFiles();

            if ($this->useApiFiles) {
                $this->scaffoldControllerApiFiles();
            }

            if($this->useAdditionalFiles) {
                $this->scaffoldPolicyFiles();
                $this->scaffoldEventFiles();
                $this->scaffoldJobFiles();
                $this->scaffoldListenerFiles();
            }
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
            $this->resourcePath.'/Http/Transformers',
            $this->resourcePath.'/Http/Requests',
            $this->resourcePath.'/Http/Filters',
            $this->resourcePath.'/Http/Controllers/Api',
            $this->resourcePath.'/Models',
            $this->resourcePath.'/Repositories/Contracts',
            $this->resourcePath.'/Services',
        ];

        if($this->useAdditionalFiles){
            $directoryList = array_merge($directoryList, [
                $this->resourcePath.'/Policies',
                $this->resourcePath.'/Events',
                $this->resourcePath.'/Jobs',
                $this->resourcePath.'/Listeners',
                $this->resourcePath.'/Notifications',
            ]);
        }

        $this->info('Diretórios gerados:');
        foreach($directoryList as $folder) {
            if ($this->makeDirectories($folder))
                $this->line($folder);
        }
    }

    public function validateResourceName($resourceName)
    {
        $this->resourceName = Str::ucfirst(Str::camel(class_basename($resourceName)));

        $this->resourcePath = base_path($this->option('folder').'/'.$this->resourceName);

        if (!$this->files->isDirectory(base_path($this->option('folder')))) {
            $this->error('`'.$this->resourcePath.'` não é um diretório válido.');
            return false;
        }

        if ($this->files->exists($this->resourcePath)) {
            $this->error('O diretório `'.$this->resourcePath.'` já existe.' );
            return false;
        }

        return true;
    }


}
