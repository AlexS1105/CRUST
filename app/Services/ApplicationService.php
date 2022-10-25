<?php

namespace App\Services;

use App\Enums\CharacterStatus;
use App\Events\CharacterApprovalRequested;
use App\Events\CharacterApproved;
use App\Events\CharacterCanceled;
use App\Events\CharacterChangesRequested;
use App\Events\CharacterReapproval;
use App\Events\CharacterSent;
use App\Events\CharacterTaken;

class ApplicationService
{
    public function send($character)
    {
        $character->status = CharacterStatus::Pending;
        $character->save();

        event(new CharacterSent($character));
    }

    public function cancel($character)
    {
        $character->status = CharacterStatus::Blank;
        $character->save();
    }

    public function takeForApproval($character)
    {
        $character->status = CharacterStatus::Approval;
        $character->registrar_id = auth()->id();
        $character->save();

        event(new CharacterTaken($character));
    }

    public function cancelApproval($character)
    {
        event(new CharacterCanceled($character));

        $character->status = CharacterStatus::Pending;
        $character->save();
    }

    public function changesRequested($character)
    {
        $character->status = CharacterStatus::ChangesRequested;
        $character->save();

        event(new CharacterChangesRequested($character));
    }

    public function requestApproval($character)
    {
        $character->status = CharacterStatus::Approval;
        $character->save();

        event(new CharacterApprovalRequested($character));
    }

    public function approve($character)
    {
        $character->status = CharacterStatus::Approved;
        $character->registered = true;
        $character->save();

        event(new CharacterApproved($character));
    }

    public function reapproval($character)
    {
        $character->status = CharacterStatus::Approval;
        $character->save();

        event(new CharacterReapproval($character, auth()->user()));
    }
}
