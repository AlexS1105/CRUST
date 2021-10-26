<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;

class RegisteredNotification extends DiscordNotification
{
    public function toDiscord($notifiable)
    {
        $profileLink = route('users.edit', $notifiable);
        $createCharacterLink = route('characters.create');
        $appUrl = config('app.url');

        $embed = [
            'title' => "Добро пожаловать на ролевой проект Тесей, $notifiable->name!",
            'description' => "Вы успешно прошли регистрацию в нашей системе. Чтобы начать игру, Вам необходимо создать персонажа и дождаться его проверки нашими регистраторами.
            
            Для Вас был создан аккаунт на нашей [Вики]($appUrl). Используйте логин **$notifiable->name** и пароль, **указанный при регистрации** или просто нажмите [сюда]($appUrl) для автоматического входа.",
            'url' => $appUrl,
            'color' => 0x70a7ff,
            'fields' => [
                [
                    'name' => 'Что делать дальше?',
                    'value' => "1. [Создайте]($createCharacterLink) своего первого персонажа.
                    2. Подайте его на проверку
                    3. Ожидайте проверки
                    3.1. (Опционально) Внесите правки
                    4. Начните игру!"
                ],
                [
                    'name' => 'Оповещения',
                    'value' => "Если Вы не хотите получать оповещения от бота в ЛС, отключите эту настройку в своём [профиле]($profileLink)."
                ]
            ]
        ];
        
        return DiscordMessage::create('', array_merge($this->getEmbed(), $embed));
    }
}
