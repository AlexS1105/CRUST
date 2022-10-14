<?php

namespace App\Http\Controllers;

use App\Http\Requests\BanRequest;
use App\Models\Ban;
use App\Models\User;

class BanController extends Controller
{
    public function create(User $user)
    {
        $this->authorize('ban', $user);
        session()->put('url.intended', url()->previous());
        return view('ban.create', [
            'user' => $user,
        ]);
    }

    public function store(BanRequest $request, User $user)
    {
        $this->authorize('ban', $user);

        $ban = $request->validated();
        $ban['banned_by'] = auth()->id();
        $ban['user_id'] = $user->id;

        Ban::updateOrCreate([
            'user_id' => $user->id,
        ], $ban);

        return redirect()->intended('/');
    }

    public function destroy(Ban $ban)
    {
        $user = $ban->user;
        $this->authorize('ban', $user);
        $ban->delete();
        return back();
    }
}
