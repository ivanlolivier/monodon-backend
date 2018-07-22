<?php

namespace App\Transformers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\File;
use App\Models\Message;
use App\Models\NotificationSent;
use App\Models\Patient;
use App\Models\PatientInformation;
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
        $this->replaceRelationship($model, 'visits', Visit::transformer());
        $this->replaceRelationship($model, 'notificationsSent', NotificationSent::transformer());
        $this->replaceRelationship($model, 'messages', Message::transformer());
        $this->replaceRelationship($model, 'informations', PatientInformation::transformer());
        $this->replaceRelationship($model, 'appointments', Appointment::transformer());
        $this->replaceRelationship($model, 'files', File::transformer());
        
        return $this->output;
    }
    
}