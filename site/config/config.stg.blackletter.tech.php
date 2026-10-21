<?php
$standardConfig = include 'config.stg.php';

//put special configs here, they will replace the standard config
$extendedConfig = [
    // Keep cached absolute URLs on HTTPS even when an internal health check
    // reaches the app directly and bypasses the TLS-terminating proxy.
    'url' => 'https://stg.blackletter.tech',

    //example for caching
    // 'cache' => [
    //     'pages' => [
    //         'active' => false,
    //     ]
    // ],
];

return array_replace_recursive($standardConfig, $extendedConfig);
