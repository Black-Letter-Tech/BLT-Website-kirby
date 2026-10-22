<?php 

$articles = $data->articles()->toPages()->count() > 0 ? $data->articles()->toPage()->children()->listed()->sortBy('date')->flip()->limit(4) : $kirby->collection('articles')->limit(4);

?>
<section<?php if($data->blockID()->isNotEmpty()): ?> id="<?= $data->blockID()->value() ?>"<?php endif ?> class="uk-padding-large uk-padding-remove-horizontal<?php e($data->articlesColor() == "muted", ' uk-background-muted') ?><?php e($data->articlesColor() == "primary", ' uk-light uk-background-primary') ?><?php e($data->articlesColor() == "secondary", ' uk-light uk-background-secondary') ?><?php if($data->blockClass()->isNotEmpty()): ?> <?= $data->blockClass()->value() ?><?php endif ?>">
<div class="uk-container">
<div class="uk-width-3-4@m">
<?= $data->articlesTitle()->kt() ?>
</div>
<div class="uk-child-width-1-2@s uk-child-width-1-4@m uk-grid-small uk-grid-match" uk-grid>
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
</section>