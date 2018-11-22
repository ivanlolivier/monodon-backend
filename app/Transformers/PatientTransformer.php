<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\File;
use App\Models\Message;
use App\Models\NotificationSent;
use App\Models\Patient;
use App\Models\PatientInformation;
use App\Models\PatientInterrogatory;
use App\Models\Subscription;
use App\Models\Visit;

class PatientTransformer extends Transformer
{

    public function transform($model)
    {
        $photo = null;
        if ($model->photo) {
            if (substr($model->photo, 0, 7) === "http://") {
                $photo = $model->photo;
            } else {
                $photo = url('/storage/' . $model->photo);
            }
        }

        $model_for_attributes = $model;
        if ($this->isRelationshipLoaded($model, 'clinicInformations') && $model->clinicInformations->count() > 0) {
            $model_for_attributes = $model->clinicInformations[0];
        }

        $this->output = [
            'id'        => $model->id,
            'name'      => $model_for_attributes->name,
            'surname'   => $model_for_attributes->surname,
            'document'  => [
                'type'   => $model_for_attributes->document_type,
                'number' => $model_for_attributes->document,
            ],
            'birthdate' => $model_for_attributes->birthdate->toDateString(),
            'sex'       => $model_for_attributes->sex,
            'photo'     => $photo,
            'phones'    => explode(';', $model_for_attributes->phones),
            'email'     => $model_for_attributes->email,
            'tags'      => explode(';', $model_for_attributes->tags),
        ];

        $this->replaceRelationship($model, 'subscriptions', Subscription::transformer());
        $this->replaceRelationship($model, 'clinics', Clinic::transformer());
        $this->replaceRelationship($model, 'visits', Visit::transformer());
        $this->replaceRelationship($model, 'notificationsSent', NotificationSent::transformer());
        $this->replaceRelationship($model, 'messages', Message::transformer());
        $this->replaceRelationship($model, 'informations', PatientInformation::transformer());
        $this->replaceRelationship($model, 'appointments', Appointment::transformer());
        $this->replaceRelationship($model, 'files', File::transformer());
        $this->replaceRelationship($model, 'interrogation', PatientInterrogatory::transformer());

        return $this->output;
    }

}