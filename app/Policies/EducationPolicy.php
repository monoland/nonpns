<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationPolicy
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
     * Determine whether the user can view the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function view(User $user, Education $education)
    {
        //
    }

    /**
     * Determine whether the user can view the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create education.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function update(User $user, Education $education)
    {
        //
    }

    /**
     * Determine whether the user can delete the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function delete(User $user, Education $education)
    {
        //
    }

    /**
     * Determine whether the user can restore the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function restore(User $user, Education $education)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function forceDelete(User $user, Education $education)
    {
        //
    }

    /**
     * Determine whether the user can bulk delete the education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return mixed
     */
    public function bulkDelete(User $user)
    {
        //
    }
}
