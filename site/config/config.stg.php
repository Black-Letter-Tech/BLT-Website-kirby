<?php

return [
    'cache' => [
        'pages' => [
            'active' => true,
        ]
    ],
 	//deployment webhook config
    'pju.webhook-field.endpoint' => getenv('WEBHOOKS_ENDPOINT'),
    'pju.webhook-field.hooks' => [
        getenv('DEPLOY_CONTENT_HOOK') => [
          'url' => '/'.getenv('DEPLOY_CONTENT_HOOK').'/start',
          'payload' => ['key' => getenv('DEPLOY_CONTENT_KEY')],
          'showOutdated' => false
        ]
    ],
];
