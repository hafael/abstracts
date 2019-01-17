<?php

namespace Hafael\Abstracts\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class Bootstrap extends Command
{
    /**
     * @var Filesystem
     */
    public $files;


    /**
     * Create a new command instance.
     *
     * @internal param Filesystem $files
     * @internal param GeneratorCommand $generatorCommand
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
        $this->useApiFiles = true;
        $this->useAdditionalFiles = true;
        $this->targetFolder = null;
        $this->globalNamespace = null;
        $this->resourceName = null;
        $this->className = null;
        $this->resourcePath = null;
    }

    public function getResourceName($resourceName)
    {
        if(!$this->validateResourceName($resourceName))
        {
            $resourceName = $this->ask('Please enter a valid name for the resource:');
            $this->getResourceName($resourceName);
        }
    }
    
    public function validateResourceName($resourceName)
    {
        $this->resourceName = Str::ucfirst(Str::camel(class_basename($resourceName)));

        $this->resourcePath = base_path($this->option('folder').'/'.$this->resourceName);

        if (!$this->files->isDirectory(base_path($this->option('folder')))) {
            $this->error('`'.$this->resourcePath.'` is not a valid directory.');
            return false;
        }

        return true;
    }


    /**
     * Create a directory.
     *
     * @param string $directory
     * @return bool
     */
    public function makeDirectories($directory)
    {
        if (! $this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0777, true, true);
            return $directory;
        }
        return false;
    }

    /**
     * Rewrites a stub file and renames the classes.
     *
     * @param string $className
     * @param string $classType
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($className, $classType)
    {

        $stub = $this->files->get($this->getStub($classType));

        return $this->replaceNamespace($stub)
                    ->replaceClass($stub, $className);
    }


    /**
     * Get a stub file.
     *
     * @param string $stubClass
     * @return string
     */
    protected function getStub($stubClass)
    {

        switch ($stubClass) {
            case 'model':
                return __DIR__ . '/../stubs/model.stub';
            case 'controller':
                return __DIR__ . '/../stubs/controller.stub';
            case 'apiController':
                return __DIR__ . '/../stubs/apiController.stub';
            case 'apiControllerResource':
                return __DIR__ . '/../stubs/apiControllerResource.stub';
            case 'repository':
                return __DIR__ . '/../stubs/repository.stub';
            case 'repositoryContract':
                return __DIR__ . '/../stubs/repositoryContract.stub';
            case 'service':
                return __DIR__ . '/../stubs/service.stub';
            case 'transformer':
                return __DIR__ . '/../stubs/transformer.stub';
            case 'event':
                return __DIR__ . '/../stubs/event.stub';
            case 'job':
                return __DIR__ . '/../stubs/job.stub';
            case 'listener':
                return __DIR__ . '/../stubs/listener.stub';
            case 'policy':
                return __DIR__ . '/../stubs/policy.stub';
            case 'request':
                return __DIR__ . '/../stubs/request.stub';
            case 'searchRequest':
                return __DIR__ . '/../stubs/searchRequest.stub';
        }
        return false;
    }

    /**
     * Rewrite the keys of a stub file.
     *
     * @param  string  $stub
     * @return $this
     */
    protected function replaceNamespace(&$stub)
    {
        $stub = str_replace(
            'DummyRootNamespace', $this->globalNamespace, $stub
        );

        $stub = str_replace(
            'DummyNamespace', $this->resourceName, $stub
        );

        $stub = str_replace(
            'dummyNamespace', strtolower($this->resourceName), $stub
        );

        $stub = str_replace(
            'DummyResource', $this->className, $stub
        );

        $stub = str_replace(
            'dummyResource', lcfirst($this->className), $stub
        );

        return $this;
    }

    /**
     * Rewrites the class of a given stub file.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass(&$stub, $name)
    {

        $class = str_replace($this->getNamespace($name).'\\', '', $name);

        return str_replace('DummyClass', $class, $stub);
    }

    /**
     * Returns a namespace after removing the double-bar.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        return trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if ($this->argument('name')) {

            $this->getResourceName($this->argument('name'));

        }

        if(empty($this->option('className'))) {
            $this->className = $this->resourceName;
        }else {
            $this->className = Str::ucfirst(Str::camel(class_basename($this->option('className'))));
        }

        
        if ($this->option('namespace'))
        {

            $this->globalNamespace = $this->getNamespace($this->option('namespace'));


            if (Str::contains($this->globalNamespace, '/')) {
                $this->globalNamespace = str_replace('/', '\\', $this->globalNamespace);
            }

            $confirmNameSpace = $this->confirm('Confirm the root namespace: `'.$this->globalNamespace.'`? [Y|n]', true);

            if (!$confirmNameSpace) {
                $this->globalNamespace = $this->ask('Enter the namespace in the PSR-4 pattern:');

                if (Str::contains($this->globalNamespace, '/')) {
                    $this->globalNamespace = str_replace('/', '\\', $this->globalNamespace);
                }
            }

        }


        $this->customHandle();


        $this->info('Files generated in `'.$this->resourcePath.'`' );
    }

    /**
     * Execute the custom console command.
     *
     * @return mixed
     */
    public function customHandle() {
        //
    }



}
