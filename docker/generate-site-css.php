<?php

declare(strict_types=1);

use Kirby\Cms\App;

require '/app/vendor/autoload.php';

$base = '/app';
$kirby = new App([
    'roots' => [
        'index'    => $base . '/public',
        'base'     => $base,
        'content'  => $base . '/content',
        'site'     => $base . '/site',
        'storage'  => $base . '/storage',
        'accounts' => $base . '/storage/accounts',
        'cache'    => $base . '/storage/cache',
        'sessions' => $base . '/storage/sessions',
    ],
]);

$target = $base . '/public/assets/css/site.css';
$temporary = $target . '.tmp';
$css = $kirby->site()->customCss()->value();

if (file_put_contents($temporary, $css) === false || rename($temporary, $target) === false) {
    @unlink($temporary);
    fwrite(STDERR, "Unable to generate {$target}\n");
    exit(1);
}

echo "Generated {$target} from Kirby site content.\n";
