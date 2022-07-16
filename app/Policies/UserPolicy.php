<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Log;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, $model)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, $model)
    {
        // organisator mag allen zich zelf updaten.
        if ($user->role == 'organisator' && $model->u_id == $user->u_id) {
            return true;
        }

        // Admin mag alles updaten.
        if ($user->role == 'admin') {
            return true;
        }
    }

    public function delete(User $user, $model)
    {
        // organisator mogen alleen zichzelf verwijderen.
        if ($user->role == 'organisator' && $model->u_id == $user->u_id) {
            return true;
        }

        // Admin mag alles updaten.
        if ($user->role == 'admin') {
            return true;
        }
    }

    public function replicate(User $user)
    {
        return false;
    }
}
