<?php

namespace App\Notifications;

use App\Models\Character;
use NotificationChannels\Discord\DiscordMessage;

class ApplicationApprovedNotification extends DiscordNotification
{
    public $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function toDiscord($notifiable)
    {
        $url = route('characters.show', $this->character);
        $character = $this->character;
        $registrar = $character->registrar;
        $appUrl = config('app.url');
        $embed = [
            'title' => "Ваш персонаж '$character->name' одобрен!",
            'description' => 'Вы можете начать игру уже сейчас!',
            'url' => $url,
            'timestamp' => now(),
            'color' => 0x34D399,
            'image' => [
                'url' => asset($character->reference)
            ],
            'author' => [
                'name' => $registrar->discord_tag,
            ],
            'fields' => [
                [
                    'name' => 'Пол',
                    'value' => $character->gender->description,
                    'inline' => true
                ],
                [
                    'name' => 'Раса',
                    'value' => $character->race,
                    'inline' => true
                ],
                [
                    'name' => 'Возраст',
                    'value' => $character->age,
                    'inline' => true
                ],
                [
                    'name' => 'Описание',
                    'value' => $character->description."

                    [**Страница персонажа**]($url)"
                ],
                [
                    'name' => '**Данные для входа**',
                    'value' => "**Логин:** $character->login
                    **Пароль:** Такой же, как у аккаунта здесь
                    
                    **Приятной игры!**
                    
                    [**Скачать лаунчер**]($appUrl)"
                ]
            ]
        ];

        return DiscordMessage::create('', array_merge($this->embed, $embed));
    }
}
