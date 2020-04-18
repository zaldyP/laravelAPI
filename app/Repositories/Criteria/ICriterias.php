<?php

namespace App\Repositories\Criteria;

interface ICriterias
{
    public function withCriteria(... $criteria);
}