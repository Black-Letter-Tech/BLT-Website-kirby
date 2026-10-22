<?php
$linkType   = $block->linkType()->value();
$page       = $linkType === 'page' ? $block->page()->toPage() : null;
$link       = $page ? $page->url() : ($linkType === 'custom' ? $block->link()->value() : null);
$image      = $block->image()->toFile();
$text       = $block->text()->kt();
$vertical   = $block->imageRatio() == 'vertical';
$horizontal = $block->imageRatio() == 'horizontal';
?>

<?php if($block->isNotEmpty()): ?>
<?php if(!empty($link)): ?>
<a href="<?= $link ?>" class="uk-link-toggle uk-margin uk-display-inline-block">
<?php endif; ?>
<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
  <?php if($image): ?>
    <picture>
      <source type="image/webp" srcset="<?php if($vertical): ?><?= $image->thumb(['crop' => true, 'width' => 600, 'height' => 900, 'format' => 'webp'])->url() ?><?php elseif($horizontal): ?><?= $image->thumb(['crop' => true, 'width' => 900, 'height' => 600, 'format' => 'webp'])->url() ?><?php else: ?><?= $image->thumb(['crop' => true, 'width' => 800, 'height' => 800, 'format' => 'webp'])->url() ?><?php endif; ?>" />
      <img class="uk-transition-scale-up uk-transition-opaque" src="<?php if($vertical): ?><?= $image->crop(600,900)->url() ?><?php elseif($horizontal): ?><?= $image->crop(900,600)->url() ?><?php else: ?><?= $image->crop(800,800)->url() ?><?php endif; ?>"<?php if($vertical): ?> width="600" height="900"<?php elseif($horizontal): ?> width="900" height="600"<?php else: ?> width="800" height="800"<?php endif; ?> alt="<?= $image->alt() ?>" loading="lazy">
    </picture>
  <?php endif ?>
  <?php if($block->bannerStyle() == 'overlay'): ?>
    <?php if($block->contentBackground() == "overlay"): ?>
    <div class="uk-overlay-gradient uk-position-cover"></div>
    <?php endif ?>
  <div class="uk-overlay uk-padding uk-position-small<?= $block->contentPosition() ?><?= $block->contentWidth() ?><?php e($block->centerText() == "true", ' uk-text-center') ?><?php e($block->contentBackground() == "background", ' uk-overlay-default') ?><?php e($block->contentBackground() == "overlay", ' uk-light') ?>">
  <?php if($block->text()->isNotEmpty()): ?><?= $text ?><?php endif; ?>
  </div>
  <?php endif; ?>
</div>
<?php if($block->bannerStyle() == 'offset'): ?>
  <div class="tm-banner-overlay">
  <?php if($block->text()->isNotEmpty()): ?><?= $text ?><?php endif; ?>
  </div>
<?php endif; ?>
<?php if(!empty($link)): ?>
</a>
<?php endif; ?>
<?php endif; ?>