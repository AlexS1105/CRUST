<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;

class DiscordNotification extends Notification
{
    use Queueable;

    protected $registrarNotification = false;

    public function via($notifiable)
    {
        return $notifiable->verified && ($this->registrarNotification || $notifiable->discord_notify) ? [DiscordChannel::class] : [];
    }

    protected function getEmbed()
    {
        return [
            'type' => 'rich',
            'footer' => [
                'text' => config('app.name'),
                'icon_url' => 'https://i.imgur.com/NlCDmmT.png',
            ],
            'timestamp' => now(),
        ];
    }
}
