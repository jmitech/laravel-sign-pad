<?php

namespace Jmitech\LaravelSignPad\Policies;

use App\Models\User;
use Jmitech\LaravelSignPad\SignatureRequirement;

class SignatureRequirementPolicy
{
    public function isOwnFile(User $user, SignatureRequirement $signatureRequirement): bool
    {
        return $user->id === $signatureRequirement->file->model_id
            && $signatureRequirement->file->model_type == User::class;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('view any signature requirements');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SignatureRequirement $SignatureRequirement): bool
    {
        return $this->isOwnFile($user, $SignatureRequirement)
            || $user->hasPermissionTo('view any signature requirements');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('apply signature requirement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SignatureRequirement $SignatureRequirement): bool
    {
        return $user->hasPermissionTo('update signature requirements');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SignatureRequirement $SignatureRequirement): bool
    {
        return $user->hasPermissionTo('delete signature requirements');
    }
}
