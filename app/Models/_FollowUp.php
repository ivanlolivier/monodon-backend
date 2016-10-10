<?php

namespace App\Models;

abstract class _FollowUp extends Visit
{
    public function parent()
    {
        return $this->hasOne(Visit::class, 'id', 'parent_visit_id');
    }
}
