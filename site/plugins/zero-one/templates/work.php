<?php snippet('header') ?>

<main role="main">
<?php if($page->headersection() == "false"): ?><?php else: ?>
<?php snippet('page/heading') ?>
<?php endif ?>
<div class="uk-container uk-margin-large<?php e($page->pageWidth() == "xsmall", ' uk-container-xsmall') ?><?php e($page->pageWidth() == "small", ' uk-container-small') ?><?php e($page->pageWidth() == "xlarge", ' uk-container-xlarge') ?><?php e($img = $page->header()->toFile() or $img = $site->header()->toFile(), ' uk-margin-large', ' uk-margin-large-bottom') ?>" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: section div; delay: 100">
<?php if($page->projectsStyle() == "stacked"): ?>
<?php foreach($projects as $project): ?>
<section class="tm-project uk-grid-match uk-grid-large" uk-grid>
    <?php if($img = $project->cover()->toImage()): ?>
    <div class="tm-project-image uk-width-1-2@s uk-flex-center">
    <a class="uk-link-toggle" href="<?= $project->url() ?>" uk-parallax="media: @m; y: -50; easing: -1.2">
    <span class="tm-hover-img">
      <picture>
        <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $cover_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => 'true', 'width' => $cover_width, 'height' => $cover_height, 'format' => 'webp'])->url()) ?>" />
        <img class="uk-transition-scale-up uk-transition-opaque" src="<?php e($img->getClip() !== null, $img->resize(null, $cover_height)->url(), $img->crop($cover_width, $cover_height)->url()) ?>" alt="<?= $project->title()->html() ?>" width="<?= $img->resize()->width() ?>" height="<?= $img->resize()->height() ?>" loading="lazy">
      </picture>
    </span>
    </a>
    </div>
    <?php endif ?>
    <div class="uk-flex-middle uk-flex-center uk-width-1-2@s">
      <div class="uk-margin-bottom">
      <h2 uk-parallax="media: @m; y: -20; easing: 0.9"><a class="uk-link-heading uk-heading-small tm-shine" href="<?= $project->url() ?>"><?= $project->title()->html() ?></a></h2>
      <hr class="uk-divider-small">
      <div class="uk-text-lead"><?= $project->intro()->kt() ?></div>      
      <div>
        <a class="uk-button uk-button-link uk-button-small uk-margin-top" href="<?= $project->url() ?>" uk-parallax="media: @m; y: 10; easing: 0.5"><?= $site->labelProjectButton()->html() ?><span class="tm-button-link-line"></span></a>
      </div>
      </div>
    </div>
</section>
<?php endforeach ?>
<?php else: ?>
<section class="uk-grid<?= ' ' . $page->gridGap() ?><?php e($page->projectsStyle() == "grid3" or $page->projectsStyle() == "grid4", $page->projectsStyle() == "grid3" ? ' uk-child-width-1-2@s uk-child-width-1-3@m' : ' uk-child-width-1-2@s uk-child-width-1-4@m', ' uk-child-width-1-2@s') ?>" uk-grid<?php e($page->projectsMasonry()->isTrue(), '="masonry: true"') ?>>
<?php foreach($projects as $project): ?>
  <div>
  <?php if($img = $project->cover()->toImage()): ?>
  <a href="<?= $project->url() ?>" class="uk-link-toggle">
  <div class="tm-projects uk-inline-clip uk-transition-toggle" tabindex="0">
    <picture>
      <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $cover_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => 'true', 'width' => $cover_width, 'height' => $cover_height, 'format' => 'webp'])->url()) ?>" />
      <img class="uk-transition-scale-up uk-transition-opaque" src="<?php e($img->getClip() !== null, $img->resize(null, $cover_height)->url(), $img->crop($cover_width, $cover_height)->url()) ?>" alt="<?= $project->title()->html() ?>" width="<?= $img->resize()->width() ?>" height="<?= $img->resize()->height() ?>" loading="lazy">
    </picture>
    <div class="uk-overlay-gradient uk-position-cover"></div>
    <div class="uk-overlay uk-position-bottom uk-light<?php e($page->projectsStyle() == "grid" && $page->pageWidth() != "small" && $page->pageWidth() != "xsmall", ' uk-position-large', ' uk-position-small') ?>">
      <?php if($page->projectsStyle() == "grid" && $page->pageWidth() != "small" && $page->pageWidth() != "xsmall"): ?>
      <h2 class="uk-heading-small"><?= $project->title()->html() ?></h2>
      <?php if($project->intro()->isNotEmpty()): ?>
      <p class="tm-project-description uk-visible@s"><?= $project->intro()->kt()->excerpt(100) ?></p>
      <?php endif ?>
      <?php else: ?>
      <h2><?= $project->title()->html() ?></h2>
      <?php if($project->intro()->isNotEmpty()): ?>
      <p class="tm-project-description uk-visible@s"><?= $project->intro()->kt()->excerpt(60) ?></p>
      <?php endif ?>
      <?php endif ?>
    </div>
  </div>
  </a>
  <?php endif ?>
</div>
<?php endforeach ?>
</section>
<?php endif ?>

<?php snippet('work/oldernewer') ?>
</div>
</main>

<?php snippet('footer') ?>