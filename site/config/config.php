<?php
// load dotenv plugins class so getenv can be used outside of closures
require_once __DIR__ . '/../plugins/kirby3-dotenv/global.php';
loadenv([
    'dir' => realpath(__DIR__ . '/../../'),
    'file' => '.env',
]);

return [
    //some sensible defaults for development
    'debug' => true,
    'cache' => [
        'pages' => [
            'active' => false,
        ]
    ],

    // https://getkirby.com/docs/reference/system/options/panel#custom-panel-css
    // The Panel exists only where the container says so. ENABLE_PANEL has
    // been in the compose files since 2023; this is what finally reads it.
    'panel' => getenv('ENABLE_PANEL') === 'true' ? [
      'css' => 'assets/css/panel.css'
    ] : false,
    // https://getkirby.com/docs/reference/system/options/languages
    'languages' => true,
    // 'languages.detect' => true

    // https://getkirby.com/docs/reference/system/options/smartypants
    'smartypants' => true,

    // Autoresize plugin https://github.com/medienbaecker/kirby-autoresize
    'medienbaecker.autoresize.maxWidth' => 2500,
    'medienbaecker.autoresize.quality' => 85,

    // https://getkirby.com/docs/reference/system/options/thumbs
    'thumbs' => [
      'quality' => '85',
      'srcsets' => [
        'default' => [
          '800w' => [
          'width' => 800
        ],
          '1024w' => [
            'width' => 1024
        ],
          '1920w' => [
            'width' => 1920
        ],
        ],
      ]
    ],

    // Robots plugin https://github.com/bnomei/kirby3-robots-txt
    'bnomei.robots-txt.sitemap' => 'sitemap.xml',
    'bnomei.robots-txt.groups' => [ // array or callback
      '*' => [ // user-agent
          'disallow' => [
              '/kirby/',
              '/site/',
          ],
          'allow' => [
              '/media/',
          ]
      ]
    ],

    // Write custom CSS to file
    'hooks' => [
      'site.update:after' => function($newSite) {
    
        $css = $newSite->customCss()->value();
          if (kirby()->language()->isDefault()) {
            F::write(kirby()->root('assets') . '/css/site.css', $css);
        }
      }
    ],

    // Support for language detect option https://getkirby.com/docs/guide/languages/introduction#automatic-language-detection
    // 'routes' => [
    //   [
    //       'pattern' => '/',
    //       'action'  => function () {
    //           $session = kirby()->session();

    //           if ($session->get('languages.detect', false) === false && option('languages.detect') === true) {
    //               $session->set('languages.detect', true);

    //               return kirby()
    //                   ->response()
    //                   ->redirect(kirby()->detectedLanguage()->url());
    //           }

    //           return page();
    //       }
    //     ]
    // ],
    // Remove update notification for some plugins
    'updates.plugins' => [
      'bvdputte/kirby-bettersearch'   => false,
      'kirbyzone/sitemapper'          => false,
      'pju/webhook-field'             => false,
      'sylvainjule/code-editor'       => false,
      'wagnerpaul/deploy-content'     => false,
      'zero/zero-one'                 => false
    ],
    'bnomei.dotenv' => [
      'dir' => function() { return kirby()->roots()->base(); },
    ],
    // More info on this setings at https://getkirby.com/docs/cookbook/forms/using-mailhog-for-email-testing#what-is-mailhog
    'email' => [
      'transport' => [
        'type' => 'smtp',
        'host' => env('EMAIL_TRANSPORT_HOST'),
        'port' => 587,
        'security' => true,
        'auth' => true,
        'username' => env('EMAIL_TRANSPORT_USERNAME'),
        'password' => env('EMAIL_TRANSPORT_PASSWORD'),
        'beforeSend' => function ($mailer) {
          $mailer->SMTPDebug = 2;
          return $mailer;
        }
      ]
    ],
    //some debuingging routs
    'routes' => [
        [
          'pattern' => 'my/awesome/debugger',
          'action'  => function () {
            // ...
          }
        ],
      ]
];
