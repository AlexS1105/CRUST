<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Discord\DiscordChannel;

class DiscordNotification extends Notification
{
    use Queueable;

    protected $registrarNotification = false;
    protected $color;

    public function via($notifiable)
    {
        return $notifiable->verified && ($this->registrarNotification || $notifiable->discord_notify) ? [DiscordChannel::class] : [];
    }

    public function authorField($user, $withLink = true)
    {
        return [
            'name' => $user->discord_tag,
            'url' => $withLink ? route('users.show', $user) : null,
        ];
    }

    public function loginData($login)
    {
        return [
            'name' => '**Данные для входа**',
            'value' => "**Логин:** {$login}
                    **Пароль:** Такой же, как у аккаунта CRUST

                    **Приятной игры!**".$this->launcherLink(),
        ];
    }

    public function launcherLink()
    {
        $launcherUrl = config('services.launcher_url');

        return PHP_EOL."[**Скачать лаунчер**]({$launcherUrl})";
    }

    public function url()
    {
        return config('app.url');
    }

    public function color()
    {
        return hexdec($this->color);
    }

    protected function getEmbed()
    {
        return [
            'type' => 'rich',
            'footer' => [
                'text' => config('app.name'),
                'icon_url' => asset('images/logo.png'),
            ],
            'url' => $this->url(),
            'color' => $this->color(),
            'timestamp' => now(),
        ];
    }
}
