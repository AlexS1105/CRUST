<?php

namespace App\Services;

use App\Enums\CharacterSkill;
use App\Models\Character;
use FiveamCode\LaravelNotionApi\Entities\Page;
use FiveamCode\LaravelNotionApi\NotionFacade;
use FiveamCode\LaravelNotionApi\Query\Filters\Filter;
use FiveamCode\LaravelNotionApi\Query\Filters\Operators;
use Illuminate\Support\Collection;

class NotionService
{
    public function exportCharacter($character)
    {
        $page = new Page();
        $this->fillPage($page, $character);
        $pageId = $character->notion_page ?? $this->fetchCharacterPage($character);

        if (isset($pageId)) {
            $page->setId($pageId);
            NotionFacade::pages()->update($page);
        } else {
            NotionFacade::database(config('services.notion.characters_database'));
        }
    }

    public function fillPage($page, $character)
    {
        $page->setTitle('Name', $character->notion_title);
        $page->setUrl('Crust', route('characters.show', $character));

        foreach (CharacterSkill::cases() as $skill) {
            $page->setNumber($skill->localized(), $character->charsheet->skills[$skill->value]);
        }

        $character->load('perkVariants.perk');

        $page->setMultiSelect('Перки', $character->perkVariants->map(function ($perkVariant) {
            return $perkVariant->perk->name;
        })->toArray());
    }

    public function fetchCharacterPage($character)
    {
        $filters = new Collection(
            [
                Filter::textFilter(
                    'Name',
                    Operators::STARTS_WITH,
                    $character->id . ' '
                )
            ]
        );

        $page = NotionFacade::database(config('services.notion.characters_database'))
            ->filterBy($filters)
            ->query()
            ->asCollection()
            ->first();

        if (isset($page)) {
            $character->notion_page = $page->getId();
            $character->saveQuietly();

            return $page->getId();
        }
    }
}
