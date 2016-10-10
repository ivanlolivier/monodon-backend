<?php

namespace App\Models;

class File extends _Model
{
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
