<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class ApplicationApprovedNotification extends CharacterNotification
{
    protected $color = Color::EMERALD_400;

    public function toDiscord()
    {
        $character = $this->character;

        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => "Ваш персонаж '{$character->name}' одобрен!",
                'description' => 'Вы можете начать игру уже сейчас!',
                'fields' => [
                    $this->loginData($character->login),
                ],
            ])
        );
    }
}
