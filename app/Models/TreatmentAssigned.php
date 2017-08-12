<?php

namespace App\Models;

use App\Transformers\TreatmentAssignedTransformer;

class TreatmentAssigned extends _Model
{
    protected $table = 'treatments_assigned';

    protected $casts = [
        'is_finished' => 'boolean'
    ];

    protected $fillable = [
        'patient_id',
        'treatment_id',
        'diagnosis_id',
        'buccal_zone_id',
        'is_finished',
    ];

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function buccal_zone()
    {
        return $this->belongsTo(BuccalZone::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public static function transformer()
    {
        return new TreatmentAssignedTransformer();
    }
}
