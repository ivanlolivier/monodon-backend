<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

abstract class Transformer extends TransformerAbstract
{

    protected $output;

    public function replaceRelationship(Model $model, $relation, $transformer, $field = null)
    {
        if (is_null($field)) {
            $field = $relation . '_id';
        }

        if ($this->isRelationshipLoaded($model, $relation)) {
            $this->output[$relation] = $transformer->transform($model->{$relation});
            unset($this->output[$field]);
        }
    }

    public function isRelationshipLoaded(Model $model, $relation)
    {
        return array_key_exists($relation, $model->getRelations());
    }
}