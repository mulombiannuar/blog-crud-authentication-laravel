<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class UserService
{
    //Activate user
    public function enableUser($id): void
    {
        $user = User::find($id);
        $user->status = 1;
        $user->save();
    }

    //Activate user
    public function disableUser($id): void
    {
        $user = User::find($id);
        $user->status = 0;
        $user->save();
    }
}
