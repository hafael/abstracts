<?php

namespace Hafael\Abstracts\Console\Partials;

trait ServicePartial
{

    /**
     * Gera o Service baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldServiceFiles()
    {

        $serviceClassName = $this->className.'Service';

        $filePath = $this->resourcePath.'/Services/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'service'));
    }

}
