<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;

class UserAccountDeletedNotification extends DiscordNotification
{
    public $login;

    public function __construct(string $login)
    {
        $this->login = $login;
    }

    public function toDiscord($notifiable)
    {
        $appUrl = config('app.url');

        $embed = [
            'title' => "Ваш аккаунт {$this->login} был удалён",
            'description' => 'Больше зайти в игру через него нельзя.',
            'url' => $appUrl,
            'color' => 0xe06666,
        ];

        return DiscordMessage::create('', array_merge($this->getEmbed(), $embed));
    }
}
