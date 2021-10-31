<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('user-index');
    }

    public function view(User $user, User $model)
    {
        return $user->hasPermissionTo('user-view');
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermissionTo('user-edit')
        || $user->id == $model->id;
    }

    public function manage(User $user, User $model)
    {
        return $user->hasPermissionTo('user-manage');
    }

    public function delete(User $user, User $model)
    {
        return $user->hasPermissionTo('user-delete');
    }

    public function ban(User $user, User $model)
    {
        return $user->hasPermissionTo('user-ban');
    }

    public function unban(User $user, User $model)
    {
        return $user->ban && $user->hasPermissionTo('user-ban');
    }
}
