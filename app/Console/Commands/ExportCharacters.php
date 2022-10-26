<?php

namespace App\Console\Commands;

use App\Models\Character;
use App\Services\NotionService;
use Illuminate\Console\Command;

class ExportCharacters extends Command
{
    protected $signature = 'characters:export-notion';

    protected $description = 'Export all characters to Notion database';

    public function handle(NotionService $notionService)
    {
        foreach (Character::with('perkVariants.perk')->get() as $character) {
            $this->info('Exporting: '.$character->notion_title);
            $notionService->exportCharacter($character);
        }

        return Command::SUCCESS;
    }
}
