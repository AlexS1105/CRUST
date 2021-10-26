<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use NotificationChannels\Discord\DiscordChannel;

class DiscordNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return [DiscordChannel::class];
    }

    protected function getEmbed()
    {
        return [
            'type' => 'rich',
            'footer' => [
                'text' => config('app.name'),
                'icon_url' => 'https://i.imgur.com/NlCDmmT.png'
            ],
            'timestamp' => now()
        ];
    }
}
