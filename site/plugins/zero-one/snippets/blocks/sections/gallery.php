<section<?php if($data->blockID()->isNotEmpty()): ?> id="<?= $data->blockID()->value() ?>"<?php endif ?> class="<?php e($data->galleryBack() == "muted", ' uk-background-muted') ?><?php e($data->galleryBack() == "primary", ' uk-background-primary') ?><?php e($data->galleryBack() == "secondary", ' uk-background-secondary') ?><?php if($data->blockClass()->isNotEmpty()): ?> <?= $data->blockClass()->value() ?><?php endif ?>">
<div class="uk-container<?php e($data->galleryWidth() == "xsmall", ' uk-container-xsmall') ?><?php e($data->galleryWidth() == "small", ' uk-container-small') ?>">
<div class="uk-padding-large uk-padding-remove-horizontal">
<div class="uk-child-width-1-2@s<?php e($data->galleryGrid() == "three", ' uk-child-width-1-3@m') ?><?php e($data->galleryGrid() == "four", ' uk-child-width-1-4@m') ?>"<?php e($data->galleryThumbnails() == "masonry", ' uk-grid="masonry: true"', ' uk-grid') ?> uk-lightbox>
<?php
$images =  $data->gallery()->toFiles();
foreach($images as $image): ?>
<div>
<a class="uk-inline-clip uk-transition-toggle" href="<?= $image->url() ?>" data-no-swup data-caption="<?= $image->caption() ?>" data-alt="<?= $image->alt() ?>" tabindex="0">
    <picture>
        <source type="image/webp" srcset="<?php if($data->galleryThumbnails() == "masonry"): ?><?= $image->thumb(['width' => 900, 'format' => 'webp'])->url() ?><?php else: ?><?= $image->thumb(['crop' => true, 'width' => 900, 'height' => 600, 'format' => 'webp'])->url() ?><?php endif ?>" />
        <img src="<?php if($data->galleryThumbnails() == "masonry"): ?><?= $image->resize(900)->url() ?><?php else: ?><?= $image->crop(900, 600)->url() ?><?php endif ?>" alt="<?= $image->alt() ?>"<?php if($data->galleryThumbnails() == "masonry"): ?> width="<?= $image->width() ?>" height="<?= $image->height() ?>"<?php else: ?> width="900" height="600"<?php endif ?> loading="lazy">
    </picture>
    <div class="uk-transition-fade uk-position-cover uk-overlay uk-overlay-secondary">
        <div class="uk-position-center uk-light">
            <span uk-icon="icon: plus; ratio: 1.5"></span>
        </div>
    </div>
</a>
</div>
<?php endforeach ?>
</div>
</div>
</div>
</section>