<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('user-view');
    }

    public function view(User $user, User $model)
    {
        return $user->hasPermissionTo('user-view')
            || $user->is($model);
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermissionTo('user-edit')
            || $user->is($model);
    }

    public function manage(User $user, User $model)
    {
        return $user->hasPermissionTo('user-manage');
    }

    public function delete(User $user, User $model)
    {
        return $user->hasPermissionTo('user-ban')
            && ! $user->is($model);
    }

    public function ban(User $user, User $model)
    {
        return $user->hasPermissionTo('user-ban')
            && ! $user->is($model);
    }

    public function unban(User $user, User $model)
    {
        return $user->hasPermissionTo('user-ban')
            && ! $user->is($model);
    }

    public function accounts(User $user, User $model)
    {
        return $user->hasPermissionTo('user-accounts');
    }
}
