<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Verificator;
use Illuminate\Auth\Access\HandlesAuthorization;

class VerificatorPolicy
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
     * Determine whether the user can view the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function view(User $user, Verificator $verificator)
    {
        //
    }

    /**
     * Determine whether the user can view the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can create verificators.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function update(User $user, Verificator $verificator)
    {
        //
    }

    /**
     * Determine whether the user can delete the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function delete(User $user, Verificator $verificator)
    {
        //
    }

    /**
     * Determine whether the user can restore the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function restore(User $user, Verificator $verificator)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function forceDelete(User $user, Verificator $verificator)
    {
        //
    }

    /**
     * Determine whether the user can bulk delete the verificator.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Verificator  $verificator
     * @return mixed
     */
    public function bulkDelete(User $user)
    {
        //
    }
}
