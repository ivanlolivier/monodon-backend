<?php

namespace App\Transformers;

use App\Models\Clinic;
use App\Models\Patient;
use App\Models\Subscription;

class PatientTransformer extends Transformer
{

    public function transform(Patient $model)
    {
        $photo = null;
        if ($model->photo) {
            if (substr($model->photo, 0, 7) === "http://") {
                $photo = $model->photo;
            } else {
                $photo = url('/storage/' . $model->photo);
            }
        }

        $this->output = [
            'id'        => $model->id,
            'name'      => $model->name,
            'surname'   => $model->surname,
            'document'  => [
                'type'   => $model->document_type,
                'number' => $model->document,
            ],
            'birthdate' => $model->birthdate->toDateString(),
            'sex'       => $model->sex,
            'photo'     => $photo,
            'phones'    => explode(';', $model->phones),
            'email'     => $model->email,
            'tags'      => explode(';', $model->tags),
        ];

        $this->replaceRelationship($model, 'subscriptions', Subscription::transformer());
        $this->replaceRelationship($model, 'clinics', Clinic::transformer());

        return $this->output;
    }

}