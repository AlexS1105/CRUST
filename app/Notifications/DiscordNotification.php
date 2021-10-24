<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use NotificationChannels\Discord\DiscordChannel;

class DiscordNotification extends Notification
{
    use Queueable;

    public $embed = [
        'type' => 'rich',
        'footer' => [
            'text' => 'Система Тесея',
            'icon_url' => 'https://i.imgur.com/NlCDmmT.png'
        ],
    ];

    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }
}
