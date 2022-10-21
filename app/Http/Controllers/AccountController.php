<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\User;
use App\Services\AccountService;

class AccountController extends Controller
{
    public function index(User $user)
    {
        $this->authorize('accounts', $user);

        return view('accounts.index', compact('user'));
    }

    public function create(User $user)
    {
        $this->authorize('accounts', $user);

        return view('accounts.create', compact('user'));
    }

    public function store(AccountService $accountService, User $user, AccountRequest $request)
    {
        $this->authorize('accounts', $user);

        $accountService->createAccount($user, $request->validated());

        return to_route('users.accounts.index', $user);
    }

    public function destroy(AccountService $accountService, User $user, Account $account)
    {
        $this->authorize('accounts', $user);

        $accountService->deleteAccount($account);

        return to_route('users.accounts.index', $user);
    }
}
