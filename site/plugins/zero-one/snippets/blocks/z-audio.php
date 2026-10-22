<?php if ($file = $block->source()->toFile()): ?>
<div class="uk-card uk-grid uk-grid-collapse<?= $block->background() ?>" uk-grid>
  <?php if ($poster = $block->poster()->toFile()): 
    
    $imgWidth = $block->layout() != "true" ? '400' : '600';

    ?>
  <div class="<?php e($block->layout() != "true", 'uk-width-1-3@s uk-card-media-left uk-cover-container', 'uk-card-media-top') ?>">
    <picture>
      <source type="image/webp" srcset="<?= $poster->thumb(['crop' => true, 'width' => $imgWidth, 'height' => 400, 'format' => 'webp'])->url() ?>" />
      <img src="<?= $poster->crop($imgWidth, 400)->url() ?>" alt="<?= $poster->alt() ?>" loading="lazy"<?php e($block->layout() != "true", ' uk-cover') ?>>
    </picture>
    </canvas><?php e($block->layout() != "true", '<canvas width="400" height="400">') ?>
  </div>
  <?php endif ?>
  <div class="uk-card-body uk-padding<?php e($block->layout() != "true", ' uk-width-expand') ?>">
  <?php if ($block->title()->isNotEmpty()): ?>
    <h3 class="uk-card-title uk-margin-remove-bottom"><?= $block->title()->html() ?></h3>
  <?php endif ?>
  <?php if ($block->subtitle()->isNotEmpty()): ?>
    <h4 class="uk-text-muted"><?= $block->subtitle()->html() ?></h4>
  <?php endif ?>
  <?php if ($block->description()->isNotEmpty()): ?>
    <div class="uk-text-small">
      <?= $block->description() ?>
    </div>
  <?php endif ?>
    <audio class="tm-audio uk-margin"<?= $block->controls()->isTrue() ? ' controls' : '' ?><?= $block->autoplay()->isTrue() ? ' autoplay' : '' ?>>
      <source src="<?= $file->url()?>" type="<?= $file->mime() ?>">
      <?= $block->fallbackText()->or('Your browser does not support the <code>audio</code> element.') ?>
    </audio>
  </div>
</div>
<?php endif ?>