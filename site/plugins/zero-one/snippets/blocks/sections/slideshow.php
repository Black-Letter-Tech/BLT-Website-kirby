<section<?php if($data->blockID()->isNotEmpty()): ?> id="<?= $data->blockID()->value() ?>"<?php endif ?> class="<?php e($data->slideshowWidth() == "large", ' uk-container uk-container-xlarge') ?><?php if($data->blockClass()->isNotEmpty()): ?> <?= $data->blockClass()->value() ?><?php endif ?>">
<?php if ($data->slideshow()->isNotEmpty()): ?>
<div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slideshow="animation: <?= $data->slideshowAnimation() ?>; ratio: false; autoplay: true; autoplay-interval: 10000; pause-on-hover: true">
<ul class="uk-slideshow-items" uk-height-viewport="offset-top: true; offset-bottom: 5">
    <?php foreach ($data->slideshow()->toStructure() as $slide): ?>
    <li>
    <?php if($image = $slide->slideImage()->toFile()): ?>
    <?php e($data->slideshowKenBurns() == "true", '<div class="uk-position-cover uk-animation-kenburns">') ?>
    <picture>
        <source type="image/webp" srcset="<?= $image->thumb(['format' => 'webp'])->url() ?>" />
        <img src="<?= $image->url() ?>" alt="<?= $image->alt() ?>" loading="lazy" uk-cover>
    </picture>
    <?php e($data->slideshowKenBurns() == "true", '</div>') ?>
    <?php if (($slide->slideContentOption() == "markdown" && $slide->slideContent()->isNotEmpty()) or ($slide->slideContentOption() == "editor" && $slide->contentBlocks()->isNotEmpty()) or ($slide->slideContentOption() == "html" && $slide->slideHTML()->isNotEmpty())): ?>
        <?php if($data->slideshowStyle() == "gradient-cover"): ?>
        <div class="uk-overlay-gradient uk-position-cover"></div>
        <?php endif ?>
        <div class="uk-overlay<?= $slide->slideContentWidth() ?><?php if($slide->slideContentPosition() != "center"): ?><?= $slide->slideContentPosition() ?><?php endif ?><?php if($slide->slideContentPosition() == "center"): ?><?= $slide->slideContentPositionCenter() ?><?php endif ?><?= $data->slideContentPositionSize() ?><?php if($data->slideshowStyle() == "gradient-cover"): ?><?php e($data->inverseTextColor() == "true", ' uk-dark', ' uk-light') ?><?php else: ?><?= $data->slideshowStyle() ?><?php endif ?><?php e($slide->slideContentPosition() == "center", ' uk-transition-fade') ?>"<?php e($slide->slideContentPosition() != "center", ' uk-slideshow-parallax="x: 100,-100"') ?>>
            <div class="<?= $data->slideContentPadding() ?>">
            <?php if($slide->slideContentOption() == "editor"): ?>
            <?= $slide->contentBlocks()->toBlocks() ?>
            <?php elseif($slide->slideContentOption() == "html"): ?>
            <?= $slide->slideHTML()->value() ?>
            <?php else: ?>
            <?= $slide->slideContent()->kt() ?>
            <?php endif ?>
            </div>
        </div>
        <?php if ($image->caption()->isNotEmpty()): ?>
        <div class="uk-position-bottom-right uk-label uk-label-secondary uk-position-small">
        <?php if($image->link()->isNotEmpty()): ?>
            <a href="<?= $image->link() ?>"><?= $image->caption() ?></a>
        <?php else: ?>
            <?= $image->caption() ?>
        <?php endif ?>
        </div>
        <?php endif ?>
    <?php endif ?>
    <?php endif ?>
    </li>
    <?php endforeach ?>
</ul>
    <?php if($data->slideshowNavigationType() == "thumbnails"): ?>
    <div class="uk-position-bottom-right uk-position-medium uk-visible@s">
        <ul class="uk-thumbnav">
        <?php $number = -1; foreach ($data->slideshow()->toStructure() as $slide): $number++; ?>
        <?php if ($image = $slide->slideImage()->toFile()): ?>
            <li uk-slideshow-item="<?= $number ?>" class="<?php e($slide->isActive(), 'uk-active') ?>">
                <a href="#" data-no-swup>
                    <picture>
                        <source type="image/webp" srcset="<?= $image->thumb(['crop' => true, 'width' => 150, 'height' => 100, 'format' => 'webp'])->url() ?>" />
                        <img src="<?= $image->crop(150, 100)->url() ?>" alt="<?= $image->alt() ?> thumbnail" loading="lazy">
                    </picture>
                </a>
            </li>
        <?php endif ?>
        <?php endforeach ?>
        </ul>
    </div>
    <?php else: ?>
    <div class="uk-slidenav-container uk-position-bottom-right uk-overlay uk-visible@s<?= $data->slideContentPositionSize() ?><?php if($data->slideshowStyle() == "gradient-cover"): ?><?php e($data->inverseTextColor() == "true", ' uk-dark', ' uk-light') ?><?php else: ?><?= $data->slideshowStyle() ?><?php endif ?>">
        <a class="uk-slidenav-large" href="#" data-no-swup uk-slidenav-previous uk-slideshow-item="previous"></a>
        <a class="uk-slidenav-large" href="#" data-no-swup uk-slidenav-next uk-slideshow-item="next"></a>
    </div>
    <?php endif ?>
</div>
<?php endif ?>
</section>