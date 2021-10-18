<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;
use App\Settings\GeneralSettings;

class CharacterPolicy
{
    public function viewAny(User $user) {
        return true;
    }

    public function create(User $user) {
        return $user->characters->count() < app(GeneralSettings::class)->max_characters;
    }

    public function view(User $user, Character $character) {
        return $character->user_id === $user->id
            || $user->hasPermissionTo('character-view');
    }

    public function update(User $user, Character $character) {
        return $character->user_id === $user->id
            || $user->hasPermissionTo('character-edit');
    }

    public function delete(User $user, Character $character) {
        return $character->user_id === $user->id
            || $user->hasPermissionTo('character-delete');
    }

    public function forceDelete(User $user, Character $character) {
        return $user->hasPermissionTo('character-force-delete');
    }

    public function restore(User $user, Character $character) {
        return $character->user_id === $user->id
        || $user->hasPermissionTo('character-restore');
    }

    public function viewApplications(User $user) {
        return $user->hasPermissionTo('application-index');
    }

    public function send(User $user, Character $character) {
        return $character->user_id === $user->id;
    }

    public function cancel(User $user, Character $character) {
        return $character->user_id === $user->id;
    }

    public function takeForApproval(User $user, Character $character) {
        return $character->user_id != $user->id
            && $user->hasPermissionTo('application-take-for-approval');
    }

    public function cancelApproval(User $user, Character $character) {
        return $character->user_id != $user->id
            && $user->hasPermissionTo('application-cancel-approval');
    }

    public function approve(User $user, Character $character) {
        return $character->user_id != $user->id
            && $user->hasPermissionTo('application-approve');
    }

    public function reapproval(User $user, Character $character) {
        return $character->user_id === $user->id
        || $user->hasPermissionTo('application-reapproval');
    }
}
