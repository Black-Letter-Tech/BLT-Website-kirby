<?php

Kirby::plugin('zero/zero-one', [
    'blueprints' => [

        // Site
        'site' => __DIR__ . '/blueprints/site.yml',

        // Blocks
        'blocks/accordion' => __DIR__ . '/blueprints/blocks/accordion.yml',
        'blocks/articles' => __DIR__ . '/blueprints/blocks/sections/articles.yml',
        'blocks/banner' => __DIR__ . '/blueprints/blocks/banner.yml',
        'blocks/button' => __DIR__ . '/blueprints/blocks/button.yml',
        'blocks/cpt' => __DIR__ . '/blueprints/blocks/sections/cpt.yml',
        'blocks/editor' => __DIR__ . '/blueprints/blocks/sections/editor.yml',
        'blocks/gallery' => __DIR__ . '/blueprints/blocks/sections/gallery.yml',
        'blocks/gallery-article' => __DIR__ . '/blueprints/blocks/gallery-article.yml',
        'blocks/grid' => __DIR__ . '/blueprints/blocks/sections/grid.yml',
        'blocks/contact-form' => __DIR__ . '/blueprints/blocks/contact-form.yml',
        'blocks/hero' => __DIR__ . '/blueprints/blocks/sections/hero.yml',
        'blocks/info' => __DIR__ . '/blueprints/blocks/info.yml',
        'blocks/intro' => __DIR__ . '/blueprints/blocks/intro.yml',
        'blocks/image' => __DIR__ . '/blueprints/blocks/image.yml',
        'blocks/list' => __DIR__ . '/blueprints/blocks/list.yml',
        'blocks/line' => __DIR__ . '/blueprints/blocks/line.yml',
        'blocks/heading' => __DIR__ . '/blueprints/blocks/heading.yml',
        'blocks/markdown' => __DIR__ . '/blueprints/blocks/markdown.yml',
        'blocks/media-video' => __DIR__ . '/blueprints/blocks/sections/media-video.yml',
        'blocks/media-image' => __DIR__ . '/blueprints/blocks/sections/media-image.yml',
        'blocks/slider' => __DIR__ . '/blueprints/blocks/sections/slider.yml',
        'blocks/slideshow' => __DIR__ . '/blueprints/blocks/sections/slideshow.yml',
        'blocks/subgrid' => __DIR__ . '/blueprints/blocks/subgrid.yml',
        'blocks/table' => __DIR__ . '/blueprints/blocks/table.yml',
        'blocks/text' => __DIR__ . '/blueprints/blocks/text.yml',
        'blocks/text-image' => __DIR__ . '/blueprints/blocks/sections/text-image.yml',
        'blocks/projects' => __DIR__ . '/blueprints/blocks/sections/projects.yml',
        'blocks/products' => __DIR__ . '/blueprints/blocks/sections/products.yml',
        'blocks/video' => __DIR__ . '/blueprints/blocks/video.yml',
        'blocks/z-articles' => __DIR__ . '/blueprints/blocks/z-articles.yml',
        'blocks/z-audio' => __DIR__ . '/blueprints/blocks/z-audio.yml',
        'blocks/z-card' => __DIR__ . '/blueprints/blocks/z-card.yml',
        'blocks/z-column' => __DIR__ . '/blueprints/blocks/z-column.yml',
        'blocks/z-content-slider' => __DIR__ . '/blueprints/blocks/z-content-slider.yml',
        'blocks/z-description' => __DIR__ . '/blueprints/blocks/z-description.yml',
        'blocks/z-gallery' => __DIR__ . '/blueprints/blocks/z-gallery.yml',
        'blocks/z-html' => __DIR__ . '/blueprints/blocks/z-html.yml',
        'blocks/z-image-slider' => __DIR__ . '/blueprints/blocks/z-image-slider.yml',
        'blocks/z-pages' => __DIR__ . '/blueprints/blocks/z-pages.yml',
        'blocks/z-projects' => __DIR__ . '/blueprints/blocks/z-projects.yml',
        'blocks/z-products' => __DIR__ . '/blueprints/blocks/z-products.yml',
        'blocks/z-products-list' => __DIR__ . '/blueprints/blocks/z-products-list.yml',
        'blocks/z-products-search' => __DIR__ . '/blueprints/blocks/z-products-search.yml',
        'blocks/z-slideshow' => __DIR__ . '/blueprints/blocks/z-slideshow.yml',
        'blocks/z-table' => __DIR__ . '/blueprints/blocks/z-table.yml',
        'blocks/z-typed-text' => __DIR__ . '/blueprints/blocks/z-typed-text.yml',

        // Fields
        'fields/altTitle' => __DIR__ . '/blueprints/fields/altTitle.yml',
        'fields/animationType' => __DIR__ . '/blueprints/fields/animationType.yml',
        'fields/animationDelay' => __DIR__ . '/blueprints/fields/animationDelay.yml',
        'fields/articleSettings' => __DIR__ . '/blueprints/fields/articleSettings.yml',
        'fields/audio' => __DIR__ . '/blueprints/fields/audio.php',
        'fields/backgroundImageHeading' => __DIR__ . '/blueprints/fields/backgroundImageHeading.yml',
        'fields/backgroundImage' => __DIR__ . '/blueprints/fields/backgroundImage.php',
        'fields/backgroundImagePosition' => __DIR__ . '/blueprints/fields/backgroundImagePosition.yml',
        'fields/backgroundImageSize' => __DIR__ . '/blueprints/fields/backgroundImageSize.yml',
        'fields/backgroundImageRepeat' => __DIR__ . '/blueprints/fields/backgroundImageRepeat.yml',
        'fields/backgroundOverlayColor' => __DIR__ . '/blueprints/fields/backgroundOverlayColor.yml',
        'fields/backgroundGradientOverlay' => __DIR__ . '/blueprints/fields/backgroundGradientOverlay.yml',
        'fields/backgroundGradientTransition' => __DIR__ . '/blueprints/fields/backgroundGradientTransition.yml',
        'fields/backgroundParalax' => __DIR__ . '/blueprints/fields/backgroundParalax.yml',
        'fields/blockEditor' => __DIR__ . '/blueprints/fields/blockEditor.yml',
        'fields/blogSettings' => __DIR__ . '/blueprints/fields/blogSettings.yml',
        'fields/headerImage' => __DIR__ . '/blueprints/fields/headerImage.yml',
        'fields/icons' => __DIR__ . '/blueprints/fields/icons.yml',
        'fields/image' => __DIR__ . '/blueprints/fields/image.php',
        'fields/image-clip' => __DIR__ . '/blueprints/fields/image-clip.php',
        'fields/sectionSize' => __DIR__ . '/blueprints/fields/sectionSize.yml',
        'fields/sectionColor' => __DIR__ . '/blueprints/fields/sectionColor.yml',
        'fields/sectionTextColor' => __DIR__ . '/blueprints/fields/sectionTextColor.yml',
        'fields/sectionRemovePadding' => __DIR__ . '/blueprints/fields/sectionRemovePadding.yml',
        'fields/productCover' => __DIR__ . '/blueprints/fields/product-cover.php',
        'fields/projectCover' => __DIR__ . '/blueprints/fields/project-cover.php',
        'fields/marginVertical' => __DIR__ . '/blueprints/fields/marginVertical.yml',
        'fields/marginLeft' => __DIR__ . '/blueprints/fields/marginLeft.yml',
        'fields/marginRight' => __DIR__ . '/blueprints/fields/marginRight.yml',
        'fields/menufields' => __DIR__ . '/blueprints/fields/menufields.yml',
        'fields/video' => __DIR__ . '/blueprints/fields/video.php',

        // Files
        'files/audio' => __DIR__ . '/blueprints/files/audio.yml',
        'files/archive' => __DIR__ . '/blueprints/files/archive.yml',
        'files/default' => __DIR__ . '/blueprints/files/default.yml',
        'files/document' => __DIR__ . '/blueprints/files/document.yml',
        'files/image' => __DIR__ . '/blueprints/files/image.yml',
        'files/video' => __DIR__ . '/blueprints/files/video.yml',

        // Sections
        'sections/articles' => __DIR__ . '/blueprints/sections/articles.yml',
        'sections/builder-options' => __DIR__ . '/blueprints/sections/builder-options.yml',
        'sections/custom-default-template-bottom' => __DIR__ . '/blueprints/sections/custom-default-template-bottom.yml',
        'sections/custom-default-template-sidebar' => __DIR__ . '/blueprints/sections/custom-default-template-sidebar.yml',
        'sections/custom-default-template-top' => __DIR__ . '/blueprints/sections/custom-default-template-top.yml',
        'sections/custom-page' => __DIR__ . '/blueprints/sections/custom-page.yml',
        'sections/custom-site' => __DIR__ . '/blueprints/sections/custom-site.yml',
        'sections/layout-builder' => __DIR__ . '/blueprints/sections/layout-builder.yml',
        'sections/navigation-builder' => __DIR__ . '/blueprints/sections/navigation-builder.yml',
        'sections/page-builder' => __DIR__ . '/blueprints/sections/page-builder.yml',
        'sections/page-draft' => __DIR__ . '/blueprints/sections/page-draft.yml',
        'sections/page-published' => __DIR__ . '/blueprints/sections/page-published.yml',
        'sections/products' => __DIR__ . '/blueprints/sections/products.yml',
        'sections/projects' => __DIR__ . '/blueprints/sections/projects.yml',
        'sections/site-brand' => __DIR__ . '/blueprints/sections/site-brand.yml',
        'sections/site-media' => __DIR__ . '/blueprints/sections/site-media.yml',
        'sections/site-navbar' => __DIR__ . '/blueprints/sections/site-navbar.yml',
        'sections/site-header' => __DIR__ . '/blueprints/sections/site-header.yml',
        'sections/site-social' => __DIR__ . '/blueprints/sections/site-social.yml',
        'sections/site-footer' => __DIR__ . '/blueprints/sections/site-footer.yml',
        'sections/site-transitions' => __DIR__ . '/blueprints/sections/site-transitions.yml',
        'sections/site-cookie' => __DIR__ . '/blueprints/sections/site-cookie.yml',
        'sections/site-performance' => __DIR__ . '/blueprints/sections/site-performance.yml',
        'sections/site-projects' => __DIR__ . '/blueprints/sections/site-projects.yml',
        'sections/site-shop' => __DIR__ . '/blueprints/sections/site-shop.yml',
        'sections/site-misc' => __DIR__ . '/blueprints/sections/site-misc.yml',

        // Tabs
        'tabs/page-options' => __DIR__ . '/blueprints/tabs/page-options.yml',
        'tabs/labels' => __DIR__ . '/blueprints/tabs/labels.yml',
        'tabs/seo' => __DIR__ . '/blueprints/tabs/seo.yml',
        'tabs/styling' => __DIR__ . '/blueprints/tabs/styling.yml',
        'tabs/site-content' => __DIR__ . '/blueprints/tabs/site-content.yml',
        'tabs/layout-grid' => __DIR__ . '/blueprints/tabs/layout-grid.yml',
        'tabs/layout-section' => __DIR__ . '/blueprints/tabs/layout-section.yml',
        'tabs/layout-advanced' => __DIR__ . '/blueprints/tabs/layout-advanced.yml',
        'tabs/z-column-size' => __DIR__ . '/blueprints/tabs/z-column-size.yml',
        'tabs/z-column-utility' => __DIR__ . '/blueprints/tabs/z-column-utility.yml',
        'tabs/z-column-advanced' => __DIR__ . '/blueprints/tabs/z-column-advanced.yml',
        'tabs/z-column-text' => __DIR__ . '/blueprints/tabs/z-column-text.yml',
        'tabs/z-column-style' => __DIR__ . '/blueprints/tabs/z-column-style.yml',

        // Users
        'users/admin' => __DIR__ . '/blueprints/users/admin.yml',
        'users/editor' => __DIR__ . '/blueprints/users/editor.yml',
        'users/visitor' => __DIR__ . '/blueprints/users/visitor.yml',

        // Pages
        'pages/article' => __DIR__ . '/blueprints/pages/article.yml',
        'pages/blog' => __DIR__ . '/blueprints/pages/blog.yml',
        'pages/builder' => __DIR__ . '/blueprints/pages/builder.yml',
        'pages/contact' => __DIR__ . '/blueprints/pages/contact.yml',
        'pages/default' => __DIR__ . '/blueprints/pages/default.yml',
        'pages/error' => __DIR__ . '/blueprints/pages/error.yml',
        'pages/home' => __DIR__ . '/blueprints/pages/home.yml',
        'pages/layout' => __DIR__ . '/blueprints/pages/layout.yml',
        'pages/link' => __DIR__ . '/blueprints/pages/link.yml',
        'pages/product' => __DIR__ . '/blueprints/pages/product.yml',
        'pages/project' => __DIR__ . '/blueprints/pages/project.yml',
        'pages/search' => __DIR__ . '/blueprints/pages/search.yml',
        'pages/shop' => __DIR__ . '/blueprints/pages/shop.yml',
        'pages/work' => __DIR__ . '/blueprints/pages/work.yml'
      ],
      'collections' => [

        'articles' => require 'collections/articles.php',
        'products' => require 'collections/products.php',
        'projects' => require 'collections/projects.php'

      ],
      'controllers' => [

        'article' => require 'controllers/article.php',
        'blog' => require 'controllers/blog.php',
        'contact' => require 'controllers/contact.php',
        'link' => require 'controllers/link.php',
        'project' => require 'controllers/project.php',
        'product' => require 'controllers/product.php',
        'products-search' => require 'controllers/products-search.php',
        'search' => require 'controllers/search.php',
        'shop' => require 'controllers/shop.php',
        'site' => require 'controllers/site.php',
        'work' => require 'controllers/work.php'

      ],
      'templates' => [

        'article' => __DIR__ . '/templates/article.php',
        'blog' => __DIR__ . '/templates/blog.php',
        'builder' => __DIR__ . '/templates/builder.php',
        'contact' => __DIR__ . '/templates/contact.php',
        'default' => __DIR__ . '/templates/default.php',
        'error' => __DIR__ . '/templates/error.php',
        'home' => __DIR__ . '/templates/home.php',
        'layout' => __DIR__ . '/templates/layout.php',
        'link' => __DIR__ . '/templates/link.php',
        'product' => __DIR__ . '/templates/product.php',
        'products-search' => __DIR__ . '/templates/products-search.php',
        'project' => __DIR__ . '/templates/project.php',
        'search' => __DIR__ . '/templates/search.php',
        'shop' => __DIR__ . '/templates/shop.php',
        'work' => __DIR__ . '/templates/work.php',
        'emails/email.html' => __DIR__ . '/templates/emails/email.html.php',
        'emails/email' => __DIR__ . '/templates/emails/email.php'

      ],
      'snippets' => [

        // Breadcrumb
        'breadcrumb' => __DIR__ . '/snippets/breadcrumb.php',

        // Footer
        'footer' => __DIR__ . '/snippets/footer.php',

        // Header
        'header' => __DIR__ . '/snippets/header.php',

        // LESS
        'less' => __DIR__ . '/snippets/less.php',

        // Article
        'article/prevnext' => __DIR__ . '/snippets/article/prevnext.php',
        'article/related' => __DIR__ . '/snippets/article/related.php',
        'article/share' => __DIR__ . '/snippets/article/share.php',
        'article/sidebar' => __DIR__ . '/snippets/article/sidebar.php',

        // Blog
        'blog/categories' => __DIR__ . '/snippets/blog/categories.php',
        'blog/filtered' => __DIR__ . '/snippets/blog/filtered.php',
        'blog/pagination' => __DIR__ . '/snippets/blog/pagination.php',
        'blog/sidebar' => __DIR__ . '/snippets/blog/sidebar.php',

        // Blocks
        'blocks/accordion' => __DIR__ . '/snippets/blocks/accordion.php',
        'blocks/articles' => __DIR__ . '/snippets/blocks/sections/articles.php',
        'blocks/banner' => __DIR__ . '/snippets/blocks/banner.php',
        'blocks/button' => __DIR__ . '/snippets/blocks/button.php',
        'blocks/cpt' => __DIR__ . '/snippets/blocks/sections/cpt.php',
        'blocks/editor' => __DIR__ . '/snippets/blocks/sections/editor.php',
        'blocks/grid' => __DIR__ . '/snippets/blocks/sections/grid.php',
        'blocks/gallery' => __DIR__ . '/snippets/blocks/sections/gallery.php',
        'blocks/gallery-article' => __DIR__ . '/snippets/blocks/gallery-article.php',
        'blocks/hero' => __DIR__ . '/snippets/blocks/sections/hero.php',
        'blocks/contact-form' => __DIR__ . '/snippets/blocks/contact-form.php',
        'blocks/info' => __DIR__ . '/snippets/blocks/info.php',
        'blocks/intro' => __DIR__ . '/snippets/blocks/intro.php',
        'blocks/image' => __DIR__ . '/snippets/blocks/image.php',
        'blocks/line' => __DIR__ . '/snippets/blocks/line.php',
        'blocks/list' => __DIR__ . '/snippets/blocks/list.php',
        'blocks/heading' => __DIR__ . '/snippets/blocks/heading.php',
        'blocks/media-video' => __DIR__ . '/snippets/blocks/sections/media-video.php',
        'blocks/media-image' => __DIR__ . '/snippets/blocks/sections/media-image.php',
        'blocks/slider' => __DIR__ . '/snippets/blocks/sections/slider.php',
        'blocks/slideshow' => __DIR__ . '/snippets/blocks/sections/slideshow.php',
        'blocks/subgrid' => __DIR__ . '/snippets/blocks/subgrid.php',
        'blocks/table' => __DIR__ . '/snippets/blocks/table.php',
        'blocks/text' => __DIR__ . '/snippets/blocks/text.php',
        'blocks/text-image' => __DIR__ . '/snippets/blocks/sections/text-image.php',
        'blocks/projects' => __DIR__ . '/snippets/blocks/sections/projects.php',
        'blocks/products' => __DIR__ . '/snippets/blocks/sections/products.php',
        'blocks/video' => __DIR__ . '/snippets/blocks/video.php',
        'blocks/z-articles' => __DIR__ . '/snippets/blocks/z-articles.php',
        'blocks/z-audio' => __DIR__ . '/snippets/blocks/z-audio.php',
        'blocks/z-card' => __DIR__ . '/snippets/blocks/z-card.php',
        'blocks/z-column' => __DIR__ . '/snippets/blocks/z-column.php',
        'blocks/z-content-slider' => __DIR__ . '/snippets/blocks/z-content-slider.php',
        'blocks/z-description' => __DIR__ . '/snippets/blocks/z-description.php',
        'blocks/z-gallery' => __DIR__ . '/snippets/blocks/z-gallery.php',
        'blocks/z-html' => __DIR__ . '/snippets/blocks/z-html.php',
        'blocks/z-image-slider' => __DIR__ . '/snippets/blocks/z-image-slider.php',
        'blocks/z-pages' => __DIR__ . '/snippets/blocks/z-pages.php',
        'blocks/z-projects' => __DIR__ . '/snippets/blocks/z-projects.php',
        'blocks/z-products' => __DIR__ . '/snippets/blocks/z-products.php',
        'blocks/z-products-list' => __DIR__ . '/snippets/blocks/z-products-list.php',
        'blocks/z-products-search' => __DIR__ . '/snippets/blocks/z-products-search.php',
        'blocks/z-slideshow' => __DIR__ . '/snippets/blocks/z-slideshow.php',
        'blocks/z-table' => __DIR__ . '/snippets/blocks/z-table.php',
        'blocks/z-typed-text' => __DIR__ . '/snippets/blocks/z-typed-text.php',

        // Contact
        'contact/form' => __DIR__ . '/snippets/contact/form.php',

        // Footer
        'footer/footer-columns' => __DIR__ . '/snippets/footer/footer-columns.php',
        'footer/footer-compact' => __DIR__ . '/snippets/footer/footer-compact.php',
        'footer/social-icons' => __DIR__ . '/snippets/footer/social-icons.php',
        'footer/social-links' => __DIR__ . '/snippets/footer/social-links.php',
        'footer/cookie-modal' => __DIR__ . '/snippets/footer/cookie-modal.php',
        'footer/cookie-popup' => __DIR__ . '/snippets/footer/cookie-popup.php',

        // Header
        'header/head' => __DIR__ . '/snippets/header/head.php',
        'header/navbar' => __DIR__ . '/snippets/header/navbar.php',
        'header/navbar/topbar' => __DIR__ . '/snippets/header/navbar/topbar.php',
        'header/navbar/logo' => __DIR__ . '/snippets/header/navbar/logo.php',
        'header/navbar/language-modal' => __DIR__ . '/snippets/header/navbar/language-modal.php',
        'header/navbar/search-modal' => __DIR__ . '/snippets/header/navbar/search-modal.php',
        'header/head/favicon' => __DIR__ . '/snippets/header/head/favicon.php',
        'header/head/opengraph' => __DIR__ . '/snippets/header/head/opengraph.php',
        'header/head/seo' => __DIR__ . '/snippets/header/head/seo.php',
        'header/head/title' => __DIR__ . '/snippets/header/head/title.php',
        'header/head/twitter' => __DIR__ . '/snippets/header/head/twitter.php',

        // Layout
        'layout/shape-divider' => __DIR__ . '/snippets/layout/shape-divider.php',
        'layout/layout' => __DIR__ . '/snippets/layout/layout.php',

        // Menus
        'menus/menu-mobile' => __DIR__ . '/snippets/menus/menu-mobile.php',
        'menus/nested-menu' => __DIR__ . '/snippets/menus/nested-menu.php',
        'menus/menu-builder' => __DIR__ . '/snippets/menus/menu-builder.php',
        'menus/mobile-menu-builder' => __DIR__ . '/snippets/menus/mobile-menu-builder.php',

        // Page
        'page/heading' => __DIR__ . '/snippets/page/heading.php',

        // Project
        'project/prevnext' => __DIR__ . '/snippets/project/prevnext.php',

        // Product
        'product/prevnext' => __DIR__ . '/snippets/product/prevnext.php',
        'product/related' => __DIR__ . '/snippets/product/related.php',

        // Shop
        'shop/categories' => __DIR__ . '/snippets/shop/categories.php',
        'shop/pagination' => __DIR__ . '/snippets/shop/pagination.php',
        'shop/filtered' => __DIR__ . '/snippets/shop/filtered.php',

        // Work
        'work/oldernewer' => __DIR__ . '/snippets/work/oldernewer.php',
        'work/tags' => __DIR__ . '/snippets/work/tags.php'
      ],

      'fieldMethods' => [
        // toImage/toImages came from k3-image-clip; map them to core toFile/toFiles
        'toImage' => function ($field) {
            return $field->toFile();
        },
        'toImages' => function ($field) {
            return $field->toFiles();
        },
        'price' => function ($field) {
            return number_format((float)$field->value, 2, site()->decimalSeparator(), site()->thousandSeparator());
        },
        'priceSnipcart' => function ($field) {
            return number_format((float)$field->value, 2, '.', ',');
        },
        'titlecase' => function ($field) {
            return ucfirst($field->value) ;
        }
      ],

      'layoutColumnMethods' => [
        'hasBlockType' => function ($type) {
            return $this->blocks()->hasType($type);
        }
      ],

      'api' => [
        'routes' => [
           [
            'pattern' => 'getRenderedText/pages/(:all)',
            'language' => '*',
            'method'  => 'POST',
            'action'  => function ($id) {
                $id    = str_replace('+', '/', $id);
                $page  = kirby()->page($id);
                $text  = $this->requestBody('text');
                $field = new Kirby\Cms\Field($page, 'inhalt', $text);
                $data  = [
                  'text' => $field->kt(),
                  'id'   => $id,
                  'page' => $page->url()
                ];
                return $data;
            }
           ]
        ]
      ],

      'routes' => function ($kirby) {
          return [
            [
              'pattern' => '(:any)/search/products',
              'language' => '*',
              'action'  => function () {
                  return Page::factory([
                      'slug' => 'products',
                      'parent' => page('search'),
                      'template' => 'products-search',
                      'content' => [
                          'title' => site()->labelProductSearchTitle()->or('Products search'),
                          'intro'  => site()->labelProductSearchIntro()->or('Search through our products')
                      ]
                  ]);
              },
              'pattern' => 'search/products',
              'action'  => function () {
                  return Page::factory([
                      'slug' => 'products',
                      'parent' => page('search'),
                      'template' => 'products-search',
                      'content' => [
                          'title' => site()->labelProductSearchTitle()->or('Products search'),
                          'intro'  => site()->labelProductSearchIntro()->or('Search through our products')
                      ]
                  ]);
              }
            ]
          ];
      }
]);
