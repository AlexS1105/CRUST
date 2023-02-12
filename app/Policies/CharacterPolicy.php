<?php

namespace App\Policies;

use App\Enums\CharacterStatus;
use App\Models\Character;
use App\Models\User;
use App\Settings\GeneralSettings;

class CharacterPolicy
{
    public function viewAny()
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
            || $user->registers($character)
            || $character->status === CharacterStatus::Approved
            || $user->hasPermissionTo('character-view');
    }

    public function update(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->registers($character)
            || $user->hasPermissionTo('character-manage');
    }

    public function updateCharsheet(User $user, Character $character)
    {
        return (! $character->registered && $user->owns($character))
            || $user->registers($character)
            || $user->hasPermissionTo('character-manage');
    }

    public function updateCharsheetGm(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-manage');
    }

    public function delete(User $user, Character $character)
    {
        return $character->status !== CharacterStatus::Deleting
            && ($user->owns($character)
                || $user->hasPermissionTo('character-manage'));
    }

    public function forceDelete(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Deleting
            && $user->hasPermissionTo('character-force-delete');
    }

    public function restore(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Deleting
            && ($user->owns($character)
                || $user->hasPermissionTo('character-manage'));
    }

    public function viewApplications(User $user)
    {
        return $user->hasPermissionTo('application-view');
    }

    public function send(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Blank
            && ($user->owns($character) || $user->hasPermissionTo('application-admin'));
    }

    public function cancel(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Pending
            && ($user->owns($character) || $user->hasPermissionTo('application-admin'));
    }

    public function takeForApproval(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Pending
            && (! $user->owns($character)
                && $user->hasPermissionTo('application-approval')
                || $user->hasPermissionTo('application-admin'));
    }

    public function cancelApproval(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Approval
            && ($user->registers($character)
                && $user->hasPermissionTo('application-approval')
                || $user->hasPermissionTo('application-admin'));
    }

    public function requestChanges(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Approval
            && ($user->registers($character)
                && $user->hasPermissionTo('application-approval')
                || $user->hasPermissionTo('application-admin'));
    }

    public function requestApproval(User $user, Character $character)
    {
        return $character->status === CharacterStatus::ChangesRequested
            && ($user->owns($character)
                || $user->registers($character) && $user->hasPermissionTo('application-approval')
                || $user->hasPermissionTo('application-admin'));
    }

    public function approve(User $user, Character $character)
    {
        return ($character->status === CharacterStatus::Approval
                || $character->status === CharacterStatus::ChangesRequested)
            && ($user->registers($character)
                && $user->hasPermissionTo('application-approval')
                || $user->hasPermissionTo('application-admin'));
    }

    public function reapproval(User $user, Character $character)
    {
        return $character->status === CharacterStatus::Approved
            && ($user->owns($character)
                || $user->is($character->registrar)
                || $user->hasAnyPermission('application-reapproval', 'application-admin'));
    }

    public function seeMainInfo(User $user, Character $character)
    {
        return ! $character->info_hidden
            || $character->info_hidden
            && ($user->owns($character)
                || $user->is($character->registrar)
                || $user->hasPermissionTo('character-view'));
    }

    public function seeBio(User $user, Character $character)
    {
        return ! $character->bio_hidden
            || $character->bio_hidden
            && ($user->owns($character)
                || $user->is($character->registrar)
                || $user->hasPermissionTo('character-view'));
    }

    public function seePlayerOnlyInfo(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->is($character->registrar)
            || $user->hasPermissionTo('character-view');
    }

    public function seeGmOnlyInfo(User $user, Character $character)
    {
        return $user->registers($character)
            || $user->hasPermissionTo('character-view');
    }

    public function estitenceView(User $user, Character $character)
    {
        return $user->owns($character)
            || $user->hasPermissionTo('character-view');
    }

    public function estitenceCreate(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-estitence');
    }

    public function addSphere(User $user, Character $character)
    {
        return count($character->spheres) < 3
            && ($user->owns($character)
                && $character->registered
                || $user->hasPermissionTo('character-manage'));
    }

    public function addIdea(User $user, Character $character)
    {
        return count($character->ideas) < 3
            && ($user->owns($character)
                && $character->registered
                && $character->hasFreeIdea()
                || $user->hasPermissionTo('character-manage'));
    }

    public function ideaToSphere(User $user, Character $character)
    {
        return count($character->spheres) > 0
            && ($user->owns($character)
                || $user->hasPermissionTo('character-manage'));
    }

    public function manageIdeas(User $user, Character $character)
    {
        return $user->owns($character)
            && $character->registered
            || $user->hasPermissionTo('character-manage');
    }

    public function manageIdeasGm(User $user, Character $character)
    {
        return $user->hasPermissionTo('character-manage');
    }

    public function sphereToExperience(User $user, Character $character)
    {
        return count($character->experiences) > 0
            && $user->hasPermissionTo('character-manage');
    }

    public function queryCharacters(User $user)
    {
        return $user->hasPermissionTo('character-view');
    }

    public function updateStats(User $user, Character $character)
    {
        return $user->owns($character)
            && ($character->stats_inequality != 0
                || ! $character->registered)
            && (! $character->stats_handled)
            || $user->hasPermissionTo('character-manage')
            || $user->registers($character);
    }
}
