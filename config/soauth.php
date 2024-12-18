<?php

return [
    'facebook' => [
        'client_id' => app_env('FACEBACK_CLIENT_ID'),
        'client_secret' => app_env('FACEBACK_CLIENT_SECRET'),
        'redirect_uri' => app_env('FACEBACK_REDIRECT_URI')
    ],

    'gitlab' => [
        'client_id' => app_env('GITLAB_CLIENT_ID'),
        'client_secret' => app_env('GITLAB_CLIENT_SECRET'),
        'redirect_uri' => app_env('GITLAB_REDIRECT_URI')
    ],

    'github' => [
        'client_id' => app_env('GITHUB_CLIENT_ID'),
        'client_secret' => app_env('GITHUB_CLIENT_SECRET'),
        'redirect_uri' => app_env('GITHUB_REDIRECT_URI')
    ],

    'google' => [
        'client_id' => app_env('GOOGLE_CLIENT_ID'),
        'client_secret' => app_env('GOOGLE_CLIENT_SECRET'),
        'redirect_uri' => app_env('GOOGLE_REDIRECT_URI')
    ],

    'instagram' => [
        'client_id' => app_env('INSTAGRAM_CLIENT_ID'),
        'client_secret' => app_env('INSTAGRAM_CLIENT_SECRET'),
        'redirect_uri' => app_env('INSTAGRAM_REDIRECT_URI')
    ],

    'linkedin' => [
        'client_id' => app_env('LINKEDIN_CLIENT_ID'),
        'client_secret' => app_env('LINKEDIN_CLIENT_SECRET'),
        'redirect_uri' => app_env('LINKEDIN_REDIRECT_URI')
    ],
];
