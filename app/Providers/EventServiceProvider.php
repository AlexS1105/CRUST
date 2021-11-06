<?php

namespace App\Providers;

use App\Events\CharacterApprovalRequested;
use App\Events\CharacterApproved;
use App\Events\CharacterCanceled;
use App\Events\CharacterChangesRequested;
use App\Events\CharacterCompletelyDeleted;
use App\Events\CharacterDeleted;
use App\Events\CharacterReapproval;
use App\Events\CharacterSent;
use App\Events\CharacterTaken;
use App\Listeners\CreateRegistrationTicket;
use App\Listeners\DeleteRegistrationTicket;
use App\Listeners\SendDiscordApplicationApprovalRequestedNotification;
use App\Listeners\SendDiscordApplicationApprovedNotification;
use App\Listeners\SendDiscordApplicationCanceledNotification;
use App\Listeners\SendDiscordApplicationChangesRequestedNotification;
use App\Listeners\SendDiscordApplicationReapprovalNotification;
use App\Listeners\SendDiscordApplicationTakenNotification;
use App\Listeners\SendDiscordCharacterCompleteDeletionNotification;
use App\Listeners\SendDiscordCharacterDeletionNotification;
use App\Listeners\SendDiscordNewApplicationNotification;
use App\Listeners\SendDiscordRegistrationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendDiscordRegistrationNotification::class
        ],
        CharacterDeleted::class => [
            SendDiscordCharacterDeletionNotification::class,
            DeleteRegistrationTicket::class
        ],
        CharacterCompletelyDeleted::class => [
            SendDiscordCharacterCompleteDeletionNotification::class
        ],
        CharacterSent::class => [
            SendDiscordNewApplicationNotification::class
        ],
        CharacterCanceled::class => [
            SendDiscordApplicationCanceledNotification::class,
            DeleteRegistrationTicket::class
        ],
        CharacterChangesRequested::class => [
            SendDiscordApplicationChangesRequestedNotification::class
        ],
        CharacterApprovalRequested::class => [
            SendDiscordApplicationApprovalRequestedNotification::class
        ],
        CharacterTaken::class => [
            CreateRegistrationTicket::class,
            SendDiscordApplicationTakenNotification::class
        ],
        CharacterApproved::class => [
            SendDiscordApplicationApprovedNotification::class,
            DeleteRegistrationTicket::class
        ],
        CharacterReapproval::class => [
            CreateRegistrationTicket::class,
            SendDiscordApplicationReapprovalNotification::class
        ]
    ];

    public function boot()
    {
        //
    }
}
