<?php

namespace App\Jobs;

use App\Services\NotionService;

class ExportCharacter extends CharacterJob
{
    public function handle(NotionService $notionService)
    {
        $notionService->exportCharacter($this->character);
    }
}
