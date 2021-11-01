<?php

namespace App\Policies;

use App\Enums\CharacterStatus;
use App\Models\Character;
use App\Models\User;
use App\Settings\GeneralSettings;

class CharacterPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->characters->count() < app(GeneralSettings::class)->max_characters
            || $user->hasPermissionTo('character-create-unlimited');
    }

    public function view(User $user, Character $character)
    {
        return $character->user_id === $user->id
            || $character->status == CharacterStatus::Approved()
            || $user->hasPermissionTo('character-view');
    }

    public function update(User $user, Character $character)
    {
        return $character->user_id === $user->id
            || $user->hasPermissionTo('character-edit');
    }

    public function delete(User $user, Character $character)
    {
        return $character->user_id === $user->id
            || $user->hasPermissionTo('character-delete');
    }

    public function forceDelete(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-force-delete');
    }

    public function restore(User $user, Character $character)
    {
        return $character->user_id === $user->id
            || $user->hasPermissionTo('character-restore');
    }

    public function viewApplications(User $user)
    {
        return $user->hasPermissionTo('application-index');
    }

    public function send(User $user, Character $character)
    {
        return $character->user_id === $user->id
            && $character->status == CharacterStatus::Blank();
    }

    public function cancel(User $user, Character $character)
    {
        return $character->user_id === $user->id
            && $character->status == CharacterStatus::Pending();
    }

    public function takeForApproval(User $user, Character $character)
    {
        return $character->user_id != $user->id
            && $user->hasPermissionTo('application-take-for-approval')
            && $character->status == CharacterStatus::Pending();
    }

    public function cancelApproval(User $user, Character $character)
    {
        return $character->user_id != $user->id
            && $user->hasPermissionTo('application-cancel-approval')
            && $character->status == CharacterStatus::Approval();
    }

    public function requestChanges(User $user, Character $character)
    {
        return $character->user_id != $user->id
            && $user->registrar->id == $user->id
            && $user->hasPermissionTo('application-request-changes')
            && $character->status == CharacterStatus::Approval();
    }

    public function requestApproval(User $user, Character $character)
    {
        return $character->user_id == $user->idate
            && $user->hasPermissionTo('application-request-approval')
            && $character->status == CharacterStatus::ChangesRequested();
    }
    
    public function approve(User $user, Character $character)
    {
        return $character->user_id != $user->id
            && $user->hasPermissionTo('application-approve')
            && $character->status == CharacterStatus::Approval();
    }

    public function reapproval(User $user, Character $character)
    {
        return ($character->user_id === $user->id
            || $user->hasPermissionTo('application-reapproval'))
            && $character->status == CharacterStatus::Approved();
    }

    public function seeMainInfo(User $user, Character $character)
    {
        return $character->info_hidden
            && ($character->user_id === $user->id
            || $user->hasPermissionTo('character-view'))
            || !$character->info_hidden;
    }

    public function seeVisuals(User $user, Character $character)
    {
        return true;
    }

    public function seeBio(User $user, Character $character)
    {
        return $character->bio_hidden
            && ($character->user_id === $user->id
            || $user->hasPermissionTo('character-view'))
            || !$character->bio_hidden;
    }
}
