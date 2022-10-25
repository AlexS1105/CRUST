<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;

class RegisteredNotification extends DiscordNotification
{
    public function toDiscord($notifiable)
    {
        $profileLink = route('users.edit', $notifiable);
        $createCharacterLink = route('characters.create');
        $wikiLink = route('wiki.index');

        return DiscordMessage::create(
            '',
            array_merge($this->getEmbed(), [
                'title' => "Добро пожаловать на ролевой проект Тесей, {$notifiable->login}!",
                'description' => "Вы успешно прошли регистрацию в нашей системе.
            Чтобы начать игру, Вам необходимо [создать персонажа]({$createCharacterLink}) и дождаться его проверки нашими регистраторами.

            А ещё, теперь Вы можете [войти]({$wikiLink}) на нашу вики.",
                'fields' => [
                    [
                        'name' => 'Что делать дальше?',
                        'value' => "1. [Создайте]({$createCharacterLink}) своего первого персонажа.
                    2. Подайте его на проверку
                    3. Ожидайте проверки
                    3.1. (Опционально) Внесите правки
                    4. Начните игру!",
                    ],
                    [
                        'name' => 'Оповещения',
                        'value' => "Если Вы не хотите получать оповещения от бота в ЛС, отключите эту настройку в своём [профиле]({$profileLink}).",
                    ],
                ],
            ])
        );
    }
}
