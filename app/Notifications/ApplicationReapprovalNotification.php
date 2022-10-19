<?php

namespace App\Notifications;

use App\Models\Character;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use NotificationChannels\Discord\DiscordMessage;

class ApplicationReapprovalNotification extends DiscordNotification
{
    public $character;
    public $user;

    public function __construct(Character $character, User $user, $isRegistrar = false)
    {
        $this->character = $character;
        $this->user = $user;
        $this->registrarNotification = $isRegistrar;
    }

    public function toDiscord($notifiable)
    {
        $url = route('characters.show', $this->character);
        $character = $this->character;
        $user = $this->user;
        $registrar = $character->registrar;
        $ticketLink = $character->ticket->link();
        $embed = [
            'title' => ($notifiable->is($character->user) ? 'Ваш' : 'Проверенный Вами')." персонаж '{$character->name}' отправлен на перепроверку",
            'description' => "{$user->discord_tag} что-то не понравилось.

            Игровой аккаунт отключен до повторной проверки регистратором {$registrar->discord_tag}.",
            'url' => $url,
            'color' => 0xFCD34D,
            'image' => [
                'url' => $character->reference,
            ],
            'author' => [
                'name' => $user->discord_tag,
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
