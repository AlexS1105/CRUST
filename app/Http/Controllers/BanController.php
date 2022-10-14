<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanRequest;
use App\Models\Ban;
use App\Models\User;
use App\Services\BanService;

class BanController extends Controller
{
    public function create(User $user)
    {
        $this->authorize('ban', $user);

        return view('ban.create', compact('user'));
    }

    public function store(BanService $banService, BanRequest $request, User $user)
    {
        $this->authorize('ban', $user);

        $banService->ban($user, $request->validated());

        return to_route('users.show', $user);
    }

    public function destroy(User $user, Ban $ban)
    {
        $this->authorize('unban', $user);

        $ban->delete();

        return back();
    }
}
