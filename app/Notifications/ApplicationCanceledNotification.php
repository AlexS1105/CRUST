<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class ApplicationCanceledNotification extends CharacterNotification
{
    protected $color = Color::AMBER_500;

    public function toDiscord()
    {
        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => "Ваш персонаж '{$this->character->name}' снят с проверки",
                'description' => '*Что-то пошло не так*

            Новый регистратор возьмёт Вашего персонажа на проверку в ближайшее время.',
            ])
        );
    }
}
