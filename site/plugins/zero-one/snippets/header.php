<!doctype html>
<html<?php e($kirby->languages()->isNotEmpty(), ' lang="' . $kirby->language()->code() . '" dir="' . $kirby->language()->direction() . '" prefix="og: https://ogp.me/ns#"') ?>>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<?php snippet('header/head') ?>
<?php if($site->stylingSwitcher()->isTrue()): ?>
  <?php snippet('less') ?>
<?php endif ?>

<?php if($site->cachebusting()->isTrue()): ?>
<?= Bnomei\Fingerprint::css('/assets/app/dist/css/uikit.app.min.css') ?>
<?php else: ?>
<?= css('/assets/app/dist/css/uikit.app.min.css') ?>
<?php endif ?>
<?php if($site->fontURL()->isNotEmpty()): ?>
<link href="<?= $site->fontURL() ?>" rel="stylesheet">
<?php else: ?>

<?php if($site->cachebusting()->isTrue()): ?>
<?= Bnomei\Fingerprint::css('/assets/css/fonts.css') ?>
<?php else: ?>
<?= css('/assets/css/fonts.css') ?>
<?php endif ?>
<?php endif ?>

<?php if($site->syntaxHighlighting()->isTrue()): ?>
<?php if($site->cachebusting()->isTrue()): ?>
<?= Bnomei\Fingerprint::css('/assets/css/prism.css') ?>
<?php else: ?>
<?= css('/assets/css/prism.css') ?>
<?php endif ?>
<?php endif ?>

<?php if ($site->customCss()->isNotEmpty() && $site->cachebusting() == "false"): echo css('assets/css/site.css'); endif; ?>
<?php if ($site->customCss()->isNotEmpty() && $site->cachebusting() == "true"): echo Bnomei\Fingerprint::css('assets/css/site.css'); endif; ?>

<?= css('@auto') ?>

<?php if($site->cachebusting()->isTrue()): ?>
<?= Bnomei\Fingerprint::js('/assets/app/dist/js/uikit.min.js') ?>
<?php else: ?>
<?= js('/assets/app/dist/js/uikit.min.js') ?>
<?php endif ?>

<?php if($site->cachebusting()->isTrue()): ?>
<?= Bnomei\Fingerprint::js('/assets/app/dist/js/uikit-icons.min.js', ['defer' => true]) ?>
<?php else: ?>
<?= js('/assets/app/dist/js/uikit-icons.min.js', ['defer' => true]) ?>
<?php endif ?>

<?php if($site->typedText()->isTrue()): ?>
<?php if($site->cachebusting()->isTrue()): ?>
<?= Bnomei\Fingerprint::js('/assets/js/scripts/typed.min.js') ?>
<?php else: ?>
<?= js('/assets/js/scripts/typed.min.js') ?>
<?php endif ?>
<?php endif ?>
<?= js('@auto') ?>

<?php if($site->headCustomCode()->isNotEmpty()): ?>
<?= $site->headCustomCode()->value() ?>
<?php endif ?>
</head>
<body>
<?php if($site->bodyCustomCode()->isNotEmpty()): ?>
<?= $site->bodyCustomCode()->value() ?>
<?php endif ?>

<?php if($site->snipcartSwitch()->isTrue() && $site->snipcartApi()->isNotEmpty()): ?>
<script>
  window.SnipcartSettings = {
    publicApiKey: "<?= $site->snipcartApi() ?>",
    loadStrategy: "on-user-interaction",
    version: "3.4.1",
    modalStyle: "side",
    currency: "<?= Str::lower($site->defaultCurrency()) ?>"
  };

  (()=>{var c,d;(d=(c=window.SnipcartSettings).version)!=null||(c.version="3.0");var s,S;(S=(s=window.SnipcartSettings).timeoutDuration)!=null||(s.timeoutDuration=2750);var l,p;(p=(l=window.SnipcartSettings).domain)!=null||(l.domain="cdn.snipcart.com");var w,u;(u=(w=window.SnipcartSettings).protocol)!=null||(w.protocol="https");var f=window.SnipcartSettings.version.includes("v3.0.0-ci")||window.SnipcartSettings.version!="3.0"&&window.SnipcartSettings.version.localeCompare("3.4.0",void 0,{numeric:!0,sensitivity:"base"})===-1,m=["focus","mouseover","touchmove","scroll","keydown"];window.LoadSnipcart=o;document.readyState==="loading"?document.addEventListener("DOMContentLoaded",r):r();function r(){window.SnipcartSettings.loadStrategy?window.SnipcartSettings.loadStrategy==="on-user-interaction"&&(m.forEach(t=>document.addEventListener(t,o)),setTimeout(o,window.SnipcartSettings.timeoutDuration)):o()}var a=!1;function o(){if(a)return;a=!0;let t=document.getElementsByTagName("head")[0],e=document.querySelector("#snipcart"),i=document.querySelector(`src[src^="${window.SnipcartSettings.protocol}://${window.SnipcartSettings.domain}"][src$="snipcart.js"]`),n=document.querySelector(`link[href^="${window.SnipcartSettings.protocol}://${window.SnipcartSettings.domain}"][href$="snipcart.css"]`);e||(e=document.createElement("div"),e.id="snipcart",e.setAttribute("hidden","true"),document.body.appendChild(e)),v(e),i||(i=document.createElement("script"),i.src=`${window.SnipcartSettings.protocol}://${window.SnipcartSettings.domain}/themes/v${window.SnipcartSettings.version}/default/snipcart.js`,i.async=!0,t.appendChild(i)),n||(n=document.createElement("link"),n.rel="stylesheet",n.type="text/css",n.href=`${window.SnipcartSettings.protocol}://${window.SnipcartSettings.domain}/themes/v${window.SnipcartSettings.version}/default/snipcart.css`,t.prepend(n)),m.forEach(g=>document.removeEventListener(g,o))}function v(t){!f||(t.dataset.apiKey=window.SnipcartSettings.publicApiKey,window.SnipcartSettings.addProductBehavior&&(t.dataset.configAddProductBehavior=window.SnipcartSettings.addProductBehavior),window.SnipcartSettings.modalStyle&&(t.dataset.configModalStyle=window.SnipcartSettings.modalStyle),window.SnipcartSettings.currency&&(t.dataset.currency=window.SnipcartSettings.currency),window.SnipcartSettings.templatesUrl&&(t.dataset.templatesUrl=window.SnipcartSettings.templatesUrl))}})();
</script>
<?php endif ?>

<?php snippet('header/navbar') ?>

<div id="swup" class="transition-fade<?php if($page->transparentNavbar()->isEmpty() && $page->intendedTemplate()->name() !== "error" && $page->intendedTemplate()->name() !== "search" && $page->intendedTemplate()->name() !== "product"): ?><?php e($site->transparentNavbar() == "true", ' tm-transparent-navbar-negative') ?><?php elseif($page->transparentNavbar() == "transparent"): ?> tm-transparent-navbar-negative<?php endif ?>" aria-live="polite">

  