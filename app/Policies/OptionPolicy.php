<?php

namespace App\Policies;

use App\Enums\ProfileTypeEnum;
use App\Models\{Option, Question, User};
use Illuminate\Auth\Access\Response;

class OptionPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Question $question): Response
    {
        return
            $user->id === $question->assessment->user_id
            || $user->profile->type === ProfileTypeEnum::ADMIN
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Option $option): Response
    {
        return
            $user->id === $option->question->assessment->user_id
            || $user->profile->type === ProfileTypeEnum::ADMIN
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Option $option): Response
    {
        return
            $user->id === $option->question->assessment->user_id
            || $user->profile->type === ProfileTypeEnum::ADMIN
            ? Response::allow()
            : Response::deny('You are not authorized to perform this action.');
    }
}
