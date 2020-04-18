<?php

namespace App\Repositories\Eloquent\Criteria;

use App\Repositories\Criteria\ICriterion;

class LatestFirst implements ICriterion
{
    public function apply($model)
    {
        //return $model->orderBy('created_at');
        return $model->latest();
    }
}
