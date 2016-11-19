<?php

namespace App\Models;

abstract class _FollowUp extends _Visit
{
    public function parent()
    {
        return $this->hasOne(_Visit::class, 'id', 'parent_visit_id');
    }
}
