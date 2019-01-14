<?php

namespace Hafael\Abstracts\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
{
    use HandlesAuthorization;

    protected $resourceName = 'resourceName';

    /**
     * Determine whether the user can view the User.
     *
     * @param  \App\User $user
     * @return boolean
     */
    public function view(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can create an User.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the User.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function update(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the User.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return true;
    }
}
