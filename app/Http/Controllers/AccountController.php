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
        return view('accounts.index', compact('user'));
    }

    public function create(User $user)
    {
        return view('accounts.create', compact('user'));
    }

    public function store(AccountService $accountService, User $user, AccountRequest $request)
    {
        $accountService->createAccount($user, $request->validated());

        return to_route('users.accounts.index', $user);
    }

    public function destroy(AccountService $accountService, User $user, Account $account)
    {
        $accountService->deleteAccount($account);

        return to_route('users.accounts.index', $user);
    }
}
