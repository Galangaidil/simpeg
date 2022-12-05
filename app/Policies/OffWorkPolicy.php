<?php

namespace App\Policies;

use App\Models\OffWork;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OffWorkPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param OffWork $leave
     * @return bool
     */
    public function manage(User $user, OffWork $leave): bool
    {
        return $user->role_id == Role::isOwner || $leave->user_id == $user->id;
    }

    /**
     * @param User $user
     * @return bool
     */

    public function updateStatus(User $user): bool
    {
        return $user->role_id === Role::isOwner;
    }
}
