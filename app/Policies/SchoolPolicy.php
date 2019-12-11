<?php

namespace App\Policies;

use App\Models\School;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolPolicy
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
        if ($user->isAdministrator()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function view(User $user, School $school)
    {
        //
    }

    /**
     * Determine whether the user can view the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isVerificator();
    }

    /**
     * Determine whether the user can create schools.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function update(User $user, School $school)
    {
        //
    }

    /**
     * Determine whether the user can delete the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function delete(User $user, School $school)
    {
        //
    }

    /**
     * Determine whether the user can restore the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function restore(User $user, School $school)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function forceDelete(User $user, School $school)
    {
        //
    }

    /**
     * Determine whether the user can bulk delete the school.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\School  $school
     * @return mixed
     */
    public function bulkDelete(User $user)
    {
        //
    }
}
