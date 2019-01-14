<?php

namespace Hafael\Abstracts\Console\Partials;

trait EventPartial
{

    /**
     * Gera o Event baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldEventFiles()
    {

        $serviceClassName = $this->className.'Event';

        $filePath = $this->resourcePath.'/Events/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'event'));
    }

}
