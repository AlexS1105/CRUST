<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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
            'users' => User::where('users.name', 'like', '%'.$search.'%')
                            ->latest('created_at')
                            ->sortable()
                            ->paginate(10)
        ]);
    }

    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        session()->put('url.intended', url()->previous());

        $can = request()->user()->can('user-manage', $user);
        return view('users.edit', [
            'user' => $user,
            'roles' => $can ? Role::with('permissions')->get() : [],
            'permissions' => $can ? Permission::all() : []
        ]);
    }

    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        if (request()->user()->can('manage', $user)) {
            if ($request->collect('roles'))
            {
                $user->syncRoles($request->collect('roles')->keys());
            }
    
            if ($request->collect('permissions'))
            {
                $user->syncPermissions($request->collect('permissions')->keys());
            }
        }

        return redirect()->intended('/');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('users.index'));
    }
}
