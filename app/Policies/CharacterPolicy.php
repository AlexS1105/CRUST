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
        return $user->owns($character)
            || $character->status === CharacterStatus::Approved()
            || $user->hasPermissionTo('character-view');
    }

    public function update(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-edit');
    }

    public function updateCharsheet(User $user, Character $character)
    {
        return (! $character->registered && $user->owns($character))
            || $user->hasPermissionTo('character-edit');
    }

    public function updateCharsheetGm(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-edit');
    }

    public function delete(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-delete');
    }

    public function forceDelete(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-force-delete');
    }

    public function restore(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-restore');
    }

    public function viewApplications(User $user)
    {
        return $user->hasPermissionTo('application-index');
    }

    public function send(User $user, Character $character)
    {
        return $user->owns($character)
            && $character->status === CharacterStatus::Blank();
    }

    public function cancel(User $user, Character $character)
    {
        return $user->owns($character)
            && $character->status === CharacterStatus::Pending();
    }

    public function takeForApproval(User $user, Character $character)
    {
        return $character->user_id !== $user->id
            && $user->hasPermissionTo('application-take-for-approval')
            && $character->status === CharacterStatus::Pending();
    }

    public function cancelApproval(User $user, Character $character)
    {
        return $character->user_id !== $user->id
            && $user->hasPermissionTo('application-cancel-approval')
            && $character->status === CharacterStatus::Approval();
    }

    public function requestChanges(User $user, Character $character)
    {
        return $character->user_id !== $user->id
            && $character->registrar->id === $user->id
            && $user->hasPermissionTo('application-request-changes')
            && $character->status === CharacterStatus::Approval();
    }

    public function requestApproval(User $user, Character $character)
    {
        return $user->owns($character)
            && $character->status === CharacterStatus::ChangesRequested()
            || $user->hasPermissionTo('application-request-approval');
    }

    public function approve(User $user, Character $character)
    {
        return $character->user_id !== $user->id
            && $user->hasPermissionTo('application-approve')
            && $character->status === CharacterStatus::Approval();
    }

    public function reapproval(User $user, Character $character)
    {
        return ($user->owns($character)
            || $user->hasPermissionTo('application-reapproval'))
            && $character->status === CharacterStatus::Approved();
    }

    public function seeMainInfo(User $user, Character $character)
    {
        return $character->info_hidden
            && ($user->owns($character)
            || $user->hasPermissionTo('character-view'))
            || ! $character->info_hidden;
    }

    public function seeVisuals(User $user, Character $character)
    {
        return true;
    }

    public function seeBio(User $user, Character $character)
    {
        return $character->bio_hidden
            && ($user->owns($character)
            || $user->hasPermissionTo('character-view'))
            || ! $character->bio_hidden;
    }

    public function seePlayerOnlyInfo(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-view');
    }

    public function seeGmOnlyInfo(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-view');
    }

    public function voxView(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-view');
    }

    public function voxCreate(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-create-vox');
    }

    public function togglePerks(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-edit');
    }

    public function addSphere(User $user, Character $character)
    {
        return count($character->spheres) < 3
            && (($user->owns($character) && $character->registered) || $user->hasPermissionTo('character-edit'));
    }

    public function addIdea(User $user, Character $character)
    {
        return count($character->ideas) < 3
            && (($user->owns($character) && $character->registered && $character->hasFreeIdea()) || $user->hasPermissionTo('character-edit'));
    }

    public function ideaToSphere(User $user, Character $character)
    {
        return count($character->spheres) > 0 && $user->hasPermissionTo('character-edit');
    }

    public function manageIdeas(User $user, Character $character)
    {
        return ($user->owns($character) && $character->registered) || $user->hasPermissionTo('character-edit');
    }

    public function manageIdeasGm(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-edit');
    }

    public function sphereToExperience(User $user, Character $character)
    {
        return count($character->experiences) > 0 && $user->hasPermissionTo('character-edit');
    }

    public function queryCharacters(User $user)
    {
        return $user->hasPermissionTo('character-view');
    }
}
