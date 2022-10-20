<?php

namespace App\Listeners;

use App\Events\CharacterApprovalRequested;
use App\Events\CharacterApproved;
use App\Events\CharacterCanceled;
use App\Events\CharacterChangesRequested;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use App\Events\CharacterReapproval;
use App\Events\CharacterSent;
use App\Events\CharacterTaken;
use App\Events\UserAccountCreated;
use App\Events\UserAccountDeleted;
use App\Jobs\Discord\CreateTicket;
use App\Jobs\Discord\DeleteTicket;
use App\Jobs\Discord\SendCharacterNotification;
use App\Jobs\Discord\SendRegistrarNotification;
use App\Jobs\Discord\SendUserNotification;
use App\Jobs\Discord\VerifyUser;
use App\Models\User;
use App\Notifications\ApplicationApprovalRequestedNotification;
use App\Notifications\ApplicationApprovedNotification;
use App\Notifications\ApplicationCanceledNotification;
use App\Notifications\ApplicationChangesRequestedNotification;
use App\Notifications\ApplicationReapprovalNotification;
use App\Notifications\ApplicationTakenNotification;
use App\Notifications\CharacterCompleteDeletionNotification;
use App\Notifications\CharacterDeletionNotification;
use App\Notifications\NewApplicationNotification;
use App\Notifications\RegisteredNotification;
use App\Notifications\UserAccountCreatedNotification;
use App\Notifications\UserAccountDeletedNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Bus;

class DiscordEventSubscriber
{
    public function handleRegistered($event)
    {
        Bus::chain([
            new VerifyUser($event->user),
            new SendUserNotification($event->user, new RegisteredNotification()),
        ])->dispatch();
    }

    public function handleCharacterDeleted($event)
    {
        $character = $event->character;

        Bus::chain([
            new SendCharacterNotification($character, new CharacterDeletionNotification($character)),
            new DeleteTicket($character),
        ])->dispatch();
    }

    public function handleCharacterCompletelyDeleted($event)
    {
        $character = $event->character;

        SendCharacterNotification::dispatch($character, new CharacterCompleteDeletionNotification($character));
    }

    public function handleCharacterSent($event)
    {
        $registrars = User::whereHas('roles', function ($q) {
            $q->where('name', 'like', 'registrar');
        })->get();

        foreach ($registrars as $registrar) {
            SendRegistrarNotification::dispatch($registrar, new NewApplicationNotification($event->character));
        }
    }

    public function handleCharacterCanceled($event)
    {
        $character = $event->character;

        Bus::chain([
            new SendCharacterNotification($character, new ApplicationCanceledNotification($character)),
            new DeleteTicket($character),
        ])->dispatch();
    }

    public function handleCharacterTaken($event)
    {
        $character = $event->character;

        Bus::chain([
            new CreateTicket($character),
            new SendCharacterNotification($character, new ApplicationTakenNotification($character)),
        ])->dispatch();
    }

    public function handleCharacterChangesRequested($event)
    {
        $character = $event->character;

        SendCharacterNotification::dispatch($character, new ApplicationChangesRequestedNotification($character));
    }

    public function handleCharacterApprovalRequested($event)
    {
        $character = $event->character;

        SendRegistrarNotification::dispatch(
            $character->registrar,
            new ApplicationApprovalRequestedNotification($character)
        );
    }

    public function handleCharacterApproved($event)
    {
        $character = $event->character;

        Bus::chain([
            new SendCharacterNotification($character, new ApplicationApprovedNotification($character)),
            new DeleteTicket($character),
        ])->dispatch();
    }

    public function handleCharacterReapproval($event)
    {
        $character = $event->character;
        $user = $event->user;
        $jobs = [
            new CreateTicket($character),
        ];

        if (! $user->is($character->user)) {
            array_push(
                $jobs,
                new SendCharacterNotification($character, new ApplicationReapprovalNotification($character, $user))
            );
        }

        if ($character->registrar->id !== $user->id) {
            array_push(
                $jobs,
                new SendRegistrarNotification(
                    $character->registrar,
                    new ApplicationReapprovalNotification($character, $user)
                )
            );
        }

        Bus::chain($jobs)->dispatch();
    }

    public function handleUserAccountCreated($event)
    {
        $account = $event->account;

        SendUserNotification::dispatch($account->user, new UserAccountCreatedNotification($account));
    }

    public function handleUserAccountDeleted($event)
    {
        $account = $event->account;

        SendUserNotification::dispatch($account->user, new UserAccountDeletedNotification($account->login));
    }

    public function subscribe($events)
    {
        return [
            Registered::class => 'handleRegistered',
            CharacterDeleted::class => 'handleCharacterDeleted',
            CharacterCompletelyDeleted::class => 'handleCharacterCompletelyDeleted',
            CharacterSent::class => 'handleCharacterSent',
            CharacterCanceled::class => 'handleCharacterCanceled',
            CharacterTaken::class => 'handleCharacterTaken',
            CharacterChangesRequested::class => 'handleCharacterChangesRequested',
            CharacterApprovalRequested::class => 'handleCharacterApprovalRequested',
            CharacterApproved::class => 'handleCharacterApproved',
            CharacterReapproval::class => 'handleCharacterReapproval',
            UserAccountCreated::class => 'handleUserAccountCreated',
            UserAccountDeleted::class => 'handleUserAccountDeleted',
        ];
    }
}
