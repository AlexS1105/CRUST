<?php

namespace App\Notifications;

use NotificationChannels\Discord\DiscordMessage;
use App\Models\Character;

class ApplicationTakenNotification extends DiscordNotification
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
        $embed = [
            'title' => "Ваш персонаж '$character->name' взят на проверку!",
            'description' => "Регистратор $registrar->name проверит её как можно скорее.",
            'url' => $url,
            'color' => 0x60A5FA,
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
                ]
            ]
        ];

        return DiscordMessage::create('', array_merge($this->getEmbed(), $embed));
    }
}
