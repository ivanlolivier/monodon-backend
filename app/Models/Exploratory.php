<?php

namespace App\Models;

class Exploratory extends _Model
{
    protected $table = 'exploratory';

    protected $casts = [
        'mouth_photo' => 'json'
    ];

    public function visit()
    {
        return $this->hasOne(_Visit::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
