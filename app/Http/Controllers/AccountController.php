<?php

namespace App\Http\Controllers;

use App\Events\UserAccountCreated;
use App\Events\UserAccountDeleted;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\User;

class AccountController extends Controller
{
    public function index(User $user)
    {
        $this->authorize('accounts', $user);
        session()->put('url.intended', url()->previous());
        return view('accounts.index', [
            'user' => $user,
            'accounts' => $user->accounts,
        ]);
    }

    public function create(User $user)
    {
        $this->authorize('createAccount', $user);
        session()->put('url.intended', url()->previous());
        return view('accounts.create', [
            'user' => $user,
        ]);
    }

    public function store(User $user, AccountRequest $request)
    {
        $this->authorize('createAccount', $user);
        $account = $user->accounts()->create($request->validated());
        event(new UserAccountCreated($account));
        return redirect()->intended('/');
    }

    public function destroy(Account $account)
    {
        $this->authorize('deleteAccount', $account->user);
        event(new UserAccountDeleted($account));
        $account->delete();
        return back();
    }
}
