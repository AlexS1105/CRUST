<?php

namespace App\Notifications;

use App\Models\Character;
use NotificationChannels\Discord\DiscordMessage;

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
        $ticketLink = $character->ticket->link();
        $embed = [
            'title' => "Ваш персонаж '{$character->name}' взят на проверку!",
            'description' => "Регистратор {$registrar->discord_tag} проверит её как можно скорее.",
            'url' => $url,
            'color' => 0x60A5FA,
            'image' => [
                'url' => $character->getResizedReference(400),
            ],
            'author' => [
                'name' => $registrar->discord_tag,
            ],
            'fields' => [
                [
                    'name' => 'Пол',
                    'value' => $character->gender->localized(),
                    'inline' => true,
                ],
                [
                    'name' => 'Раса',
                    'value' => $character->race,
                    'inline' => true,
                ],
                [
                    'name' => 'Возраст',
                    'value' => $character->age,
                    'inline' => true,
                ],
                [
                    'name' => 'Описание',
                    'value' => $character->description."

                    [**Страница персонажа**]({$url})
                    [**Тикет для обсуждения**]({$ticketLink})",
                ],
            ],
        ];

        return DiscordMessage::create('', array_merge($this->getEmbed(), $embed));
    }
}
