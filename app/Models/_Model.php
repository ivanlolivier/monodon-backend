<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use OwenIt\Auditing\Contracts\Auditable;

abstract class _Model extends Eloquent implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    abstract public static function transformer();

    public function transform()
    {
        return $this::transformer()->transform($this);
    }
}
