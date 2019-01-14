<?php

namespace Hafael\Abstracts\Transformers;

use League\Fractal\TransformerAbstract;
use Hafael\Abstracts\Models\Example;

class AbstractTransformer extends TransformerAbstract
{
    public function transform(Example $model)
    {
        return $model->toTransform();
    }
}