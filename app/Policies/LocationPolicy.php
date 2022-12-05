<?php

namespace App\Policies;

use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->role_id == Role::isOwner;
    }
}
