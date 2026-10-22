<?php
$related = $page->related()->toPages();
 
$similarPages = $page->similar([
  'index' => $page->siblings(false)->listed(),
  'fields'         => ['tags' => 1, 'category' => 2],
  'threshold'      => 0.2,
  'delimiter'      => ',',
  'languageFilter' => false
]);

$articles = $related->count() > 0 ? $related : $similarPages->shuffle()->limit(5);
 
?>

<?php if ($related->count() > 0 or $similarPages->count() >= 1): ?>
<hr>
<h4><?= h($site->labelRelatedArticle()) ?></h4>
<div class="uk-slider-container-offset uk-slider" uk-slider="finite: true">
  <div class="uk-position-relative uk-visible-toggle" tabindex="-1">
      <ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m uk-grid uk-grid-small uk-grid-match" uk-grid>
        <?php foreach($articles as $article): ?>
        <li>
          <article class="uk-card">
            <?php if($img = $article->cover()->toFile()): ?>
            <div class="uk-card-media-top">
            <a href="<?= $article->url() ?>">
              <picture>
                <source type="image/webp" srcset="<?= $img->thumb(['crop' => true, 'width' => 400, 'height' => 500, 'format' => 'webp'])->url() ?>" />
                <img src="<?= $img->crop(400, 500)->url() ?>" alt="<?= $article->title()->html() ?>" width="400" height="500" loading="lazy">
              </picture>
            </a>
            </div>
            <?php endif ?>
            <div class="uk-card-body uk-card-small">
              <h5><a class="uk-link-heading" href="<?= $article->url() ?>"><?= $article->title()->html() ?></a></h5>
            </div>
          </article>
        </li>
        <?php endforeach ?>
      </ul>
      <a class="uk-position-center-left uk-slidenav-large" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
      <a class="uk-position-center-right uk-slidenav-large" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
  </div>
  <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
</div>
<?php endif ?>
