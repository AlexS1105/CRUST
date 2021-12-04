<?php

namespace App\Notifications;

use App\Models\Account;
use NotificationChannels\Discord\DiscordMessage;

class UserAccountCreatedNotification extends DiscordNotification
{
    public $account;

    public function __construct(Account $account)
    {
        $this->account = $account;
    }

    public function toDiscord($notifiable)
    {
        $appUrl = config('app.url');
        $login = $this->account->login;
        $launcherUrl = config('services.launcherurl');

        $embed = [
            'title' => 'Для Вас создан новый аккаунт!',
            'description' => 'Вы можете использовать указанные ниже данные для входа в игру.',
            'url' => $appUrl,
            'color' => 0x93c47d,
            'fields' => [
                [
                    'name' => '**Данные для входа**',
                    'value' => "**Логин:** $login
                    **Пароль:** Такой же, как у аккаунта здесь
                    
                    **Приятной игры!**
                    
                    [**Скачать лаунчер**]($launcherUrl)"
                ]
            ]
        ];
        
        return DiscordMessage::create('', array_merge($this->getEmbed(), $embed));
    }
}
