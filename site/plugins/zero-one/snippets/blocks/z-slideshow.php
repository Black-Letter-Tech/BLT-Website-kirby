<div<?php if($data->blockID()->isNotEmpty()): ?> id="<?= $data->blockID()->value() ?>"<?php endif ?><?php if($data->blockClass()->isNotEmpty()): ?> class="<?= $data->blockClass()->value() ?>"<?php endif ?>>
<?php if ($data->slideshow()->isNotEmpty()): ?>
<div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slideshow="animation: <?= $data->slideshowAnimation() ?>; ratio: <?php e($data->slideshowSize()->isTrue() && $data->slideshowRatio()->isNotEmpty(), $data->slideshowRatio(), 'false') ?>; autoplay: <?php e($data->slideshowAutoplay()->isTrue(), 'true', 'false') ?>; autoplay-interval: 7000; pause-on-hover: true;<?php if ($data->slideshowSize()->isTrue()): ?><?php e($data->slideshowMinHeight()->isNotEmpty(), ' min-height:' . $data->slideshowMinHeight()->toInt() . ';') ?><?php e($data->slideshowMaxHeight()->isNotEmpty(), ' max-height:' . $data->slideshowMaxHeight()->toInt() . ';') ?><?php endif ?>">
<ul class="uk-slideshow-items"<?php if ($data->slideshowSize() != "true"): ?> uk-height-viewport="<?php e($data->slideshowMinHeight()->isNotEmpty(), ' min-height:' . $data->slideshowMinHeight()->toInt() . ';') ?><?php e($data->slideshowMaxHeight()->isNotEmpty(), ' max-height:' . $data->slideshowMaxHeight()->toInt() . ';') ?>"<?php endif ?>>
    <?php foreach ($data->slideshow()->toStructure() as $slide): ?>
    <li>
    <?php if($image = $slide->slideImage()->toFile()): ?>
    <?php e($data->slideshowKenBurns() == "true", '<div class="uk-position-cover uk-animation-kenburns">') ?>
    <picture>
        <source type="image/webp" srcset="<?= $image->thumb(['format' => 'webp'])->url() ?>" />
        <img src="<?= $image->url() ?>" alt="<?= $image->alt() ?>" loading="lazy" uk-cover>
    </picture>
    <?php e($data->slideshowKenBurns() == "true", '</div>') ?>
    <?php if ($slide->contentBlocks()->isNotEmpty()): ?>
        <?php if($data->slideshowStyle() == "gradient-cover"): ?>
        <div class="uk-overlay-gradient uk-position-cover"></div>
        <?php endif ?>
        <?php if($slide->slideContentPosition() == "container"): ?>
        <div class="uk-position-cover uk-flex uk-flex-left uk-flex-middle uk-container uk-section" style="margin-bottom:<?php e($page->transparentNavbar() == "transparent", '20px', '80px') ?>;" uk-slideshow-parallax="x: 100,-100">
            <div class="uk-panel<?= $slide->slideContentWidth() ?> uk-light uk-margin-remove-first-child">
                <div class="<?= $data->slideContentPadding() ?>">
                <?= $slide->contentBlocks()->toBlocks() ?>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="uk-overlay<?= $slide->slideContentWidth() ?><?php if($slide->slideContentPosition() != "center"): ?><?= $slide->slideContentPosition() ?><?php endif ?><?php if($slide->slideContentPosition() == "center"): ?><?= $slide->slideContentPositionCenter() ?><?php endif ?><?= $data->slideContentPositionSize() ?><?php if($data->slideshowStyle() == "gradient-cover"): ?><?php e($data->inverseTextColor() == "true", ' uk-dark', ' uk-light') ?><?php else: ?><?= $data->slideshowStyle() ?><?php endif ?><?php e($slide->slideContentPosition() == "center", ' uk-transition-fade') ?>"<?php e($slide->slideContentPosition() != "center", ' uk-slideshow-parallax="x: 100,-100"') ?>>
            <div class="<?= $data->slideContentPadding() ?>">
            <?= $slide->contentBlocks()->toBlocks() ?>
            </div>
        </div>
        <?php endif ?>
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
</div>