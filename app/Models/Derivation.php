<?php

namespace App\Models;

use App\Transformers\DerivationTransformer;

class Derivation extends _Model
{
    protected $fillable = [
        'contact_name',
        'contact_phone',
        'contact_email',
        'reason'
    ];

    public function diagnosis()
    {
        return $this->belongsTo(Diagnosis::class);
    }

    public static function transformer()
    {
        return new DerivationTransformer();
    }
}
