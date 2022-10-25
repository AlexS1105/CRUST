<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class ApplicationTakenNotification extends CharacterNotification
{
    protected $color = Color::BLUE_500;

    public function toDiscord()
    {
        $character = $this->character;

        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => "Ваш персонаж '{$character->name}' взят на проверку!",
                'description' => "Регистратор {$character->registrar->discord_tag} проверит её как можно скорее.",
            ])
        );
    }
}
