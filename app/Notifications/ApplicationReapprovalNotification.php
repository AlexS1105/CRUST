<?php

namespace App\Notifications;

use App\Models\Character;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordMessage;

class ApplicationReapprovalNotification extends DiscordNotification
{
    public $character;
    public $user;

    public function __construct(Character $character, User $user)
    {
        $this->character = $character;
        $this->user = $user;
    }

    public function toDiscord($notifiable)
    {
        $url = route('characters.show', $this->character);
        $character = $this->character;
        $user = $this->user;
        $registrar = $character->registrar;
        $embed = [
            'title' => ($notifiable->is($registrar) ? "Проверенный Вами" : "Ваш")." персонаж '$character->name' отправлен на перепроверку",
            'description' => "$user->discord_tag что-то не понравилось.
            
            Игровой аккаунт отключен до повторной проверки регистратором $registrar->discord_tag.",
            'url' => $url,
            'color' => 0xFCD34D,
            'image' => [
                'url' => asset($character->reference)
            ],
            'author' => [
                'name' => $user->discord_tag,
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
