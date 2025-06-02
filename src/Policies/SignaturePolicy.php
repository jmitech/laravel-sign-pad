<?php

namespace Jmitech\LaravelSignPad\Policies;

use App\Models\User;
use Jmitech\LaravelSignPad\Signature;

class SignaturePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any signed document');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Signature $signature): bool
    {
        $model = $signature->model;

        return ($user->id == $model->model_id and $model->model_type == User::class)
            or $user->hasPermissionTo('view any signed document');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Signature $signature): bool
    {
        return $user->hasPermissionTo('delete signatures');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Signature $signature): bool
    {
        return $this->delete($user, $signature);
    }
}
