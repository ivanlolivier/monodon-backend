<?php

namespace App\Policies;

use App\Models\Dentist;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    public function index($user)
    {
        return ($user instanceof Dentist);
    }
}
