<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'discord' => [
        'api' => env('DISCORD_API'),
        'token' => env('DISCORD_TOKEN'),
        'client_id' => env('DISCORD_CLIENT_ID'),
        'secret' => env('DISCORD_SECRET'),
        'oauth2url' => [
            'login' => env('DISCORD_OAUTH2_URL_REGISTER'),
            'reset' => env('DISCORD_OAUTH2_URL_RESET'),
        ],
        'tickets' => [
            'api_url' => env('DISCORD_TICKETS_API_URL'),
            'guild_id' => env('DISCORD_TICKETS_GUILD_ID'),
            'category_id' => env('DISCORD_TICKETS_CATEGORY_ID'),
        ],
        'invite' => env('DISCORD_INVITE'),
    ],

    'launcher_url' => env('LAUNCHER_DOWNLOAD_URL'),

    'minecraft' => [
        'characters_auth' => env('MINECRAFT_CHARACTERS_AUTH', true),
        'accounts_auth' => env('MINECRAFT_ACCOUNTS_AUTH', true),
    ],

    'wiki' => [
        'rules_link' => env('RULES_LINK'),
        'client_id' => env('WIKI_CLIENT_ID'),
        'url' => env('WIKI_URL'),
        'oauth2' => env('WIKI_OAUTH2_URL'),
    ],

    'notion' => [
        'characters_database' => env('NOTION_CHARACTERS_DATABASE'),
    ],
];
