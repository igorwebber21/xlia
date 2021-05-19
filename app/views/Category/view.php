<main id="main" class="main">
    <div class="wrapper">
        <div class="catalog">
            <div class="catalog__top">
                <nav class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <div class="breadcrumbs-i" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a itemprop="item" href="/">
                            <span itemprop="name">Главная</span>
                        </a>
                        <meta itemprop="position" content="1">
                        <span class="breadcrumbs-arrow">
                            <i class="icon-breadcrumbs-arrow"></i>
                        </span>
                    </div>
                    <div class="breadcrumbs-i" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <span itemprop="item">
                            <span itemprop="name"><?=$category['title']?> </span>
                        </span>
                        <meta itemprop="position" content="3">
                    </div>
                </nav>
            </div>
            <div class="catalog__top-row">
                <div class="catalog__top-col catalog__top-col--left">
                    <h1 class="main-h" id="j-catalog-header" data-catalog-view-block="heading"><?=$category['title']?>  </h1>
                </div>

                <?php if($products): ?>
                <div class="catalog__top-col catalog__top-col--right">
                    <div class="catalog__controls" data-catalog-view-block="controls">
                        <div class="catalog__controls-item" data-catalog-view-block="sorting-controls">
                            <div class="catalog-sorting">
                                <div class="catalog-sorting__title j-ajax-ignore">Сортировка:</div>
                                <div class="catalog-sorting__list" id="cae31717b190bc108702c7b1b63931d6">
                                    <span class="catalog-sorting__item is-active j-catalog-sorting-button" role="button">сначала новые</span>
                                    <span class="catalog-sorting__item j-catalog-sorting-button" role="button" data-sort-href="/verkhnyaya-odezhda/filter/sort_price=ASC/">сначала дешевле</span>
                                    <span class="catalog-sorting__item j-catalog-sorting-button" role="button" data-sort-href="/verkhnyaya-odezhda/filter/sort_title=ASC/">сначала дороже</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <div class="catalog__middle j-catalog-sticker-parent">
                <div class="catalog-loader" id="j-catalog-loader"></div>
                <script type="text/javascript">
                  CatalogBuilder.loaderSelector = '#j-catalog-loader';
                </script>


              <?php if($products): ?>
                <div class="catalog__middle-col catalog__middle-col--content catalog__middle-col--shifted-right">
                    <div class="catalog__content">

                        <ul class="catalogGrid catalog-grid catalog-grid--l catalog-grid--sidebar" id="66de0c911c6e3609e57adcb2123bbf81" data-catalog-view-block="products" itemscope itemtype="https://schema.org/ItemList">
                            <?php
                            foreach($products as $product):
                              $productImages = explode(',', $product['base_img']);

                              $firstImage = $productImages[0] ? UPLOAD_PRODUCT_BASE.$productImages[0] : '/images/no_image-2.jpg';
                            ?>
                            <li class="catalog-grid__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <div class="catalogCard j-catalog-card">
                                    <div class="catalogCard-box j-product-container" data-id="5688">
                                        <div class="catalogCard-main">
                                            <div class="catalogCard-main-b">
                                                <div class="catalogCard-view">
                                                    <a href='/product/<?=$product['alias']?>' class="catalogCard-image ">
                                                        <div class="catalogCard-image-i">
                                                            <?php if(isset($productImages[1])): ?>
                                                            <div class="catalogCard-image-bg" style="background-image:url(<?=UPLOAD_PRODUCT_BASE.$productImages[1]?>);"></div>
                                                            <?php endif; ?>
                                                            <img alt='Косуха спорт-шик черная расписная' class='catalogCard-img' width='376' height='501' src='<?=$firstImage?>'>
                                                        </div>
                                                    </a>
                                                    <div class="productSticker __flag2">

                                                        <?php if($product['hit'] == 'yes'): ?>
                                                        <div class="productSticker-item __popular" style="color: #7baf35">
                                                            <div class="productSticker-container">
                                                                <div class="productSticker-content" style="color: #fff">Хит            </div>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>

                                                      <?php if($product['novelty'] == 'yes'): ?>
                                                              <div class="productSticker-item __new" style="color: #3da5ca">
                                                                  <div class="productSticker-container">
                                                                      <div class="productSticker-content" style="color: #fff">Новинка            </div>
                                                                  </div>
                                                              </div>
                                                      <?php endif; ?>

                                                        <?php if($product['old_price']): ?>
                                                        <div class="productSticker-item __discount" style="color: #e93f11;">
                                                            <div class="productSticker-container">
                                                                <div class="productSticker-content" style="color: #fff">−<?=round(($product['old_price'] - $product['price']) / ($product['old_price'] / 100))?>%            </div>
                                                            </div>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="catalogCard-info">
                                                    <div class="catalogCard-title">
                                                        <a href='/product/<?=$product['alias']?>' title="Платье Джесика"><?=$product['title']?></a>
                                                    </div>
                                                    <div class="catalogCard-priceBox">
                                                        <?php if($product['old_price']): ?>
                                                        <div class="catalogCard-oldPrice"><?=$product['old_price']?> грн.</div>
                                                        <?php endif; ?>
                                                        <div class="catalogCard-price"><?=$product['price']?> грн.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <meta itemprop="position" content="1"/>
                                <meta itemprop="url" content="/kosukha-sport-shik-chernaya-raspisnaya/5688/"/>
                            </li>

                            <?php endforeach; ?>
                        </ul>

                        <div class="pagination-container" data-catalog-view-block="pagination">
                            <script type="text/javascript">
                              CatalogBuilder.paginationSelector && CatalogBuilder.paginationSelector.push('#d607602175ef5c32f5eafb01acaca158');
                            </script>
                            <div id="d607602175ef5c32f5eafb01acaca158"></div>
                        </div>
                    </div>
                </div>
                <!-- /.layout-main-->
                <div class="catalog__middle-col catalog__middle-col--left">
                    <aside class="catalog__sidebar j-catalog-sticker-column">
                        <div class="catalog__group catalog__group--sidebar">
                            <div class="filter-container" data-catalog-view-block="group_1.filter">
                                <section class="filter __listScroll" id="660c12a4b0780a1cfe0d5d8a49307b0f" data-scroll-visible="15">
                                    <div class="filter-section __promo">
                                        <ul class="filter-lv1">
                                            <li class="filter-lv1-i">
                                                <a class="filter-check __promo" rel="nofollow" data-fake-href="/verkhnyaya-odezhda/filter/icons=4/">
                                                    <span class="label">
                                                        <i class="checkbox"></i>
                                                        Распродажа<sup class="filter-count">1</sup>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="filter-lv1-i">
                                                <a class="filter-check __popular" rel="nofollow" data-fake-href="/verkhnyaya-odezhda/filter/icons=1/">
                                                    <span class="label">
                                                        <i class="checkbox"></i>
                                                        Хит<sup class="filter-count">2</sup>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="filter-section " data-filter-id="5382">
                                        <div class="filter-section-h">Бренд                                </div>
                                        <div class="filter-list  j-filter-list">
                                            <ul class="filter-lv1">
                                                <li class="filter-lv1-i">
                                                    <a class="filter-check" rel="nofollow" data-fake-href="/verkhnyaya-odezhda/filter/brand=95/">
                                                        <span class="label">
                                                            <i class="checkbox"></i>
                                                            XLiA<sup class="filter-count">13</sup>
                                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="filter-section">
                                        <form action="/verkhnyaya-odezhda/" method="get" class="j-number-form">
                                            <div class="filter-section-h">Цена, грн                    </div>
                                            <div class="filter-price">
                                                <div class="filter-price-inputs">
                                                    <input name="filter[price][min]" type="number" maxlength="6" value="490" class="filter-price-field field" id="b515ef8153d093f5262b1a5c0960c936_min">
                                                    <i class="filter-price-sep"></i>
                                                    <input name="filter[price][max]" type="number" maxlength="6" value="3400" class="filter-price-field field" id="b515ef8153d093f5262b1a5c0960c936_max">
                                                    <button class="btn __small" type="submit">
                                                        <span class="btn-content">OK</span>
                                                    </button>
                                                </div>
                                                <div class="filter-price-tracker" id="b515ef8153d093f5262b1a5c0960c936"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <script type="text/javascript">
                                      init_number_filter("b515ef8153d093f5262b1a5c0960c936", 490, 3400, 490, 3400, false);
                                    </script>
                                </section>
                                <script type="text/javascript">
                                  CatalogBuilder.filterSelector = '#660c12a4b0780a1cfe0d5d8a49307b0f';
                                  CatalogBuilder.attachEventHandler('onFilterLinkClick', function(obj) {
                                    if (obj.is('.filter-check') && !obj.data('loading')) {
                                      obj.data('loading', true);
                                      obj.append('<div class="loader"></div>');
                                    }
                                  });
                                </script>
                            </div>
                        </div>
                    </aside>
                </div>

                <?php else: ?>
                <h2 class="no-products">В категории ещё нет товаров</h2>
                <?php endif; ?>
            </div>
            <!-- /.layout-->
        </div>
    </div>
    <!-- /.wrapper-->
    <div id="291564e61a37fa66473fe0ac60e02211"></div>
    <script type="text/javascript">
      $(function() {
        sendAjax("\/_widget\/seen_items\/default\/", null, function(status, response) {
          var obj = $('#291564e61a37fa66473fe0ac60e02211');
          if (status === 'OK') {
            $(response.html).insertAfter(obj);
          }
          obj.remove();
        });
      });
    </script>
    <script>
      CatalogBuilder.init();
    </script>
</main>