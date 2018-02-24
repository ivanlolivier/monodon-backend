<?php

namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;
use Illuminate\Database\Eloquent\Collection;

abstract class Transformer extends TransformerAbstract
{

    protected $output;

    public function replaceRelationship(Model $model, $relation, $transformer, $field = null)
    {
        if (is_null($field)) {
            $field = $relation . '_id';
        }


        if ($this->isRelationshipLoaded($model, $relation)) {
            $this->output[$relation] = null;
            if ($model->{$relation}) {
                $this->output[$relation] = ($model->{$relation} instanceof Collection) ?
                    $model->{$relation}->transform(function ($item) use ($transformer) {
                        return $transformer->transform($item);
                    }) :
                    $transformer->transform($model->{$relation});
            }

            if (key_exists($field, $this->output)) {
                unset($this->output[$field]);
            }
        }
    }

    public function isRelationshipLoaded(Model $model, $relation)
    {
        return array_key_exists($relation, $model->getRelations());
    }
}