<?php 

$blockID          = $data->blockID()->isNotEmpty() ? 'id="' . $data->blockID()->value() . '" ' : null;
$blockClass       = $data->blockClass()->isNotEmpty() ? ' ' . $data->blockClass()->value() : null;
$marginVertical   = $data->marginVertical()->isNotEmpty() ? $data->marginVertical() : null;
$marginLeft       = $data->marginLeft()->isNotEmpty() ? $data->marginLeft() : null;
$marginRight      = $data->marginRight()->isNotEmpty() ? $data->marginRight() : null;
$animation        = $data->animationSwitch()->isTrue() ? ' uk-scrollspy="cls:' . $data->animationType()->or('uk-animation-fade') . '; delay:' . $data->animationDelay()->or('200')->toInt() . '"' : null;
$imageWidth       = $data->imageWidth()->isNotEmpty() ? $data->imageWidth()->toInt() : '1200';
$imageHeight      = $data->imageHeight()->isNotEmpty() ? $data->imageHeight()->toInt() : '800';
$itemWidth        = $data->sliderItemWidth()->isNotEmpty() ? $data->sliderItemWidth() : null;
$itemsGap         = $data->sliderItemsGap()->isNotEmpty() ? $data->sliderItemsGap() : null;
$centerItems      = $data->centerItems()->isTrue() ? 'center: true;' : null;
$autoplay         = $data->autoplay()->isTrue() ? 'autoplay: true;' : null;
$finite           = $data->finite()->isTrue() ? 'finite: true;' : 'finite: false;';
$slideSets        = $data->slideSets()->isTrue() ? 'sets: true;' : null;
$arrowsOut        = $data->navigationArrows() == 'out' ? 'uk-visible@s' : 'uk-hidden';
$arrowsInside     = $data->navigationArrows() == 'inside' ? null : ' uk-hidden@s';

?>
<div <?= $blockID ?>class="<?= $blockClass ?><?= $marginVertical ?><?= $marginLeft ?><?= $marginRight ?>"<?= $animation ?>>
<div class="uk-slider uk-visible-toggle" tabindex="-1" uk-slider="<?= $centerItems ?><?= $autoplay ?><?= $finite ?><?= $slideSets ?>">
    <div class="uk-position-relative">
        <div class="uk-slider-container">
            <ul class="uk-slider-items uk-grid uk-grid-match<?= $itemsGap ?>">
            <?php
            $images =  $data->slider()->toFiles();
            foreach($images as $image): ?>
                <li class="uk-transition-toggle uk-width-1-1<?= $itemWidth ?>" tabindex="0">
                    <div class="uk-cover-container<?php e($site->siteBorderRadius() == "true", ' uk-border-rounded') ?>">
                        <canvas width="<?= $imageWidth ?>" height="<?= $imageHeight ?>"></canvas>
                        <picture>
                            <source type="image/webp" srcset="<?= $image->thumb(['crop' => true, 'width' => $imageWidth, 'height' => $imageHeight, 'format' => 'webp'])->url() ?>" />
                            <img src="<?= $image->crop($imageWidth, $imageHeight)->url() ?>" alt="<?= $image->alt() ?>" width="<?= $imageWidth ?>" height="<?= $imageHeight ?>" loading="lazy" uk-cover>
                        </picture>
                        <?php if ($image->caption()->isNotEmpty()): ?>
                        <div class="uk-position-bottom uk-position-small uk-overlay uk-overlay-secondary uk-text-center uk-transition-slide-bottom-small<?php e($site->siteBorderRadius() == "true", ' uk-border-rounded') ?>">
                            <h4>
                            <?php if($image->link()->isNotEmpty()): ?>
                                <a href="<?= $image->link() ?>"><?= $image->caption() ?></a>
                            <?php else: ?>
                                <?= $image->caption() ?>
                            <?php endif ?>
                            </h4>
                        </div>
                        <?php endif ?>
                    </div>
                </li>
            <?php endforeach ?>
            </ul>
            <div class="uk-light<?= $arrowsInside ?>">
                <a class="uk-position-center-left uk-slidenav-large" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-slidenav-large" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
            </div>
        </div>
        <div class="<?= $arrowsOut ?>">
            <a class="uk-position-center-left-out uk-slidenav-large uk-position-small" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right-out uk-slidenav-large uk-position-small" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
        </div>
    </div>
    <?php if ($data->navigationBullets()->isTrue()): ?>
    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
    <?php endif ?>
</div>
</div>