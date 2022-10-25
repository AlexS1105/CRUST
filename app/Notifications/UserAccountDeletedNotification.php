<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class UserAccountDeletedNotification extends DiscordNotification
{
    protected $color = Color::RED_500;
    protected $login;

    public function __construct(string $login)
    {
        $this->login = $login;
    }

    public function toDiscord()
    {
        return DiscordMessage::create(
            '',
            array_merge($this->getEmbed(), [
                'title' => "Ваш аккаунт {$this->login} был удалён",
                'description' => 'Больше зайти в игру через него нельзя.',
            ])
        );
    }
}
