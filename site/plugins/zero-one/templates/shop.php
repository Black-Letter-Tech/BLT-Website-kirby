<?php snippet('header') ?>

<main role="main">
<?php if($page->headersection() == "false"): ?><?php else: ?>
<?php snippet('page/heading') ?>
<?php endif ?>
<div class="uk-container uk-margin<?php e($page->pageWidth() == "xsmall", ' uk-container-xsmall') ?><?php e($page->pageWidth() == "small", ' uk-container-small') ?><?php e($img = $page->header()->toFile() or $img = $site->header()->toFile(), ' uk-margin-large', ' uk-margin-large-bottom') ?>" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: section > div; delay: 200">
<?php if($page->productsStyle() == "stacked"): ?>
<?php foreach($products as $product): ?>
<section class="tm-project uk-grid-match uk-grid-large" uk-grid>
  <?php if($img = $product->cover()->toImage()): ?>
  <div class="tm-project-image uk-width-1-2@s uk-flex-center">
  <a class="uk-link-toggle" href="<?= $product->url() ?>" uk-parallax="media: @m; y: -50; easing: -1.2">
  <span class="tm-hover-img">
    <picture>
      <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
      <img src="<?php e($img->getClip() !== null, $img->resize(null, $coverimg_height)->url(), $img->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $img->alt() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
    </picture>
  </span>
  </a>
  </div>
  <?php endif ?>
  <div class="uk-flex-middle uk-flex-center uk-width-1-2@s">
    <div class="uk-margin-bottom">
    <h2 uk-parallax="media: @m; y: -20; easing: 0.9"><a class="uk-link-heading uk-heading-small tm-shine" href="<?= $product->url() ?>"><?= $product->title()->html() ?></a></h2>
    <?php if($product->productShort()->isNotEmpty()): ?>
    <p class="uk-text-large uk-text-muted"><?= $product->productShort()->html() ?></p>
    <?php endif ?>
    <hr class="uk-divider-small">
    <?php if($product->productType() == "custom" && $product->customPrice()->isNotEmpty() && $product->customFree() != "true"): ?>
    <p class="uk-text-large uk-text-bold uk-text-primary">
        <?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?php e($product->customDiscountprice()->isNotEmpty(), $product->customDiscountprice()->price(), $product->customPrice()->price()) ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?>
        <?php if($product->customDiscountprice()->isNotEmpty()): ?><del class="uk-text-muted uk-margin-small-left"><?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?= $product->customPrice()->price() ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?></del><?php endif ?>
    </p>
    <?php endif ?>
    <?php if($product->productType() == "custom" && $product->customFree() == "true"): ?>
    <p class="uk-text-large uk-text-bold uk-text-primary"><?= $site->labelProductfree() ?></p>
    <?php endif ?>
    <?php if($product->productType() == "snipcart"): ?>
        <p class="uk-text-large uk-text-bold uk-text-primary">
        <?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?php e($product->snipcartDiscountprice()->isNotEmpty(), $product->snipcartDiscountprice()->price(), $product->snipcartPrice()->price()) ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?>
        <?php if($product->snipcartDiscountprice()->isNotEmpty()): ?><del class="uk-text-muted uk-margin-small-left"><?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?= $product->snipcartPrice()->price() ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?></del><?php endif ?>
    </p>
    <?php endif ?>
    <div class="uk-text-lead"><?= $product->productIntro()->kt()->excerpt(100) ?></div>      
    <div>
      <a class="uk-button uk-button-link uk-button-small uk-margin-top" href="<?= $product->url() ?>" uk-parallax="media: @m; y: 10; easing: 0.5"><?= $site->labelStackedbutton()->html() ?><span class="tm-button-link-line"></span></a>
    </div>
    </div>
  </div>
