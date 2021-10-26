<?php

namespace App\Notifications;

use App\Models\Character;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordMessage;

class ApplicationCanceledNotification extends DiscordNotification
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
        $embed = [
            'title' => "Ваш персонаж '$character->name' снят с проверки",
            'description' => '*Что-то пошло не так*
            
            Новый регистратор возьмёт Вашего персонажа на проверку в ближайшее время.',
            'url' => $url,
            'color' => 0xFCD34D,
            'image' => [
                'url' => asset($character->reference)
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
