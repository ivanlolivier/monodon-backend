<?php

namespace App\Models;

use App\Transformers\VisitTransformer;

class Visit extends _Model
{
    
    public function parent()
    {
        return $this->belongsTo(Visit::class, 'parent_visit_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public function treatments()
    {
        return $this->HasMany(TreatmentAssigned::class);
    }

    public function progress()
    {
        return $this->belongsTo(Progress::class);
    }

    public function exploratory()
    {
        return $this->hasOne(Exploratory::class);
    }

    public function interrogatory()
    {
        return $this->hasMany(VisitInterrogatory::class);
    }

    public function notificationsScheduled()
    {
        return $this->hasMany(NotificationScheduled::class);
    }

    public static function transformer()
    {
        return new VisitTransformer();
    }
}
