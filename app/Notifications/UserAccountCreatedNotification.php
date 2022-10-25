<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use Termwind\Enums\Color;

class UserAccountCreatedNotification extends DiscordNotification
{
    protected $color = Color::BLUE_500;
    protected $login;

    public function __construct($login)
    {
        $this->login = $login;
    }

    public function toDiscord()
    {
        return DiscordMessage::create(
            '',
            array_merge_recursive($this->getEmbed(), [
                'title' => 'Для Вас создан новый аккаунт!',
                'description' => 'Вы можете использовать указанные ниже данные для входа в игру.',
                'fields' => [
                    $this->loginData($this->login),
                ],
            ])
        );
    }
}
