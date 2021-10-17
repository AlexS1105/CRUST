<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Models\Character;

class ApplicationController extends Controller
{
    public function index()
    {
        $status = request('status', CharacterStatus::Pending());
        return view('applications.index', [
            'status' => $status,
            'characters' => Character::where('status', $status)
                                    ->sortable()
                                    ->oldest('status_updated_at')
                                    ->paginate(10)
        ]);
    }

    public function send(Character $character)
    {
        $character->setStatus(CharacterStatus::Pending());
        return back();
    }

    public function cancel(Character $character)
    {
        $character->setStatus(CharacterStatus::Blank());
        return back();
    }

    public function takeForApproval(Character $character)
    {
        $character->takeForApproval();
        return back();
    }

    public function cancelApproval(Character $character)
    {
        $character->cancelApproval();
        return back();
    }

    public function approve(Character $character) {
        $character->setStatus(CharacterStatus::Approved());
        return back();
    }

    public function reapproval(Character $character) {
        $character->setStatus(CharacterStatus::Approval());
        return back();
    }
}
