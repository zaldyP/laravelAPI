<?php

namespace App\Repositories\Eloquent;


use App\Models\Team;
use App\Repositories\Contracts\ITeam;


class TeamRepository extends BaseRepository implements ITeam
{
    public function model()
    {
        return Team::class; // 'App\Models\User'
    }

    public function fetchUserTeams()
    {
        return auth()->user()->teams;
    }
}