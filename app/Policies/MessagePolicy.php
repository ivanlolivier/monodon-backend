<?php

namespace App\Policies;

use App\Models\Clinic;
use App\Models\Employee;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    public function listForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }

    public function showForClinic($user, Message $message)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($message->clinic);
        }

        return false;
    }

    public function createForClinic($user, Clinic $clinic)
    {
        if ($user instanceof Employee) {
            return $user->worksOn($clinic);
        }

        return false;
    }
}
