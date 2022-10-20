<?php

namespace App\Notifications;

use App\Models\Character;
use NotificationChannels\Discord\DiscordMessage;

class NewApplicationNotification extends DiscordNotification
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
        $user = $character->user;
        $embed = [
            'title' => "Персонаж '{$character->name}' подан на проверку",
            'description' => 'Пожалуйста, возьмите на проверку как можно скорее!',
            'url' => $url,
            'color' => 0x60A5FA,
            'image' => [
                'url' => $character->reference,
            ],
            'author' => [
                'name' => $user->discord_tag,
                'url' => route('users.show', $user),
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

                    [**Страница персонажа**]({$url})",
                ],
            ],
        ];

        return DiscordMessage::create('', array_merge($this->getEmbed(), $embed));
    }
}
