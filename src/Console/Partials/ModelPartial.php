<?php

namespace Hafael\Abstracts\Console\Partials;

trait ModelPartial
{

    /**
     * Gera o Model baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldModel()
    {

        $filePath = $this->resourcePath.'/Models/'.$this->className.'.php';

        $this->files->put($filePath, $this->buildClass($this->className, 'model'));
    }

}
