<?php

namespace App\Models;

use App\Transformers\ExploratoryTransformer;

class Exploratory extends _Model
{
    protected $table = 'exploratory';

    protected $fillable = ['mouth_photo'];

    protected $casts = [
        'mouth_photo' => 'json'
    ];

    public function visit()
    {
        return $this->hasOne(_Visit::class);
    }

    public static function transformer()
    {
        return new ExploratoryTransformer();
    }
}
