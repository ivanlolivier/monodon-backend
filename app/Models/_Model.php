<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class _Model extends Eloquent
{
    abstract public static function transformer();

    public function transform()
    {
        return $this::transformer()->transform($this);
    }
}
