<?php 

$projects = $data->projects()->toPages()->count() > 0 ? $data->projects()->toPage()->children()->limit(5) : $kirby->collection('projects')->limit(5);

$cover_width = $site->coverWidth()->isNotEmpty() ? $site->coverWidth()->toInt() : '600';
$cover_height = $site->coverHeight()->isNotEmpty() ? $site->coverHeight()->toInt() : '800';

?>
<section<?php if($data->blockID()->isNotEmpty()): ?> id="<?= $data->blockID()->value() ?>"<?php endif ?> class="uk-section<?= $data->sectionSize() ?><?= $data->projectsColor() ?><?php if($data->blockClass()->isNotEmpty()): ?> <?= $data->blockClass()->value() ?><?php endif ?>">
<div class="uk-container">
<?php if($data->projectsTextOption() == "top"): ?>
<div class="uk-width-2-3@s uk-margin-medium">
<?= $data->projectsText()->kt() ?>
</div>
<?php endif ?>
<div uk-grid>
<?php if($data->projectsTextOption() == "left"): ?>
    <div class="uk-width-1-3@m uk-margin-right">
    <?= $data->projectsText()->kt() ?>
    </div>
<?php endif ?>
    <div class="uk-slider uk-width-expand" uk-slider>
    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
        <ul class="uk-slider-items uk-grid<?php e($data->projectsTextOption() == "top", ' uk-child-width-1-3@s') ?><?php e($data->projectsTextOption() == "left", ' uk-child-width-1-2@s') ?>">
    <?php foreach ($projects as $project) : ?>
        <li>
        <?php if($img = $project->cover()->toImage()): ?>
        <a href="<?= $project->url() ?>" class="uk-link-toggle">
        <div class="tm-projects uk-inline-clip uk-transition-toggle" tabindex="0">
            <?php if($data->projectsCover()->isTrue()): ?>
            <picture>
                <source type="image/webp" srcset="<?= $img->thumb(['crop' => 'true', 'width' => $data->coverWidth()->or(600)->int(), 'height' => $data->coverHeight()->or(800)->int(), 'format' => 'webp'])->url() ?>" />
                <img class="uk-transition-scale-up uk-transition-opaque" src="<?= $img->crop($data->coverWidth()->or(600)->int(), $data->coverHeight()->or(800)->int())->url() ?>" alt="<?= $project->title()->html() ?>" width="<?= $data->coverWidth()->or(600)->int() ?>" height="<?= $data->coverHeight()->or(800)->int() ?>" loading="lazy">
            </picture>
            <?php else: ?>
            <picture>
                <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $cover_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => 'true', 'width' => $cover_width, 'height' => $cover_height, 'format' => 'webp'])->url()) ?>" />
                <img class="uk-transition-scale-up uk-transition-opaque" src="<?php e($img->getClip() !== null, $img->resize(null, $cover_height)->url(), $img->crop($cover_width, $cover_height)->url()) ?>" alt="<?= $project->title()->html() ?>" width="<?= $img->resize()->width() ?>" height="<?= $img->resize()->height() ?>" loading="lazy">
            </picture>
            <?php endif ?>
            <div class="uk-overlay-gradient uk-position-cover"></div>
            <div class="uk-overlay uk-position-bottom uk-light">
                <h3 class="uk-h2"><?= $project->title()->html() ?></h3>
                <?php if($project->intro()->isNotEmpty()): ?>
                <p class="tm-project-description uk-visible@s"><?= $project->intro()->kt()->excerpt(60) ?></p>
                <?php endif ?>
            </div>
        </div>
        </a>
        <?php endif ?>
        </li>
    <?php endforeach ?>
        </ul>
            <a class="uk-position-center-left uk-slidenav-large" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-slidenav-large" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
        </div>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
    </div>
</div>
</div>
</section>