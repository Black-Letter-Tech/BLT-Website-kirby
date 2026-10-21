<?php

$alt      = $block->alt();
$caption  = $block->caption();
$link     = $block->link();
$class    = ($block->borderRadius()->isNotEmpty() or $block->shadow()->isNotEmpty() or $block->ratio()->isNotEmpty()) ? ' class="' . $block->borderRadius() . $block->shadow() . ($block->location() == 'kirby' && $block->ratio()->isNotEmpty() ? ' uk-object-cover' : null) .'"' : null;
$ratio    = $block->location() == 'kirby' && $block->ratio()->isNotEmpty() ? ' style="aspect-ratio:' . $block->ratio() . '"' : null;
$src      = null;

if ($block->location() == 'web' && $block->src()->isNotEmpty()) {
    $src = $block->src();
    $srcurl = $src;
} elseif ($image = $block->image()->toImage()) {
    $alt      = $alt->isNotEmpty() ? $alt : $image->alt();
    $caption  = $block->caption()->isNotEmpty() ? $caption : $image->caption();
    $src      = $block->resizeWidth()->isNotEmpty() ? $image->resize($block->resizeWidth()->toInt())->url() : $image->resize()->url();
    $srcurl   = $image->url();
    $srcset   = $block->resizeWidth()->isNotEmpty() ? $image->thumb(['clip' => $image->getClip(), 'width' => $block->resizeWidth()->toInt(), 'format' => 'webp'])->url() : $image->thumb(['clip' => $image->getClip(), 'format' => 'webp'])->url();
    $width    = $block->resizeWidth()->isNotEmpty() ? $image->resize($block->resizeWidth()->toInt())->width() : $image->resize()->width();
    $height   = $block->resizeWidth()->isNotEmpty() ? $image->resize($block->resizeWidth()->toInt())->height() : $image->resize()->height();
}

?>
<?php if ($src): ?>
<figure<?php if($block->width()->isNotEmpty() or $block->widthMobile()->isNotEmpty() or $block->align()->isNotEmpty() or $block->float()->isNotEmpty()): ?> class="<?= $block->widthMobile() ?><?= $block->width() ?><?= $block->align() ?><?= $block->float() ?>"<?php endif ?><?php if($block->location() == 'kirby' and $block->width()->isEmpty() and $block->widthMobile()->isEmpty()): ?> style="max-width:<?= $width ?>px;"<?php endif ?>>
  <?php if ($block->linkOption() == "lightbox"): ?>
  <div uk-lightbox>
      <a href="<?= $srcurl ?>" data-alt="<?= $alt ?>" data-no-swup<?php if ($caption->isNotEmpty()): ?> data-caption="<?= $caption ?>"<?php endif ?>>
        <picture>
          <?php if ($block->location() == 'kirby' && $image = $block->image()->toImage()): ?>
          <source type="image/webp" srcset="<?= $srcset ?>" />
          <?php endif ?>
          <img src="<?= $src ?>"<?= $class ?> alt="<?= $alt ?>"<?php if ($block->location() == 'kirby' && $image = $block->image()->toImage()): ?> width="<?= $width ?>" height="<?= $height ?>"<?php endif ?><?= $ratio ?> loading="lazy">
        </picture>
      </a>
  </div>
  <?php elseif ($block->linkOption() == "link" && $link->isNotEmpty()): ?>
  <a href="<?= $link->toUrl() ?>"<?php e($block->newTab()->isTrue(), ' target="_blank"') ?>>
    <picture>
      <?php if ($block->location() == 'kirby' && $image = $block->image()->toImage()): ?>
      <source type="image/webp" srcset="<?= $srcset ?>" />
      <?php endif ?>
      <img src="<?= $src ?>"<?= $class ?> alt="<?= $alt ?>"<?php if ($block->location() == 'kirby' && $image = $block->image()->toImage()): ?> width="<?= $width ?>" height="<?= $height ?>"<?php endif ?><?= $ratio ?> loading="lazy">
    </picture>
  </a>
  <?php else: ?>
  <picture>
    <?php if ($block->location() == 'kirby' && $image = $block->image()->toImage()): ?>
    <source type="image/webp" srcset="<?= $srcset ?>" />
    <?php endif ?>
    <img src="<?= $src ?>"<?= $class ?> alt="<?= $alt ?>"<?php if ($block->location() == 'kirby' && $image = $block->image()->toImage()): ?> width="<?= $width ?>" height="<?= $height ?>"<?php endif ?><?= $ratio ?> loading="lazy">
  </picture>
  <?php endif ?>

  <?php if ($caption->isNotEmpty()): ?>
  <figcaption<?php if ($block->captionCLass() == "true"): ?> class="tm-figcaption"<?php endif ?>>
  <?php if($block->location() == 'kirby' && $image->link()->isNotEmpty()): ?>
    <a href="<?= $image->link() ?>"><?= $caption ?></a>
  <?php else: ?>
    <?= $caption ?>
  <?php endif ?>
  </figcaption>
  <?php endif ?>
</figure>
<?php endif ?>