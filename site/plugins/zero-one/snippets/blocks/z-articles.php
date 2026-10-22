<?php 

$blockID          = $data->blockID()->isNotEmpty() ? ' id="' . $data->blockID()->value() . '"' : null;
$blockClass       = $data->blockClass()->isNotEmpty() ? ' class="' . $data->blockClass()->value() . '"' : null;
$columnWidth      = $data->columnWidth()->isNotEmpty() ? ' ' . $data->columnWidth() : ' uk-child-width-1-4@m';
$tabletWidth      = $data->tabletWidth()->isNotEmpty() ? ' ' . $data->tabletWidth() : ' uk-child-width-1-2@s';
$maxArticles      = $data->maxArticles()->isNotEmpty() ? $data->maxArticles()->toInt() : '4';
$articles         = $data->articles()->toPages()->count() > 0 ? $data->articles()->toPage()->children()->listed()->sortBy('date')->flip()->limit($maxArticles) : $kirby->collection('articles')->limit($maxArticles);

?>
<div<?= $blockID ?><?= $blockClass ?> uk-scrollspy="cls: uk-animation-slide-bottom-small; target: section .uk-card; delay: 200">
<div class="uk-grid uk-grid-small uk-grid-match<?= $tabletWidth ?><?= $columnWidth ?>" uk-grid>
<?php foreach ($articles as $article) : ?>
<?php if($data->articlesImage() == 'true') : ?>
<div>
<article class="uk-card uk-card-small uk-transition-toggle uk-card-hover<?php e($data->articlesColor() == "muted", ' uk-card-default') ?><?php e($data->articlesColor() == "primary", ' uk-card-primary') ?><?php e($data->articlesColor() == "secondary", ' uk-card-secondary') ?>" tabindex="0">
<?php if($img = $article->cover()->toFile()): ?>
<div class="uk-card-media-top uk-inline-clip">
<a href="<?= $article->url() ?>">
  <picture>
    <source type="image/webp" srcset="<?= $img->thumb(['crop' => true, 'width' => 500, 'height' => 400, 'format' => 'webp'])->url() ?>" />
    <img class="uk-transition-scale-up uk-transition-opaque" src="<?= $img->crop(500, 400)->url() ?>" alt="<?= $article->title()->html() ?>" width="500" height="400" loading="lazy">
  </picture>
</a>
</div>
<?php endif ?>
<div class="uk-card-body">
<p class="uk-article-meta"><?= $site->labelPublished()->html() ?> <time><?= $article->date()->html()->toDate($article->parent()->dateFormat()->html()) ?></time></p>
<h3<?php e($data->articleTitleSize()->isNotEmpty(), ' class="' . $data->articleTitleSize() . '"') ?>><a href="<?= $article->url() ?>"><?= $article->title()->html() ?></a></h3>
</div>
</article>
</div>
<?php else: ?>
  <div>
    <article class="uk-card uk-card-small uk-card-body uk-card-hover<?php e($data->articlesColor() == "muted", ' uk-card-default') ?><?php e($data->articlesColor() == "primary", ' uk-card-primary') ?><?php e($data->articlesColor() == "secondary", ' uk-card-secondary') ?>">
    <h3<?php e($data->articleTitleSize()->isNotEmpty(), ' class="' . $data->articleTitleSize() . '"') ?>><a href="<?= $article->url() ?>"><?= $article->title()->html() ?></a></h3>
    <p class="uk-article-meta"><?= $site->labelPublished()->html() ?> <time><?= $article->date()->html()->toDate($article->parent()->dateFormat()->html()) ?></time></p>
    <?= $article->desc()->kt()->excerpt(90) ?>
    <p><a class="uk-button uk-button-text" href="<?= $article->url() ?>"><?= $site->labelReadMore()->html() ?></a></p>
    </article>
  </div>
  <?php endif ?>
<?php endforeach ?>
</div> 
</div>