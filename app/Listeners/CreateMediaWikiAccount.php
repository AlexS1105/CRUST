<?php

namespace App\Listeners;

use App\Services\MediaWikiService;

class CreateMediaWikiAccount
{
    private $mediaWikiService;

    public function __construct(MediaWikiService $mediaWikiService)
    {
        $this->mediaWikiService = $mediaWikiService;
    }

    public function handle($event)
    {
        $this->mediaWikiService->createAccount($event->user, request('password'));
    }
}
