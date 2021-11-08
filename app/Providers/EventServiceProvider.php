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
use App\Listeners\DiscordEventSubscriber;
use App\Listeners\SendDiscordApplicationApprovalRequestedNotification;
use App\Listeners\SendDiscordApplicationApprovedNotification;
use App\Listeners\SendDiscordApplicationCanceledNotification;
use App\Listeners\SendDiscordApplicationChangesRequestedNotification;
use App\Listeners\SendDiscordApplicationReapprovalNotification;
use App\Listeners\SendDiscordApplicationTakenNotification;
use App\Listeners\SendDiscordCharacterCompleteDeletionNotification;
use App\Listeners\SendDiscordCharacterDeletionNotification;
use App\Listeners\SendDiscordNewApplicationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        DiscordEventSubscriber::class
    ];

    public function boot()
    {
        //
    }
}
