<section<?php if($data->blockID()->isNotEmpty()): ?> id="<?= $data->blockID()->value() ?>"<?php endif ?> class="<?php e($data->sliderBack() == "muted", ' uk-background-muted') ?><?php e($data->sliderBack() == "primary", ' uk-background-primary') ?><?php e($data->sliderBack() == "secondary", ' uk-background-secondary') ?><?php if($data->blockClass()->isNotEmpty()): ?> <?= $data->blockClass()->value() ?><?php endif ?>">
<div class="uk-container<?php e($data->sliderWidth() == "xsmall", ' uk-container-xsmall') ?><?php e($data->sliderWidth() == "small", ' uk-container-small') ?>">
    <div class="uk-padding-large uk-padding-remove-horizontal<?php e($data->sliderBack() == "primary" or $data->sliderBack() == "secondary", ' uk-light') ?>">
        <div class="uk-slider uk-visible-toggle" tabindex="-1" uk-slider>
            <div class="uk-position-relative">
                <div class="uk-slider-container">
                    <ul class="uk-slider-items uk-grid uk-grid-match" uk-height-viewport="offset-top: true; offset-bottom: 25">
                    <?php
                    $images =  $data->slider()->toFiles();
                    foreach($images as $image): ?>
                        <li class="uk-transition-toggle uk-width-1-1<?= $data->sliderImgWidth() ?>" tabindex="0">
                            <div class="uk-cover-container<?php e($site->siteBorderRadius() == "true", ' uk-border-rounded') ?>">
                                <picture>
                                    <source type="image/webp" srcset="<?= $image->thumb(['crop' => true, 'width' => 1200, 'height' => 800, 'format' => 'webp'])->url() ?>" />
                                    <img src="<?= $image->crop(1200, 800)->url() ?>" alt="<?= $image->alt() ?>" loading="lazy" uk-cover>
                                </picture>
                                <?php if ($image->caption()->isNotEmpty()): ?>
                                <div class="uk-position-bottom uk-position-small uk-overlay uk-overlay-secondary uk-text-center uk-transition-slide-bottom-small<?php e($site->siteBorderRadius() == "true", ' uk-border-rounded') ?><?php e($site->siteShadows() == "true", ' uk-box-shadow-large') ?>">
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
                    <div class="uk-hidden@s uk-light">
                        <a class="uk-position-center-left uk-slidenav-large" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
                        <a class="uk-position-center-right uk-slidenav-large" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
                    </div>
                </div>
                <div class="uk-visible@s">
                    <a class="uk-position-center-left-out uk-slidenav-large uk-position-small" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right-out uk-slidenav-large uk-position-small" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
                </div>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        </div>
    </div>
</div>
</section>