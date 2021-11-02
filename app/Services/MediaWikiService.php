<?php

namespace App\Services;

use App\Models\User;
use StarCitizenWiki\MediaWikiApi\Facades\MediaWikiApi;

class MediaWikiService
{
    public function __construct()
    {
        $manager = app('mediawikiapi.manager');
        $manager->setConsumerFromCredentials(
            config('mediawiki.credentials.consumer_token'),
            config('mediawiki.credentials.consumer_secret'),
        );
        
        $manager->setTokenFromCredentials(
            config('mediawiki.credentials.access_token'),
            config('mediawiki.credentials.access_secret'),
        );
    }

    public function getToken($type)
    {
        $response = MediaWikiApi::query()
                                ->meta('tokens')
                                ->addParam('type', $type)
                                ->request();

        return $response->getQuery()['tokens'][$type.'token'];
    }

    public function createAccount(User $user, $password)
    {
        $csrfToken = $this->getToken('csrf');
        $actionToken = $this->getToken('createaccount');

        $action = MediaWikiApi::action('createaccount', 'POST', true);
        $action->addParam('username', $user->login);
        $action->addParam('password', $password);
        $action->addParam('retype', $password);
        $action->addParam('createtoken', $actionToken);
        $action->addParam('createreturnurl', config('app.url'));
        $action->csrfToken($csrfToken);

        return $action->request();
    }
}
