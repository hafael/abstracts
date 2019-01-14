<?php

namespace Hafael\Abstracts\Console\Partials;

trait JobPartial
{

    /**
     * Gera o Job baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldJobFiles()
    {

        $serviceClassName = $this->className.'Job';

        $filePath = $this->resourcePath.'/Jobs/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'job'));
    }

}
