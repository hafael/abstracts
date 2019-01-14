<?php

namespace Hafael\Abstracts\Console\Partials;

trait ApiControllerPartial
{

    /**
     * Gera o Controller RESTful baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldControllerApiSingleFiles()
    {

        $stubType = 'apiController';

        $filePath = $this->resourcePath.'/Http/Controllers/Api/'.$this->className.'Controller.php';

        $this->files->put($filePath, $this->buildClass($this->className, $stubType));
    }
    
    /**
     * Gera o Controller RESTful baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldControllerApiFiles()
    {

        $stubType = 'apiControllerResource';

        $filePath = $this->resourcePath.'/Http/Controllers/Api/'.$this->className.'Controller.php';

        $this->files->put($filePath, $this->buildClass($this->className, $stubType));
        $this->scaffoldTransformFiles();
        $this->scaffoldCreateRequestFiles();
        $this->scaffoldUpdateRequestFiles();
        $this->scaffoldSearchRequestFiles();
    }

    /**
     * Gera o Transformer baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldTransformFiles()
    {

        $transformerClassName = $this->className.'Transformer';

        $filePath = $this->resourcePath.'/Http/Transformers/'.$transformerClassName.'.php';

        $this->files->put($filePath, $this->buildClass($transformerClassName, 'transformer'));
    }

    /**
     * Gera o Request Validator baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldCreateRequestFiles()
    {

        $serviceClassName = $this->className.'CreateFormRequest';

        $filePath = $this->resourcePath.'/Http/Requests/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'request'));
    }

    /**
     * Gera o Request Validator baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldUpdateRequestFiles()
    {

        $serviceClassName = $this->className.'UpdateFormRequest';

        $filePath = $this->resourcePath.'/Http/Requests/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'request'));
    }

    /**
     * Gera o Request Validator baseado no arquivo stub respectivo.
     *
     */
    public function scaffoldSearchRequestFiles()
    {

        $serviceClassName = $this->className.'SearchFormRequest';

        $filePath = $this->resourcePath.'/Http/Requests/'.$serviceClassName.'.php';

        $this->files->put($filePath, $this->buildClass($serviceClassName, 'searchRequest'));
    }

}
