<?php

namespace App\Policies;

use App\Models\Requirement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequirementPolicy
{
    use HandlesAuthorization;

    /**
     * filter function
     *
     * @param [type] $user
     * @param [type] $ability
     * @return void
     */
    public function before($user, $ability)
    {
        if ($user->isOperator() || $user->isAdministrator()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function view(User $user, Requirement $requirement)
    {
        //
    }

    /**
     * Determine whether the user can view the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create requirements.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function update(User $user, Requirement $requirement)
    {
        //
    }

    /**
     * Determine whether the user can delete the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function delete(User $user, Requirement $requirement)
    {
        //
    }

    /**
     * Determine whether the user can restore the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function restore(User $user, Requirement $requirement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function forceDelete(User $user, Requirement $requirement)
    {
        //
    }

    /**
     * Determine whether the user can bulk delete the requirement.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Requirement  $requirement
     * @return mixed
     */
    public function bulkDelete(User $user)
    {
        //
    }
}
