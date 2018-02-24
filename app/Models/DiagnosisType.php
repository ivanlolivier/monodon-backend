<?php

namespace App\Models;

use App\Transformers\DiagnosisTypeTransformer;

class DiagnosisType extends _Model
{
    public static function transformer()
    {
        return new DiagnosisTypeTransformer();
    }
}
