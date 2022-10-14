<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $search = request('search');
        return view('users.index', [
            'search' => $search,
            'users' => User::where('users.login', 'like', '%'.$search.'%')
                ->latest('created_at')
                ->sortable()
                ->paginate(20),
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        session()->put('url.intended', url()->previous());

        $can = request()->user()->can('user-manage', $user);
        return view('users.edit', [
            'user' => $user,
            'roles' => $can ? Role::with('permissions')->get() : [],
            'permissions' => $can ? Permission::all() : [],
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        if (request()->user()->can('manage', $user)) {
            $user->syncRoles($request->collect('roles')->keys());
            $user->syncPermissions($request->collect('permissions')->keys());
        }

        return redirect()->intended('/');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('users.index'));
    }
}
