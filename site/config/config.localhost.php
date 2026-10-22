<?php

return [

    // Add here new config options. Always add comma at the end.

    // Kirby 4 ignores the Host header when detecting its base URL, so the
    // published Docker port would be lost. Local dev only: trust the header.
    'url' => (empty($_SERVER['HTTPS']) ? 'http://' : 'https://')
        . ($_SERVER['HTTP_HOST'] ?? 'localhost'),

    'cache' => [
        'pages' => [
            'active' => false,
        ]
    ],
];
