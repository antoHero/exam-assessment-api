<?php

namespace App\Policies;

use App\Enums\ProfileTypeEnum;
use App\Models\{Assessment, User};
use Illuminate\Auth\Access\Response;

class AssessmentPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return
            $user->profile->type === ProfileTypeEnum::ADMIN
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Assessment $assessment): Response
    {
        return
            $user->id === $assessment->user_id
            || $user->profile->type === ProfileTypeEnum::ADMIN
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Assessment $assessment): Response
    {
        return
            $user->id === $assessment->user_id
            || $user->profile->type === ProfileTypeEnum::ADMIN
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }
}
