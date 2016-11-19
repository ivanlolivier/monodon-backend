<?php

namespace App\Models;

use App\Transformers\VisitTransformer;

class Visit extends _Model
{

    public function parent()
    {
        return $this->belongsTo(Visit::class, 'id', 'parent_visit_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
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

    public static function transformer()
    {
        return new VisitTransformer();
    }
}
