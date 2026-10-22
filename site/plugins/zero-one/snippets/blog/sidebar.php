<aside>
  <!-- About -->
  <?php if($page->sidebarProfile() == "true"): ?>
  <div class="uk-card uk-card-small uk-card-secondary uk-margin-bottom">
    <?php if($img = $page->profileImage()->toFile()): ?>
    <div class="uk-card-media-top">
      <picture>
        <source type="image/webp" srcset="<?= $img->thumb(['crop' => true, 'width' => 600, 'height' => 400, 'format' => 'webp'])->url() ?>" />
        <img src="<?= $img->crop(600, 400)->url() ?>" alt="<?= $img->alt() ?>" width="600" height="400" loading="lazy">
      </picture>
    </div>
    <?php endif ?>
    <div class="uk-card-body">
        <h3 class="uk-card-title"><?= $page->profileHeading()->html() ?></h3>
        <?= $page->profileText()->kt() ?>
    </div>
  </div>
  <?php endif ?>
  <?php if($page->sidebarCategories() == "true" && count($all_articles->pluck('category', ',', true)) > null): ?>
  <!-- Categories -->
  <div class="tm-sidebar-block">
    <h4><?= $site->labelCategories()->html() ?></h4>
    <ul class="uk-list uk-list-divider">
      <?php foreach($all_articles->pluck('category', ',', true) as $category): ?>
      <li>
        <a href="<?= url($lang . '/' . $page->slug(), ['params' => ['category' => urlencode($category)]]) ?>"><?= Str::ucfirst($category) ?></a> <sup>(<?= $all_articles->filterBy('category', $category)->count() ?>)</sup>
      </li>
      <?php endforeach ?>
    </ul>
  </div>
  <?php endif ?>

  <?php if($page->sidebarArchive() == "true" && $articles->count() > null): ?>
  <!-- Archive -->
  <div class="tm-sidebar-block">
    <h4><?= $site->labelArchive()->html() ?></h4>
    <ul class="uk-list uk-list-divider">
      <?php foreach ($all_articles->group(function ($p) { return $p->date()->toDate('Y'); }) as $year => $yearList): ?>
        <li>
          <a href="<?= url($lang . '/' . $page->slug(), ['params' => ['year' => $year]]) ?>"><?= $year ?></a> <sup>(<?= $all_articles->filter(function($p) use($year) { return $p->date()->toDate('Y') == $year;})->count() ?>)</sup>
        </li>
      <?php endforeach ?>
    </ul>
  </div>
  <?php endif ?>

  <?php if($page->sidebarTags() == "true" && count($all_articles->pluck('tags', ',', true)) > null): ?>
  <!-- Tags -->
  <div class="tm-sidebar-block">
    <h4><?= $site->labelTags()->html() ?></h4>
    <div>
      <?php foreach($all_articles->pluck('tags', ',', true) as $tag): ?>
      <a href="<?= url($lang . '/' . $page->slug(), ['params' => ['tag' => urlencode($tag)]]) ?>"><span class="uk-label">#<?= $tag ?></span></a>
      <?php endforeach ?>
    </div>
  </div>
  <?php endif ?>

  <?php if($page->sidebarSocialmedia() == "true" && $site->social()->toStructure()->isNotEmpty()): ?>
  <!-- Social Media -->
  <div class="tm-sidebar-block">
    <h4><?= $site->labelStayconnected()->html() ?></h4>
    <?php foreach($site->social()->toStructure() as $social): ?>
    <a href="<?= $social->url() ?>" target="_blank" class="uk-icon-button uk-button-default uk-margin-small-right" uk-icon="icon: <?= Str::lower($social->platform()) ?>; ratio: 1;"></a>
    <?php endforeach ?>
  </div>
  <?php endif ?>
</aside>