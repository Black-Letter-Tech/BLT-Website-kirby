<?php snippet('header') ?>

<article role="article">
  <header class="uk-margin-bottom uk-animation-slide-bottom-small<?php e($page->parent()->coverWidthArticle() == "default", ' uk-container') ?><?php e($page->parent()->coverWidthArticle() == "large", ' uk-container uk-container-expand') ?>">
  <?php if($img = $page->cover()->toFile()): ?>
  <div class="uk-section-large uk-background-cover uk-background-center-center uk-text-center<?php e($page->parent()->inverseImageTextColor() == "true", ' uk-dark', ' uk-light') ?>" sources="srcset: <?= $img->thumb(['crop' => 'true', 'width' => 1920, 'height' => 900, 'format' => 'webp'])->url() ?>" data-src="<?= $img->crop(1920, 900)->url() ?>" style="background-color: rgba(0,0,0,0.45); background-blend-mode: overlay; background-repeat: no-repeat" uk-parallax="bgy: -50" uk-img="loading: eager">
  <?php else: ?>
  <div class="uk-section uk-section-muted uk-text-center">
  <?php endif ?>
  <div class="uk-container uk-container-xsmall uk-padding-small<?php if($page->transparentNavbar()->isEmpty()): ?><?php e($site->transparentNavbar() == "true", ' tm-transparent-navbar-positive') ?><?php elseif($page->transparentNavbar() == "transparent"): ?>  tm-transparent-navbar-positive<?php endif ?>" uk-parallax="blur: 0,3; y: 0,-30; start: 10%; end: 10%; media: @m">
  <p class="uk-article-meta">
    <?php if($page->category()->isNotEmpty()): ?>
    <?= $site->labelPostedIn()->html() ?> 
    <a href="<?= url($lang . '/' . $page->parent()->slug(), ['params' => ['category' => urlencode($page->category())]]) ?>"><?= $page->category()->tags() ?></a>.
    <?php endif ?></p>
    <h1 class="uk-article-title"><?= $page->title()->html() ?></h1>
    <p class="uk-article-meta"><?= $site->labelWrittenBy()->html() ?> <?= $author ?> <?= $site->labelWrittenOn()->html() ?> <time datetime="<?= $page->date()->toDate('c') ?>" pubdate="pubdate"><?= $page->date()->toDate($page->parent()->dateFormat()->html()) ?></time>.</p>
    <?php 
    $authors = $page->author()->toUsers();
    $total = $authors->count();
    $i = 0;
    if($page->author()->isNotEmpty() && $total > 1): ?>
    <p class="uk-article-meta"><?= $site->labelCoauthors()->html()->or('Co-authors:') ?> <?php $coauthors = $page->author()->toUsers()->offset(1); foreach($coauthors as $coauthor): ?><?php e($coauthor->name(), $coauthor->name()) ?><?php $i++; e($i !== $total - 1, ', ') ?><?php endforeach ?></p>
    <?php endif ?>
    <?php if($page->parent()->shareSwitch() == "true"): ?>
    <div class="uk-flex uk-flex-center">
    <?php snippet('article/share') ?>
    </div>
    <?php endif ?>
  </div>
  </div>
  </header>

  <?php if($page->parent()->sidebarArticle() == "yes"): ?>
  <div class="uk-container uk-container-small">
  <?php if($site->breadcrumbs() != "false"): ?>
  <div class="uk-overflow-hidden uk-visible@s">
  <?php snippet('breadcrumb') ?>
  </div>
  <?php endif ?>
  <div class="uk-grid-medium" uk-grid>

  <?php else: ?>
  <div class="uk-container uk-container-xsmall">
  <?php if($site->breadcrumbs() != "false"): ?>
  <div class="uk-overflow-hidden uk-visible@s">
  <?php snippet('breadcrumb') ?>
  </div>
  <?php endif ?>
  <?php endif ?>
  
  <?php if($page->parent()->sidebarArticle() == "yes"): ?>
  <div class="uk-width-expand">
  <?php endif ?>
    <div class="uk-text-lead">
      <?= $page->desc()->kt() ?>
    </div>
    <div>
    <?= $page->text()->toBlocks() ?>
    </div>
    <?php if($page->parent()->shareSwitch() == "true"): ?>
    <div class="uk-margin uk-padding uk-text-center uk-flex uk-flex-center">
    <?php snippet('article/share') ?>
    </div>
    <?php endif ?>
    <?php if($page->tags()->isNotEmpty()): ?>
    <div class="uk-text-center<?php if($page->parent()->shareSwitch() == "false"): ?> uk-margin<?php endif ?>"><!-- tagcloud -->
      <h4><?= $site->labelTagged() ?></h4>
      <ul class="uk-subnav uk-flex uk-flex-center">
      <?php foreach($page->tags()->split(',') as $tag): ?>
        <li>
          <a href="<?= url($lang . '/' . $page->parent()->slug(), ['params' => ['tag' => urlencode($tag)]]) ?>">#<?= $tag ?></a>
        </li>
      <?php endforeach ?>
      </ul>
    </div>
    <?php endif ?>
    <hr>
  <div class="uk-width-1-1 uk-margin-large">
    <?php snippet('article/prevnext') ?>
  </div>
  
  <div class="uk-width-1-1 <?php e($page->parent()->commentsOptionSelect() == "embed", 'uk-margin-bottom', 'uk-margin-large-bottom') ?>">
      <?php snippet('article/related') ?>
  </div>

  <?php if($page->parent()->commentsOptionSelect() == "embed"): ?>
  <hr>
  <h3><?= $site->labelCommentsHeading()->html() ?></h3>
  <div class="uk-margin-large-bottom">
  <?= $page->parent()->commentsCode()->value() ?>
  </div>
  <?php endif ?>

  <?php if($page->parent()->sidebarArticle() == "yes"): ?>
  </div>
  <?php endif ?>

  <?php if($page->parent()->sidebarArticle() == "yes"): ?>
  <div class="uk-width-1-4@s">
  <?php snippet('article/sidebar') ?>
  </div>
  </div><!-- grid end -->
  <?php endif ?>

  </div><!-- container end -->

</article>

<?php snippet('footer') ?>