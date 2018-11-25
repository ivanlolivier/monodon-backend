<?php

namespace App\Models;

use App\Transformers\PatientInterrogatoryTransformer;

class PatientInterrogatory extends _Model
{
    protected $table = 'patient_interrogation';

    protected $fillable = ['question_id', 'answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function transformer()
    {
        return new PatientInterrogatoryTransformer();
    }
}
