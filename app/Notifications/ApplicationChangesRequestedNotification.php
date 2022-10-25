<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class ApplicationChangesRequestedNotification extends CharacterNotification
{
    protected $color = Color::AMBER_500;

    public function toDiscord()
    {
        $character = $this->character;

        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => "Для вашего персонажа '{$character->name}' запрошены правки",
                'description' => "{$character->registrar->discord_tag} что-то не понравилось на странице Вашего персонажа.
            Спросите, что не так, внесите изменения и запросите проверку снова.",
            ])
        );
    }
}
