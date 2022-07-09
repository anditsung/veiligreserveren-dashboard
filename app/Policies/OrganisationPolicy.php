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
        return true;
    }
 
    public function update(User $user, $model)
    {
        return true;
    }
}