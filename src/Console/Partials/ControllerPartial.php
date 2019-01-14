<?php

namespace Hafael\Abstracts\Console\Partials;

trait ControllerPartial
{

    /**
     * Gera o Controller baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldControllerFiles()
    {

        $controllerClassName = $this->className.'Controller';

        $stubType = 'controller';

        $filePath = $this->resourcePath.'/Http/Controllers/'.$controllerClassName.'.php';

        $this->files->put($filePath, $this->buildClass($controllerClassName, $stubType));

    }

}
