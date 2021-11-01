<?php

namespace App\Http\Controllers;

use App\Enums\CharacterStatus;
use App\Events\CharacterApprovalRequested;
use App\Events\CharacterApproved;
use App\Events\CharacterCanceled;
use App\Events\CharacterChangesRequested;
use App\Events\CharacterReapproval;
use App\Events\CharacterSent;
use App\Events\CharacterTaken;
use App\Models\Character;

class ApplicationController extends Controller
{
    public function index()
    {
        $characters = null;
        $search = request('search');
        $status = request('status', CharacterStatus::Pending());

        if (isset($search)) {
            $characters = Character::where('characters.name', 'like', '%'.$search.'%');
            $status = null;
        } else {
            $characters = Character::where('status', $status);
        }

        return view('applications.index', [
            'status' => $status,
            'search' => $search,
            'characters' => $characters->sortable()
                                        ->oldest('status_updated_at')
                                        ->paginate(10)
        ]);
    }

    public function send(Character $character)
    {
        $character->setStatus(CharacterStatus::Pending());

        event(new CharacterSent($character));

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

        event(new CharacterTaken($character));

        return back();
    }

    public function cancelApproval(Character $character)
    {
        $character->cancelApproval();

        event(new CharacterCanceled($character));

        return back();
    }

    public function requestChanges(Character $character)
    {
        $character->setStatus(CharacterStatus::ChangesRequested());

        event(new CharacterChangesRequested($character));

        return back();
    }

    public function requestApproval(Character $character)
    {
        $character->setStatus(CharacterStatus::Approval());

        event(new CharacterApprovalRequested($character));

        return back();
    }

    public function approve(Character $character)
    {
        $character->setStatus(CharacterStatus::Approved());

        event(new CharacterApproved($character));
        
        return back();
    }

    public function reapproval(Character $character)
    {
        $character->setStatus(CharacterStatus::Approval());

        event(new CharacterReapproval($character, auth()->user()));

        return back();
    }
}
