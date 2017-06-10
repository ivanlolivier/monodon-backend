<?php

namespace App\Models;

use App\Transformers\ProgressTransformer;

class Progress extends _Model
{
    protected $fillable = ['description'];

    public function treatment_assigned()
    {
        return $this->belongsTo(TreatmentAssigned::class);
    }

    public function parent()
    {
        return $this->belongsTo(Progress::class, 'id', 'parent_progress_id');
    }

    public static function transformer()
    {
        return new ProgressTransformer();
    }
}
