<?php

namespace App\Notifications;

use App\Models\Character;
use App\Models\User;
use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class ApplicationReapprovalNotification extends CharacterNotification
{
    protected $color = Color::AMBER_500;
    protected $user;

    public function __construct(Character $character, User $user)
    {
        parent::__construct($character);

        $this->user = $user;
    }

    public function toDiscord($notifiable)
    {
        $character = $this->character;
        $user = $this->user;

        return DiscordMessage::create(
            '',
            array_merge($this->getEmbed(), [
                'title' => ($notifiable->is(
                    $character->user
                ) ? 'Ваш' : 'Проверенный Вами')." персонаж '{$character->name}' отправлен на перепроверку",
                'description' => "{$user->discord_tag} что-то не понравилось.

            Игровой аккаунт отключен до повторной проверки регистратором {$character->registrar->discord_tag}.",
                'author' => $this->authorField($user, false),
            ])
        );
    }
}
