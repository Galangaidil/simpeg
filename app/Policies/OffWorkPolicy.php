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
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OffWork  $offWork
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, OffWork $offWork)
    {
        return $user->id === $offWork->user_id || $user->role_id === Role::isOwner;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OffWork  $offWork
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, OffWork $offWork)
    {
        return $user->id === $offWork->user_id || $user->role_id === Role::isOwner;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\OffWork  $offWork
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, OffWork $offWork)
    {
        return $user->id === $offWork->user_id || $user->role_id === Role::isOwner;
    }

    /**
     * @param User $user
     * @return bool
     */

    public function updateStatus(User $user)
    {
        return $user->role_id === Role::isOwner;
    }
}
