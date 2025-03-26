<?php

namespace App\Policies;

use App\Models\ClientType;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ClientTypePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view type clients');  
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ClientType $clientType): bool
    {
        return $user->can('view type client');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create type client');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ClientType $clientType): bool
    {
        return $user->can('edit type client');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ClientType $clientType): bool
    {
        return $user->can('delete type client');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ClientType $clientType): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ClientType $clientType): bool
    {
        return true;
    }
}
