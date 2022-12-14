<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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
        return true;
    }

    public function delete(User $user, $model)
    {
        return true;
    }

    public function replicate(User $user)
    {
        return false;
    }
}
