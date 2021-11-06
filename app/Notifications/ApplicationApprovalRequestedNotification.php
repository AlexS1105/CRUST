<?php

namespace App\Notifications;

use App\Models\Character;
use NotificationChannels\Discord\DiscordMessage;

class ApplicationApprovalRequestedNotification extends DiscordNotification
{
    public $character;

    public function __construct(Character $character)
    {
        $this->character = $character;
        $this->registrarNotification = true;
    }

    public function toDiscord($notifiable)
    {
        $url = route('characters.show', $this->character);
        $character = $this->character;
        $embed = [
            'title' => "Для проверяемого Вами персонажа '$character->name' внесены необходимые правки",
            'description' => 'Пожалуйста, закончите проверку как можно скорее.',
            'url' => $url,
            'color' => 0xFCD34D,
            'image' => [
                'url' => asset($character->reference)
            ],
            'fields' => [
                [
                    'name' => 'Пол',
                    'value' => $character->gender->localized(),
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
