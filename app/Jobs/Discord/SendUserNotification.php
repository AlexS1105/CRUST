<?php

namespace App\Jobs\Discord;

use App\Jobs\UserJob;
use App\Models\User;
use Illuminate\Notifications\Notification;

class SendUserNotification extends UserJob
{
    public $notification;

    public function __construct(User $user, Notification $notification)
    {
        parent::__construct($user);
        $this->notification = $notification;
    }

    public function handle()
    {
        $this->user->notify($this->notification);
    }
}
