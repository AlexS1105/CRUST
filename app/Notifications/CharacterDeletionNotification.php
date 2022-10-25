<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class CharacterDeletionNotification extends CharacterNotification
{
    protected $color = Color::RED_500;

    public function toDiscord()
    {
        return DiscordMessage::create(
            '',
            array_merge($this->getEmbed(), [
                'title' => "Ваш персонаж '{$this->character->name}' скоро будет удалён",
                'description' => 'Это произойдет автоматически через некоторое время.
            До этого момента его всё ещё можно будет восстановить!',
            ])
        );
    }
}
