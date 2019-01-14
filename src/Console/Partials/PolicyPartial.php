<?php

namespace Hafael\Abstracts\Console\Partials;

trait PolicyPartial
{

    /**
     * Gera a Policy baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldPolicyFiles()
    {

        $serviceClassName = $this->className.'Policy';

        $filePath = $this->resourcePath.'/Policies/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'policy'));
    }

}
