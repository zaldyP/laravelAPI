<?php

namespace App\Repositories\Eloquent;


use App\Models\Invitation;

use App\Repositories\Contracts\IInvitation;

class InvitationRepository extends BaseRepository implements IInvitation
{
    public function model()
    {
        return Invitation::class; // 'App\Models\User'
    }

    public function addUserToTeam($team, $user_id)
    {
       return $team->members()->attach($user_id);

    }
    public function removeUserFromTeam($team, $user_id)
    {
        return $team->members()->detach($user_id);
    }
}