<?php

// Replaces kirbyzone/sitemapper, which broke on Kirby 4. Serves
// sitemap.xml from listed pages and keeps the fields/sitemap toggle
// that page and file blueprints extend.

Kirby::plugin('blt/sitemap', [
    'blueprints' => [
        'fields/sitemap' => __DIR__ . '/blueprints/sitemap.yml',
    ],
    'routes' => [
        [
            'pattern' => 'sitemap.xml',
            'method'  => 'GET',
            'action'  => function () {
                // index() skips drafts; unlisted pages stay in (the live
                // sitemap carries privacy-policy). The toggle rules.
                $pages = kirby()->site()->index()
                    ->filter(fn ($p) => $p->sitemap()->isEmpty() || $p->sitemap()->toBool());

                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";
                foreach ($pages as $p) {
                    $xml .= "  <url>\n";
                    $xml .= '    <loc>' . Kirby\Toolkit\Xml::encode($p->url()) . "</loc>\n";
                    $xml .= '    <lastmod>' . date('c', $p->modified()) . "</lastmod>\n";
                    $images = $p->images()
                        ->filter(fn ($f) => $f->sitemap()->isEmpty() || $f->sitemap()->toBool());
                    foreach ($images as $img) {
                        $xml .= "    <image:image>\n";
                        $xml .= '      <image:loc>' . Kirby\Toolkit\Xml::encode($img->url()) . "</image:loc>\n";
                        $xml .= "    </image:image>\n";
                    }
                    $xml .= "  </url>\n";
                }
                $xml .= '</urlset>';

                return new Kirby\Cms\Response($xml, 'application/xml');
            }
        ],
    ],
]);
