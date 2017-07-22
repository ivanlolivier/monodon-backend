<?php

namespace App\Models;

use App\Transformers\VisitInterrogatoryTransformer;

class VisitInterrogatory extends _Model
{
    protected $table = 'visit_interrogation';

    protected $fillable = ['question_id', 'answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public static function transformer()
    {
        return new VisitInterrogatoryTransformer();
    }
}
