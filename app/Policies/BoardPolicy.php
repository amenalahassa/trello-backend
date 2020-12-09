<?php

namespace App\Policies;

use App\Models\Boards;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BoardPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Boards  $boards
     * @return mixed
     */
    public function view(User $user, Boards $boards)
    {
        $canView = false;
        $ownable = $boards->ownable();
        $ownable_type = $boards->ownable_type;

        if ($ownable_type === "App\Models\User")
        {
            $canView = $user->id === $ownable->id;
        }

        if ($ownable_type === "App\Models\Team")
        {
            $canView = $ownable->user()->find($user->id) === null;
        }

        return $canView ? Response::allow()
            : Response::deny('You do not own this post.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Boards  $boards
     * @return mixed
     */
    public function update(User $user, Boards $boards)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Boards  $boards
     * @return mixed
     */
    public function delete(User $user, Boards $boards)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Boards  $boards
     * @return mixed
     */
    public function restore(User $user, Boards $boards)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Boards  $boards
     * @return mixed
     */
    public function forceDelete(User $user, Boards $boards)
    {
        //
    }
}
