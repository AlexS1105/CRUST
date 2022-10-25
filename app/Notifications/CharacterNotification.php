<?php

namespace App\Notifications;

use App\Models\Character;

class CharacterNotification extends DiscordNotification
{
    protected $character;
    protected $author;

    public function __construct(Character $character)
    {
        $this->character = $character;
    }

    public function getEmbed()
    {
        $character = $this->character;

        return array_merge(parent::getEmbed(), [
            'image' => [
                'url' => $character->getResizedReference(400),
            ],
            'author' => $this->authorField(
                ...($this->registrarNotification ? [$character->user] : [$character->registrar, false])
            ),
            'fields' => [
                [
                    'name' => 'Описание',
                    'value' => $character->description,
                ],
                [
                    'name' => 'Подробнее',
                    'value' => $this->characterLink().(isset($character->ticket) ? $this->ticketLink() : ''),
                ],
            ],
        ]);
    }

    public function characterLink()
    {
        return PHP_EOL."[**Страница персонажа**]({$this->url()})";
    }

    public function url()
    {
        return route('characters.show', $this->character);
    }

    public function ticketLink()
    {
        return PHP_EOL."[**Тикет для обсуждения**]({$this->character->ticket->link()})";
    }
}
