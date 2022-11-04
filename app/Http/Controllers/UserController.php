<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::search($search, 'login')
            ->latest('created_at')
            ->sortable()
            ->paginate(20);

        return view('users.index', compact('users', 'search'));
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $can = request()->user()->can('user-manage', $user);
        $roles = $can ? Role::with('permissions')->get() : [];
        $permissions = $can ? Permission::all() : [];

        return view('users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(UserService $userService, UserRequest $request, User $user)
    {
        $userService->updateUser($request, $user);

        return to_route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index');
    }
}
