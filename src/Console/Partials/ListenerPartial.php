<?php

namespace Hafael\Abstracts\Console\Partials;

trait ListenerPartial
{

    /**
     * Gera o Listener do evento baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldListenerFiles()
    {

        $serviceClassName = $this->className.'Listener';

        $filePath = $this->resourcePath.'/Listeners/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'listener'));
    }

}
