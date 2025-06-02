<?php

namespace Jmitech\LaravelSignPad\Policies;

use App\Models\User;
use Jmitech\LaravelSignPad\SignatureTemplate;

class SignatureTemplatePolicy
{
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasPermissionTo('manage signature templates'))
            return true;

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SignatureTemplate $signatureTemplate): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SignatureTemplate $signatureTemplate): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SignatureTemplate $signatureTemplate): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SignatureTemplate $signatureTemplate): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SignatureTemplate $signatureTemplate): bool
    {
        return $user->hasPermissionTo('manage signature templates');
    }
}
