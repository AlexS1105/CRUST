<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class CharacterCompleteDeletionNotification extends CharacterNotification
{
    protected $color = Color::RED_500;

    public function toDiscord()
    {
        return DiscordMessage::create(
            '',
            array_merge($this->getEmbed(), [
                'title' => "Ваш персонаж '{$this->character->name}' полностью удалён",
                'description' => 'Его нельзя восстановить.

            ***Помянем***',
            ])
        );
    }
}
