<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function delete(User $currentUser, User $accountUser)
    {
        if ($currentUser->is_admin || $currentUser->id === $accountUser->id) {
            return true;
        }

        return false;
    }
}
