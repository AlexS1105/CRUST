<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class ApplicationApprovalRequestedNotification extends CharacterNotification
{
    protected $color = Color::AMBER_500;
    protected $registrarNotification = true;

    public function toDiscord()
    {
        $character = $this->character;

        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => "Для проверяемого Вами персонажа '{$character->name}' внесены необходимые правки",
                'description' => 'Пожалуйста, закончите проверку как можно скорее.',
            ])
        );
    }
}
