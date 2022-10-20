<?php

namespace App\Notifications;

use App\Models\Character;
use NotificationChannels\Discord\DiscordMessage;

class ApplicationChangesRequestedNotification extends DiscordNotification
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
            'title' => "Для вашего персонажа '{$character->name}' запрошены правки",
            'description' => "{$registrar->discord_tag} что-то не понравилось на странице Вашего персонажа. Спросите, что не так, внесите изменения и подайте заявку на проверку снова.",
            'url' => $url,
            'color' => 0xFCD34D,
            'image' => [
                'url' => $character->reference,
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
