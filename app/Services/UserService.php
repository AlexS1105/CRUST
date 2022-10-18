<?php

namespace App\Services;

class UserService
{
    public function updateUser($request, $user)
    {
        $user->update($request->validated());

        if ($request->user()->can('manage', $user)) {
            $user->syncRoles($request->collect('roles')->keys());
            $user->syncPermissions($request->collect('permissions')->keys());
        }
    }
}
