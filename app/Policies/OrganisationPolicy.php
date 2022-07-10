<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganisationPolicy
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
        if($user->role == 'admin' || $user->u_orgid == null) {
            return true;
        } else {
            return false;
        }
    }
 
    public function update(User $user, $model)
    {
        return true;
    }

    public function delete(User $user, $model)
    {
        return false;
    }

    public function replicate(User $user)
    {
        return false;
    }
}
