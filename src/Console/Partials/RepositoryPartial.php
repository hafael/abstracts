<?php

namespace Hafael\Abstracts\Console\Partials;

trait RepositoryPartial
{

    /**
     * Gera o Repository baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldRepositoryFiles()
    {

        $repositoryClassName = $this->className.'Repository';
        $repositoryFilePath = $this->resourcePath.'/Repositories/'.$repositoryClassName.'.php';

        $repositoryInterface = $this->className.'RepositoryContract';
        $interfaceFilePath = $this->resourcePath.'/Repositories/Contracts/'.$repositoryInterface.'.php';


        $this->files->put($repositoryFilePath, $this->buildClass($repositoryClassName, 'repository'));
        $this->files->put($interfaceFilePath, $this->buildClass($repositoryInterface, 'repositoryContract'));
    }

}
