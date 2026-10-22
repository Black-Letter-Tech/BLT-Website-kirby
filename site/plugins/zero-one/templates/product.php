<?php snippet('header') ?>

<main>
    <section class="uk-section uk-section-small">
        <div class="uk-container">
            <div class="uk-grid uk-grid-match" uk-grid>
                <div class="uk-width-1-2@s">
                <?php if($img = $page->cover()->toImage()): ?>
                    <?php if($page->gallery()->isNotEmpty()): ?>
                        <div class="uk-position-relative" uk-slideshow="ratio: <?php e($site->productImageratio()->isNotEmpty(), $site->productImageratio(), '1:1') ?>">
                            <div style="z-index: 0;" uk-scrollspy="cls: uk-animation-slide-bottom-small; delay: 100" uk-sticky="end: true; offset: 15; media: @s;">
                                <ul class="uk-slideshow-items" uk-lightbox>
                                    <li>
                                        <a href="<?= $img->url() ?>" alt="<?= $img->alt() ?>" data-no-swup data-caption="<?= $img->caption() ?>">
                                            <picture>
                                                <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
                                                <img src="<?php e($img->getClip() !== null, $img->resize(null, $coverimg_height)->url(), $img->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $img->alt() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
                                            </picture>
                                        </a>
                                    </li>
                                <?php
                                $images =  $page->gallery()->toImages();
                                foreach($images as $image): ?>
                                    <li>
                                        <a href="<?= $image->url() ?>" alt="<?= $image->alt() ?>" data-no-swup data-caption="<?= $image->caption() ?>">
                                        <picture>
                                            <source type="image/webp" srcset="<?php e($image->getClip() !== null, $image->thumb(['clip' => $image->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $image->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
                                            <img src="<?php e($image->getClip() !== null, $image->resize(null, $coverimg_height)->url(), $image->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $image->alt() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
                                        </picture>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                                </ul>
                                <div class="uk-visible@s uk-margin-small" uk-slider="finite: true">
                                    <div class="uk-position-relative uk-flex uk-flex-center">
                                        <div class="uk-slider-container uk-width-3-4">
                                            <ul class="uk-slider-items uk-child-width-1-4 uk-grid-small">
                                                <li uk-slideshow-item="0" class="<?php e($img->isActive(), 'uk-active') ?>">
                                                    <a href="#" data-no-swup>
                                                        <picture>
                                                            <source type="image/webp" srcset="<?= $img->thumb(['crop' => true, 'width' => 150, 'height' => 150, 'format' => 'webp'])->url() ?>" />
                                                            <img src="<?= $img->crop(150, 150)->url() ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $img->alt() ?> thumbnail" width="150" height="150" loading="lazy">
                                                        </picture>
                                                    </a>
                                                </li>
                                            <?php $number = 0; foreach ($page->gallery()->toImages() as $slide): $number++; ?>
                                                <li uk-slideshow-item="<?= $number ?>" class="<?php e($slide->isActive(), 'uk-active') ?>">
                                                    <a href="#" data-no-swup>
                                                        <picture>
                                                            <source type="image/webp" srcset="<?= $slide->thumb(['crop' => true, 'width' => 150, 'height' => 150, 'format' => 'webp'])->url() ?>" />
                                                            <img src="<?= $slide->crop(150, 150)->url() ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $slide->alt() ?> thumbnail" width="150" height="150" loading="lazy">
                                                        </picture>
                                                    </a>
                                                </li>
                                            <?php endforeach ?>
                                            </ul>
                                            <div class="uk-visible@s">
                                                <a class="uk-position-center-left uk-slidenav-large uk-position-small" href="#" data-no-swup uk-slidenav-previous uk-slider-item="previous"></a>
                                                <a class="uk-position-center-right uk-slidenav-large uk-position-small" href="#" data-no-swup uk-slidenav-next uk-slider-item="next"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-hidden@s">
                                    <a class="uk-position-center-left uk-slidenav-large" href="#" data-no-swup uk-slidenav-previous uk-slideshow-item="previous"></a>
                                    <a class="uk-position-center-right uk-slidenav-large" href="#" data-no-swup uk-slidenav-next uk-slideshow-item="next"></a>
                                </div>
                                <div class="uk-position-small uk-position-top-left uk-flex uk-flex-column uk-flex-wrap-top">
                                    <?php if($page->featured() == "true"): ?>
                                    <span class="uk-label uk-margin-small" style="width: max-content;"><?= $site->labelProductfeatured()->html() ?></span>
                                    <?php endif ?>
                                    <?php if($page->new() == "true"): ?>
                                    <span class="uk-label uk-label-success uk-margin-small" style="width: max-content;"><?= $site->labelProductnew()->html() ?></span>
                                    <?php endif ?>
                                    <?php if($page->outofstock() == "true"): ?>
                                    <span class="uk-label uk-label-warning uk-margin-small" style="width: max-content;"><?= $site->labelProductsold()->html() ?></span>
                                    <?php endif ?>
                                    <?php if($page->productType() == "custom" && $page->customDiscountprice()->isNotEmpty() && $page->customFree() != "true"): ?>
                                    <span class="uk-label uk-label-danger uk-margin-small" style="width: max-content;">-<?= round($custom_discount) ?>%</span>
                                    <?php endif ?>
                                    <?php if($page->productType() == "snipcart" && $page->snipcartDiscountprice()->isNotEmpty()): ?>
                                    <span class="uk-label uk-label-danger uk-margin-small" style="width: max-content;">-<?= round($snipcart_discount) ?>%</span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                    <div>
                        <div style="z-index: 0;" uk-scrollspy="cls: uk-animation-slide-bottom-small; delay: 100" uk-sticky="end: true; offset: 80; media: @s;">
                            <div class="uk-inline">
                                <figure>
                                    <picture>
                                        <source type="image/webp" srcset="<?php e($img->getClip() !== null, $img->thumb(['clip' => $img->getClip(), 'height' => $coverimg_height, 'format' => 'webp'])->url(), $img->thumb(['crop' => true, 'width' => $coverimg_width, 'height' => $coverimg_height, 'format' => 'webp'])->url()) ?>" />
                                        <img src="<?php e($img->getClip() !== null, $img->resize(null, $coverimg_height)->url(), $img->crop($coverimg_width, $coverimg_height)->url()) ?>"<?php e($site->siteBorderRadius() == "true", ' class="uk-border-rounded"') ?> alt="<?= $img->alt() ?>" width="<?= $coverimg_width ?>" height="<?= $coverimg_height ?>" loading="lazy">
                                    </picture>
                                    <?php if ($img->caption()->isNotEmpty()): ?>
                                    <figcaption>
                                    <?php if($img->link()->isNotEmpty()): ?>
                                        <a href="<?= $img->link() ?>"><?= $img->caption() ?></a>
                                    <?php else: ?>
                                        <?= $img->caption() ?>
                                    <?php endif ?>
                                    </figcaption>
                                    <?php endif ?>
                                </figure>
                                <div class="uk-position-small uk-position-top-left uk-flex uk-flex-column uk-flex-wrap-top">
                                    <?php if($page->featured() == "true"): ?>
                                    <span class="uk-label uk-margin-small" style="width: max-content;"><?= $site->labelProductfeatured()->html() ?></span>
                                    <?php endif ?>
                                    <?php if($page->new() == "true"): ?>
                                    <span class="uk-label uk-label-success uk-margin-small" style="width: max-content;"><?= $site->labelProductnew()->html() ?></span>
                                    <?php endif ?>
                                    <?php if($page->outofstock() == "true"): ?>
                                    <span class="uk-label uk-label-warning uk-margin-small" style="width: max-content;"><?= $site->labelProductsold()->html() ?></span>
                                    <?php endif ?>
                                    <?php if($page->productType() == "custom" && $page->customDiscountprice()->isNotEmpty() && $page->customFree() != "true"): ?>
                                    <span class="uk-label uk-label-danger uk-margin-small" style="width: max-content;">-<?= round($custom_discount) ?>%</span>
                                    <?php endif ?>
                                    <?php if($page->productType() == "snipcart" && $page->snipcartDiscountprice()->isNotEmpty()): ?>
                                    <span class="uk-label uk-label-danger uk-margin-small" style="width: max-content;">-<?= round($snipcart_discount) ?>%</span>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif ?>
                <?php endif ?>
                </div>
                <div class="uk-width-1-2@s" uk-scrollspy="cls: uk-animation-slide-bottom-small; target: div; delay: 100">
                    <div>
                    <?php if($site->breadcrumbs() != "false"): ?>
                        <div class="uk-overflow-hidden uk-visible@s">
                        <?php snippet('breadcrumb') ?>
                        </div>
                    <?php endif ?>
                    <h1><?= $page->title()->html() ?></h1>
                    <?php if($page->productShort()->isNotEmpty()): ?>
                    <p class="uk-text-large uk-text-muted"><?= $page->productShort()->html() ?></p>
                    <?php endif ?>
                    <hr class="uk-divider-small">
                    <?php if($page->productType() == "custom" && $page->customPrice()->isNotEmpty() && $page->customFree() != "true"): ?>
                    <p class="uk-text-large uk-text-bold uk-text-emphasis">
                        <?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?php e($page->customDiscountprice()->isNotEmpty(), $page->customDiscountprice()->price(), $page->customPrice()->price()) ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?>
                        <?php if($page->customDiscountprice()->isNotEmpty()): ?><del class="uk-text-muted uk-margin-small-left"><?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?= $page->customPrice()->price() ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?></del><?php endif ?>
                    </p>
                    <?php endif ?>
                    <?php if($page->productType() == "custom" && $page->customFree() == "true"): ?>
                    <p class="uk-text-large uk-text-bold uk-text-emphasis"><?= $site->labelProductfree() ?></p>
                    <?php endif ?>
                    <?php if($page->productType() == "snipcart"): ?>
                        <p class="uk-text-large uk-text-bold uk-text-emphasis">
                        <?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?php e($page->snipcartDiscountprice()->isNotEmpty(), $page->snipcartDiscountprice()->price(), $page->snipcartPrice()->price()) ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?>
                        <?php if($page->snipcartDiscountprice()->isNotEmpty()): ?><del class="uk-text-muted uk-margin-small-left"><?php e($site->currencySymbolposition() == "false", $site->defaultCurrencysymbol() . ' ') ?><?= $page->snipcartPrice()->price() ?><?php e($site->currencySymbolposition() == "true", ' ' . $site->defaultCurrencysymbol()) ?></del><?php endif ?>
                    </p>
                    <?php endif ?>
                    <?= $page->productIntro()->kt() ?>
                    <?php if($page->outofstock() == "true"): ?>
                        <p class="uk-text-bold uk-text-uppercase uk-text-warning"><?= $site->labelProductsold()->html() ?></p>
                    <?php else: ?>
                        <?php if($page->productType() == "custom"): ?>
                            <?php if($page->customLinkexternal()->isNotEmpty() or $page->customLinkinternal()->isNotEmpty()): ?>
                            <div class="uk-margin-top">
                                <?php if($link = $page->customLinkinternal()->toPage()): ?>
                                <a href="<?= $link->url() ?>" class="uk-button uk-button-primary"<?php e($page->customNewtab() == "true", ' target="_blank"') ?>>
                                <?php else: ?>
                                <a href="<?= $page->customLinkexternal()->url() ?>" class="uk-button uk-button-primary"<?php e($page->customNewtab() == "true", ' target="_blank"') ?>>
                                <?php endif ?>
                                    <?= $page->customButtontext() ?>
                                </a>
                            </div>
                            <?php endif ?>
                        <?php endif ?>
                        <?php if($page->productType() == "snipcart"): ?>
                        <?php foreach ($page->productVariations()->toStructure() as $productVariation): ?>
                        <?php if($productVariation->variationType() == "options"): ?>
                        <div class="uk-margin<?php e($productVariation->variationLayout() == "horizontal", ' uk-form-horizontal') ?>">
                            <label class="uk-form-label"><?= $productVariation->variationName() ?></label>
                            <div class="uk-form-control">
                                <select id="<?= $productVariation->variationName()->slug() ?>" class="uk-select uk-form-width-medium">
                                <?php foreach ($productVariation->variationOptions()->toStructure() as $variationOption): ?>
                                    <option><?= $variationOption->optionName() ?><?php e($variationOption->additionalPrice()->isNotEmpty(), ' (+' . $variationOption->additionalPrice()->price() . $site->defaultCurrencysymbol() . ')') ?></option>
                                <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <?php endif ?>
                        <?php endforeach ?>
                        <div class="uk-margin-top">
                        <?php if($page->snipcartMaxquantity() != "1"): ?>
                            <div class="uk-button-group">
                                <input type="button" id="decrement" class="uk-input" value="-">
                                <input class="uk-input" id="quantity" type="number" pattern="[0-9]*"<?php if($page->snipcartMinquantity()->isNotEmpty()): ?> min="<?= $page->snipcartMinquantity() ?>" value="<?= $page->snipcartMinquantity() ?>"<?php else: ?> min="1" value="1"<?php endif ?><?php if($page->snipcartMaxquantity()->isNotEmpty()): ?> max="<?= $page->snipcartMaxquantity() ?>"<?php endif ?>>
                                <input type="button" id="increment" class="uk-input uk-margin-right" value="+">
                            </div>
                        <?php endif ?>
                            <button id="<?php e($page->snipcartProductid()->isNotEmpty(), $page->snipcartProductid(), $page->slug()) ?>" class="uk-button uk-button-primary snipcart-add-item"
                                data-item-id="<?php e($page->snipcartProductid()->isNotEmpty(), $page->snipcartProductid(), $page->slug()) ?>"
                                data-item-price="<?php e($page->snipcartDiscountprice()->isNotEmpty(), $page->snipcartDiscountprice(), $page->snipcartPrice()) ?>"
                                data-item-url="<?= $page->url() ?>"
                                data-item-description="<?= $page->productIntro()->kt()->excerpt(150) ?>"
                                <?php if($page->category()->isNotEmpty()): ?>data-item-categories="<?= $page->category() ?>"<?php endif ?>
                                <?php if($img = $page->cover()->toImage()): ?>
                                    data-item-image="<?= $img->crop(300, 300)->url() ?>"
                                <?php endif ?>
                                data-item-name="<?= $page->title()->html() ?>"
                                data-item-min-quantity="<?= $page->snipcartMinquantity() ?>"
                                <?php if($page->snipcartMaxquantity()->isNotEmpty()): ?>data-item-max-quantity="<?= $page->snipcartMaxquantity() ?>"<?php endif ?>
                                <?php e($site->snipcartTax() != "true", 'data-item-has-taxes-included="true" ') ?>
                                <?php e($page->snipcartTaxable() == "true", 'data-item-taxable="false" ') ?>
                                <?php if($page->shippingToggle() == "true"): ?>
                                    data-item-shippable="true" 
                                    <?php if($page->productWeight()->isNotEmpty()): ?>data-item-weight="<?= $page->productWeight() ?>" <?php endif ?>
                                    <?php if($page->productLength()->isNotEmpty()): ?>data-item-length="<?= $page->productLength() ?>" <?php endif ?>
                                    <?php if($page->productHeight()->isNotEmpty()): ?>data-item-height="<?= $page->productHeight() ?>" <?php endif ?>
                                    <?php if($page->productWidth()->isNotEmpty()): ?>data-item-width="<?= $page->productWidth() ?>" <?php endif ?>
                                <?php else: ?>
                                    data-item-shippable="false"
                                <?php endif ?>
                                <?php $i = 1; foreach ($page->productVariations()->toStructure() as $productVariation): ?>
                                    <?php $c = $i++; ?>
                                    data-item-custom<?= $c ?>-name="<?= $productVariation->variationName() ?>"
                                    <?php if($productVariation->variationType() == "options"): ?>
                                        data-item-custom<?= $c ?>-options="<?php $counter = 0; foreach ($productVariation->variationOptions()->toStructure() as $variationOption): ?><?= $variationOption->optionName() ?><?php e($variationOption->additionalPrice()->isNotEmpty(), ' (+' . $variationOption->additionalPrice()->price() . $site->defaultCurrencysymbol() . ')') ?><?php e($variationOption->additionalPrice()->isNotEmpty(), '[+' . $variationOption->additionalPrice()->priceSnipcart() . ']') ?><?php e($counter !== count( $productVariation->variationOptions()->toStructure() ) - 1, '|') ?><?php $counter = $counter + 1; endforeach ?>"
                                    <?php endif ?>
                                    <?php if($productVariation->variationType() == "checkbox"): ?>
                                        data-item-custom<?= $c ?>-type="checkbox"
                                        <?php if($productVariation->checkboxPrice()->isNotEmpty()): ?>
                                            data-item-custom<?= $c ?>-options="true[<?= $productVariation->checkboxPrice()->priceSnipcart() ?>]|false"
                                        <?php endif ?>
                                    <?php endif ?>
                                    <?php if($productVariation->variationType() == "textarea"): ?>
                                        data-item-custom<?= $c ?>-type="textarea"
                                    <?php endif ?>
                                    <?php if($productVariation->variationType() == "readonly"): ?>
                                        data-item-custom<?= $c ?>-type="readonly"
                                        data-item-custom<?= $c ?>-value="<?= $productVariation->variationReadonly()->html() ?>"
                                    <?php endif ?>
                                <?php endforeach ?>
                                <?php if($page->snipcartProductguid()->isNotEmpty()): ?>data-item-file-guid="<?= $page->snipcartProductguid() ?>"<?php endif ?>>
                                <?= $site->labelAddtocart() ?></button>
                            <?php if($page->snipcartMaxquantity() != "1"): ?>
                            <script>
                            // Product ID
                            const button = document.querySelector('#<?php e($page->snipcartProductid()->isNotEmpty(), $page->snipcartProductid(), $page->slug()) ?>')
                            // Quantity selector
                            const quantity = document.querySelector('#quantity')
                            // Increment/decrement buttons selectors
                            const incrementButton = document.querySelector('#increment')
                            const decrementButton = document.querySelector('#decrement')
                            // Increment button
                            incrementButton.addEventListener('click', () => {
                                <?php if($page->snipcartMaxquantity()->isNotEmpty()): ?>if (quantity.value < <?= $page->snipcartMaxquantity() ?>) {<?php endif ?>
                                const newQuantity = (parseInt(quantity.value) || 0) + 1
                                quantity.value = newQuantity
                                    button.setAttribute('data-item-quantity', newQuantity)
                                <?php e($page->snipcartMaxquantity()->isNotEmpty(), '}') ?>
                            })
                            // Decrement button
                            decrementButton.addEventListener('click', () => {
                                if (quantity.value > <?= $page->snipcartMinquantity() ?>) {
                                const newQuantity = (parseInt(quantity.value) || 0) - 1
                                quantity.value = newQuantity
                                    button.setAttribute('data-item-quantity', newQuantity)
                                }
                            })
                            // On change
                            quantity.addEventListener('change', () => {
                            // Sets the default quantity when adding the item
                            button.setAttribute('data-item-quantity', quantity.value)
                            })
                            <?php $i = 1; foreach ($page->productVariations()->toStructure() as $productVariation): ?>
                                <?php if($productVariation->variationType() == "options"): ?>
                                <?php $c = $i++; ?>
                                const select<?= $c ?> = document.querySelector('#<?= $productVariation->variationName()->slug() ?>')
                                select<?= $c ?>.addEventListener('change', () => {
                                // Sets the default frame color when adding the item
                                button.setAttribute("data-item-custom<?= $c ?>-value", select<?= $c ?>.value)
                                })
                                <?php endif ?>
                            <?php endforeach ?>
                            // Clear forms here
                            function resetQuantity() {
                                document.getElementById("quantity").value = "<?php e($page->snipcartMinquantity()->isNotEmpty(), $page->snipcartMinquantity(), '1') ?>";
                            }
                            window.onload = resetQuantity;
                            </script>
                            <?php endif ?>
                        </div>
                        <?php endif ?>
                    <?php endif ?>
                    </div>
                    <hr>
                    <div class="uk-text-small">
                        <?php if($page->productType() == "snipcart"): ?>
                        <p><b><?= $site->labelProductid() ?></b> <?php e($page->snipcartProductid()->isNotEmpty(), $page->snipcartProductid(), $page->slug()) ?></p>
                        <?php endif ?>
                        <?php if($page->category()->isNotEmpty()): ?>
                        <p><b><?= $site->labelProductcategory() ?></b> 
                         <a href="<?= url($lang . '/' . $page->parent()->slug(), ['params' => ['category' => urlencode($page->category())]]) ?>"><?= Str::ucfirst($page->category()->tags()) ?></a>
                        </p>
                        <?php endif ?>
                        <?php if($page->tags()->isNotEmpty()): ?>
                        <p><b><?= $site->labelProducttag() ?></b> 
                        <?php foreach($page->tags()->split(',') as $tag): ?>
                        <span class="tm-project-tags"><a href="<?= url($lang . '/' . $page->parent()->slug(), ['params' => ['tag' => urlencode($tag)]]) ?>"><?= Str::ucfirst($tag) ?></a></span>
                        <?php endforeach ?>
                        </p>
                        <?php endif ?>
                        <p>
                            <b class="uk-margin-small-right"><?= $site->labelProductshare() ?></b>
                            <a class="uk-icon-link uk-margin-small-right" href="https://www.facebook.com/sharer/sharer.php?u=<?= rawurlencode ($page->url()) ?>" data-no-swup target="_blank" uk-icon="icon: facebook; ratio: 0.9"></a>
                            <a class="uk-icon-link uk-margin-small-right" href="https://twitter.com/intent/tweet?source=webclient&text=<?= rawurlencode($page->title()) ?>%20<?= rawurlencode ($page->url()) ?>%20<?= ('via') ?> <?= $site->twitteruser() ?>" data-no-swup target="_blank" uk-icon="icon: twitter; ratio: 0.9"></a>
                            <a class="uk-icon-link uk-margin-small-right" href="https://www.linkedin.com/shareArticle?mini=true&url=<?= rawurlencode ($page->url()) ?>&title=<?= rawurlencode($page->title()) ?>" data-no-swup target="_blank" uk-icon="icon: linkedin; ratio: 0.9"></a>
                            <a class="uk-icon-link uk-margin-small-right" href="https://pinterest.com/pin/create/button/?url=<?= rawurlencode ($page->url()) ?>&description=<?= rawurlencode($page->title()) ?>" data-no-swup target="_blank" uk-icon="icon: pinterest; ratio: 0.9"></a>
                            <a class="uk-icon-link" href="mailto:?subject=<?= $site->title() ?> - <?= $page->title() ?>&body=<?= rawurlencode ($page->url()) ?>" target="_blank" data-no-swup uk-icon="icon: mail; ratio: 0.9"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div uk-scrollspy="cls: uk-animation-slide-bottom-small; delay: 100">
    <ul class="uk-flex-center" uk-tab="animation: uk-animation-fade">
        <li><a href="#" data-no-swup><?= $site->labelProductdescription() ?></a></li>
        <?php if($page->shippingToggle() == "true" or $page->additionalInformation()->isNotEmpty()): ?>
        <li><a href="#" data-no-swup><?= $site->labelAdditionalinformation() ?></a></li>
        <?php endif ?>
        <?php foreach ($page->customTabs()->toStructure() as $customTabs): ?>
        <li><a href="#" data-no-swup><?= $customTabs->tabName() ?></a></li>
        <?php endforeach ?>
        <?php foreach ($page->parent()->customTabs()->toStructure() as $customTabs): ?>
        <li><a href="#" data-no-swup><?= $customTabs->tabName() ?></a></li>
        <?php endforeach ?>
    </ul>
    <ul class="uk-switcher uk-margin">
        <li>
            <?php if($page->selectBuilder() == "layout-builder"): ?>
            <div>
            <?php foreach ($page->layout()->toLayouts() as $layout): ?>
            <?php snippet('layout/layout', ['layout' => $layout]) ?>
            <?php endforeach ?>
            </div>
            <?php else: ?>
            <div class="uk-container uk-container-xsmall">
                <div>
                <?= $page->productDescription()->toBlocks() ?>
                </div>
            </div>
            <?php endif ?>
        </li>
        <?php if($page->shippingToggle() == "true" or $page->additionalInformation()->isNotEmpty()): ?>
        <li>
            <div class="uk-container uk-container-xsmall">
            <table class="uk-table uk-table-divider uk-table-hover">
                <tbody>
                <?php if($page->productWeight()->isNotEmpty()): ?>
                    <tr>
                        <td><?= $site->labelProductweight() ?></td>
                        <td class="uk-text-right"><?= $page->productWeight() ?> gr.</td>
                    </tr>
                <?php endif ?>
                <?php if($page->productLength()->isNotEmpty()): ?>
                    <tr>
                        <td><?= $site->labelProductlength() ?></td>
                        <td class="uk-text-right"><?= $page->productLength() ?> cm</td>
                    </tr>
                <?php endif ?>
                <?php if($page->productHeight()->isNotEmpty()): ?>
                    <tr>
                        <td><?= $site->labelProductheight() ?></td>
                        <td class="uk-text-right"><?= $page->productHeight() ?> cm</td>
                    </tr>
                <?php endif ?>
                <?php if($page->productWidth()->isNotEmpty()): ?>
                    <tr>
                        <td><?= $site->labelProductwidth() ?></td>
                        <td class="uk-text-right"><?= $page->productWidth() ?> cm</td>
                    </tr>
                <?php endif ?>
                <?php foreach ($page->additionalInformation()->toStructure() as $additional): ?>
                    <tr>
                        <td><?= $additional->attribute() ?></td>
                        <td class="uk-text-right"><?= $additional->value() ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            </div>
        </li>
        <?php endif ?>
        <?php foreach ($page->customTabs()->toStructure() as $customTabs): ?>
        <li>
            <div class="uk-container uk-container-xsmall">
            <?= $customTabs->tabContent()->toBlocks() ?>
            </div>
        </li>
        <?php endforeach ?>
        <?php foreach ($page->parent()->customTabs()->toStructure() as $customTabs): ?>
        <li>
            <div class="uk-container uk-container-xsmall">
            <?= $customTabs->tabContent()->toBlocks() ?>
            </div>
        </li>
        <?php endforeach ?>
    </ul>
    </div>

    <hr>
    <div class="uk-margin uk-padding uk-text-center uk-flex uk-flex-center" uk-scrollspy="cls: uk-animation-slide-bottom-small">
    <?php snippet('article/share') ?>
    </div>

    <hr>
    <div class="uk-container uk-container-small" uk-scrollspy="cls: uk-animation-slide-bottom-small">
    <?php snippet('product/prevnext') ?>
    </div>

    <?php snippet('product/related') ?>
</main>

<?php snippet('footer') ?>