</section>
<?php endforeach ?>
<?php else: ?>
<section class="uk-grid<?php e($page->productsStyle() == "grid3", ' uk-child-width-1-2@s uk-child-width-1-3@m', ($page->productsStyle() == "grid4" ? ' uk-child-width-1-2@s uk-child-width-1-4@m' : ' uk-grid-large uk-child-width-1-2@s')) ?>" uk-grid>
<?php foreach($products as $product): ?>
<div>
  <div class="tm-product-container">
    <a href="<?= $product->url() ?>" class="uk-link-toggle">
      <?php if($img = $product->cover()->toImage()): ?>
      <div class="uk-inline-clip uk-transition-toggle<?php e($site->siteBorderRadius() == "true", ' uk-border-rounded') ?>" tabindex="0">
        <?php if($image = $product->gallery()->toImage()): ?>
          <picture>
            <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
            <img src="<?php e($img->getClip() !== null, $img->resize(null, $coverimg_height)->url(), $img->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $product->title()->html() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
          </picture>
          <?php if($image = $product->gallery()->first()->toImage()) : ?>
          <picture>
            <source type="image/webp" srcset="<?php e($image->getClip() !== null, $image->thumb(['clip' => $img->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $image->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
            <img class="uk-transition-scale-up uk-position-cover" src="<?php e($image->getClip() !== null, $image->resize(null, $coverimg_height)->url(), $image->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $image->alt() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
          </picture>
          <?php endif ?>
        <?php else: ?>
          <picture>
            <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
            <img class="uk-transition-scale-up uk-transition-opaque" src="<?php e($img->getClip() !== null, $img->resize(null, $coverimg_height)->url(), $img->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $product->title()->html() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
          </picture>
        <?php endif ?>
        <div class="uk-position-small uk-position-top-left uk-flex uk-flex-column uk-flex-wrap-top">
          <?php if($product->featured() == "true"): ?>
          <span class="uk-label uk-margin-small" style="width: max-content;"><?= $site->labelProductfeatured()->html() ?></span>
          <?php endif ?>
          <?php if($product->new() == "true"): ?>
          <span class="uk-label uk-label-success uk-margin-small" style="width: max-content;"><?= $site->labelProductnew()->html() ?></span>
          <?php endif ?>
          <?php if($product->outofstock() == "true"): ?>
          <span class="uk-label uk-label-warning uk-margin-small" style="width: max-content;"><?= $site->labelProductsold()->html() ?></span>
          <?php endif ?>
          <?php 
          
          $custom_discount = $product->customDiscountprice()->isNotEmpty() ? (($product->customPrice()->toInt() - $product->customDiscountprice()->toInt())*100) / $product->customPrice()->toInt() : null;
          
          if($product->productType() == "custom" && $product->customDiscountprice()->isNotEmpty() && $product->customFree() != "true"): ?>
          <span class="uk-label uk-label-danger uk-margin-small" style="width: max-content;">-<?= round($custom_discount) ?>%</span>
          <?php endif ?>
          <?php 
          
          $snipcart_discount = $product->snipcartDiscountprice()->isNotEmpty() ? (($product->snipcartPrice()->toInt() - $product->snipcartDiscountprice()->toInt())*100) / $product->snipcartPrice()->toInt() : null;
          
          if($product->productType() == "snipcart" && $product->snipcartDiscountprice()->isNotEmpty()): ?>
          <span class="uk-label uk-label-danger uk-margin-small" style="width: max-content;">-<?= round($snipcart_discount) ?>%</span>
          <?php endif ?>
        </div>
      </div>
      <?php endif ?>
      <div class="uk-margin">
        <h2 class="uk-h3 uk-margin-remove-bottom"><?= $product->title()->html() ?></h2>
        <?php if($product->productShort()->isNotEmpty()): ?>
        <span class="uk-text-meta"><?= $product->productShort()->html() ?></span>
        <?php endif ?>
      </div>
    </a>
    <div class="tm-product-button-container">
    <?php if(($product->productType() == "custom" && $product->customPrice()->isNotEmpty()) or $product->productType() == "snipcart"): ?>
      <div class="tm-product-button">
          <?php if($product->productType() == "custom" && $product->customPrice()->isNotEmpty() && $product->customFree() != "true"): ?>
          <span class="tm-product-price uk-text-bold uk-text-emphasis">
              <?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?php e($product->customDiscountprice()->isNotEmpty(), $product->customDiscountprice()->price(), $product->customPrice()->price()) ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?>
              <?php if($product->customDiscountprice()->isNotEmpty()): ?><del class="uk-text-muted uk-margin-small-left"><?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?= $product->customPrice()->price() ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?></del><?php endif ?>
          </span>
          <?php endif ?>
          <?php if($product->productType() == "custom" && $product->customFree() == "true"): ?>
          <span class="tm-product-price uk-text-bold uk-text-emphasis"><?= $site->labelProductfree() ?></span>
          <?php endif ?>
          <?php if($product->productType() == "snipcart"): ?>
          <span class="tm-product-price uk-text-bold uk-text-emphasis">
              <?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?php e($product->snipcartDiscountprice()->isNotEmpty(), $product->snipcartDiscountprice()->price(), $product->snipcartPrice()->price()) ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?>
              <?php if($product->snipcartDiscountprice()->isNotEmpty()): ?><del class="uk-text-muted uk-margin-small-left"><?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?= $product->snipcartPrice()->price() ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?></del><?php endif ?>
          </span>
          <?php endif ?>

          <span class="tm-product-cart">
          <?php if($product->productType() == "custom"): ?>
            <a href="<?= $product->url() ?>" class="uk-button uk-button-text uk-text-primary uk-text-small uk-text-uppercase uk-text-bold"><?php e($product->outofstock() == "true", $site->labelStackedbutton()->html(), $product->customButtontext()) ?></a>
          <?php endif ?>
          <?php if($product->productType() == "snipcart"): ?>
            <?php if($product->outofstock() == "true"): ?>
            <a href="<?= $product->url() ?>" class="tm-product-price uk-text-bold uk-text-primary uk-text-small uk-text-uppercase"><?= $site->labelStackedbutton()->html() ?></a>
            <?php elseif($product->productVariations()->isNotEmpty()): ?>
            <a href="<?= $product->url() ?>" class="tm-product-price uk-text-bold uk-text-primary uk-text-small uk-text-uppercase"><?= $site->labelProductoptions()->html() ?></a>
            <?php else: ?>
            <button id="<?php e($product->snipcartProductid()->isNotEmpty(), $product->snipcartProductid(), $product->slug()) ?>" class="uk-button uk-button-text uk-text-primary uk-text-small uk-text-uppercase uk-text-bold snipcart-add-item"
                data-item-id="<?php e($product->snipcartProductid()->isNotEmpty(), $product->snipcartProductid(), $product->slug()) ?>"
                data-item-price="<?php e($product->snipcartDiscountprice()->isNotEmpty(), $product->snipcartDiscountprice(), $product->snipcartPrice()) ?>"
                data-item-url="<?= $product->url() ?>"
                data-item-description="<?= $product->productIntro()->kt()->excerpt(150) ?>"
                <?php if($product->category()->isNotEmpty()): ?>data-item-categories="<?= $product->category() ?>"<?php endif ?>
                <?php if($img = $product->cover()->toImage()): ?>
                    data-item-image="<?= $img->crop(300, 300)->url() ?>"
                <?php endif ?>
                data-item-name="<?= $product->title()->html() ?>"
                data-item-min-quantity="<?= $product->snipcartMinquantity() ?>"
                <?php if($product->snipcartMaxquantity()->isNotEmpty()): ?>data-item-max-quantity="<?= $product->snipcartMaxquantity() ?>"<?php endif ?>
                <?php e($site->snipcartTax() != "true", 'data-item-has-taxes-included="true"') ?>
                <?php e($product->snipcartTaxable() == "true", 'data-item-taxable="false"') ?>
                <?php if($product->shippingToggle() == "true"): ?>
                    data-item-shippable="true" 
                    <?php if($product->productWeight()->isNotEmpty()): ?>data-item-weight="<?= $product->productWeight() ?>" <?php endif ?>
                    <?php if($product->productLength()->isNotEmpty()): ?>data-item-length="<?= $product->productLength() ?>" <?php endif ?>
                    <?php if($product->productHeight()->isNotEmpty()): ?>data-item-height="<?= $product->productHeight() ?>" <?php endif ?>
                    <?php if($product->productWidth()->isNotEmpty()): ?>data-item-width="<?= $product->productWidth() ?>" <?php endif ?>
                <?php else: ?>
                    data-item-shippable="false"
                <?php endif ?>
                <?php if($product->snipcartProductguid()->isNotEmpty()): ?>data-item-file-guid="<?= $product->snipcartProductguid() ?>"<?php endif ?>>
            <?= $site->labelAddtocart() ?></button>
            <?php endif ?>
          <?php endif ?>
          </span>
      </div>
      <?php else: ?>
      <a href="<?= $product->url() ?>" class="tm-product-price uk-text-bold uk-text-primary uk-text-small uk-text-uppercase"><?= $site->labelStackedbutton()->html() ?></a>
      <?php endif ?>
    </div>
  </div>
</div>
<?php endforeach ?>
</section>
<?php endif ?>

<?php snippet('shop/pagination') ?>
</div>
</main>

<?php snippet('footer') ?>