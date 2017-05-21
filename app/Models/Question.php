<?php

namespace App\Models;

use App\Transformers\QuestionTransformer;

class Question extends _Model
{
    public static function transformer()
    {
        return new QuestionTransformer();
    }
}
