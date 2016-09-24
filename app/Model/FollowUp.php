<?php

namespace App\Model;

abstract class FollowUp extends Visit
{
    public function parent()
    {
        return $this->hasOne(Visit::class, 'id', 'parent_visit_id');
    }
}
