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
    ]
];
