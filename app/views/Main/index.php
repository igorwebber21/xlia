<main id="main" class="main">
    <div class="banners-group">
        <section class="banners banners--wideblock banners--gaps-none">
            <div class="banners__container">
                <div class="banners__slider">
                    <div class="banners__slider-wrapper">
                        <div class="banners__slider-i is-visible">
                            <div class="banners__item banners__item--radius-none banners__item--size-m">
                                <div class="banner">
                                    <div class="banner-image">
                                        <img class="banner-img" src="/images/33530958417201_+f62671b8a0.jpg" alt="" title=""/>
                                    </div>
                                    <div class="banner-border" style="border-color: rgba(0, 0, 0, 0.98);"></div>
                                    <a class="banner-a" href="?view=category"></a>
                                </div>
                            </div>
                        </div>
                        <div class="banners__slider-i">
                            <div class="banners__item banners__item--radius-none banners__item--size-m">
                                <div class="banner">
                                    <div class="banner-image">
                                        <img class="banner-img" src="/images/banner.png" alt="" title=""/>
                                    </div>
                                    <div class="banner-border" style="border-color: rgba(0, 0, 0, 0.98);"></div>
                                    <a class="banner-a" href="?view=category"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php if($hits): ?>
    <section class="promo" id="special_offers_homepage-showcase-modern">
        <div class="layout-wrap">
            <div class="promo-container">
                <div class="catalogTabs">
                    <nav class="catalogTabs-nav">
                        <ul class="catalogTabs-nav-box">
                            <li class="catalogTabs-nav-i __active" rel="hits">
                                <span class="catalogTabs-nav-a">Хиты продаж</span>
                            </li>
                        </ul>
                    </nav>
                    <div class="catalogTabs-content j-special-offers-content" style="display: block;">
                        <section class="promo-section">
                            <div class="slideCarousel-screen">
                                <div class="catalog-carousel">
                                    <div class="catalog-carousel__container promo-slider">
                                        <ul class="catalog-carousel__wrap promo-slider-list" data-parent-class="catalog-grid">

                                          <?php foreach ($hits as $hit):

                                          $hitImages = explode(',', $hit['base_img']);
                                          ?>
                                            <li class="catalog-carousel__item promo-slider-i">
                                                <div class="catalogCard j-catalog-card">
                                                    <div class="catalogCard-box j-product-container" data-id="5775">
                                                        <div class="catalogCard-main">
                                                            <div class="catalogCard-main-b">
                                                                <div class="catalogCard-view">
                                                                    <a href='/product/<?=$hit['alias']?>' class="catalogCard-image ">
                                                                        <div class="catalogCard-image-i">
                                                                            <div class="catalogCard-image-bg" style="background-image:url(<?=UPLOAD_PRODUCT_BASE.$hitImages[1]?>);"></div>
                                                                            <img alt='Топ-корсет серый' class='catalogCard-img' width='376' height='574' src='<?=UPLOAD_PRODUCT_BASE.$hitImages[0]?>'>
                                                                        </div>
                                                                    </a>
                                                                    <div class="productSticker __flag2">
                                                                        <div class="productSticker-item __popular" data-tooltip="hint-3d6d4454b0ae2552396b08c1876a67c1" style="color: #7baf35">
                                                                            <div class="productSticker-container">
                                                                                <div class="productSticker-content" style="color: #fff">Хит</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="catalogCard-info">
                                                                    <div class="catalogCard-title">
                                                                        <a href='/product/<?=$hit['alias']?>' title="Топ-корсет серый"><?=$hit['title']?></a>
                                                                    </div>
                                                                    <div class="catalogCard-priceBox">
                                                                        <div class="catalogCard-price"><?=$hit['price']?> грн    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <a class="slideCarousel-nav-btn __slideLeft" href="#" style="display: none;"></a>
                                    <a class="slideCarousel-nav-btn __slideRight" href="#" style="display: none;"></a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section class="frontInfo">
        <div class="frontInfo-section __1">
            <div class="layout-wrap">
                <div class="frontInfo-container __1 ">
                    <div class="frontInfo-col">
                        <section class="frontInfo-about">
                            <article class="frontInfo-content">
                                <h1 class="h2 text-center">XLiA - модная среда обитания</h1>
                                <div class="frontInfo-text __clip j-seo-text-expander" data-toggle-text='{"show":"Развернуть", "hide":"Свернуть"}'>
                                    <div class="text">

                                        <h3>
                                            XLiA – бренд, основанный в 2014 году. Создан для того, чтобы быть комфортным и доступным каждому.
                                        </h3>

                                        <p>
                                            XLiA, как никто, знает, что успешный день создают приятные мелочи.
                                        </p>

                                        <p>
                                            Мы представляем яркие образы из платьев, рубашек, блуз, брюк, комбинезонов, футболок, боди, топов, юбок, которые сделают Ваш образ неотразимым.
                                        </p>

                                        <p>
                                            Таких вещей множество, они делают нас добрее, веселее, немного романтичней и даже увереннее в себе. Именно такое отношение к жизни и формирует наши ценности.
                                        </p>


                                        <h4>А Вы знали, что секрет успешных людей во многом кроется в их гардеробе?</h4>

                                        <p>
                                            Мы создали одежду на любой вкус и для любого события.

                                            Мы изо дня в день работаем над тем, чтоб покупатели получали удовольствие от шоппинга в нашем магазине. Мы предлагаем лучшее качество вещей, приемлемую цену и индивидуальный подход к каждому клиенту.

                                            XLiA сегментируется на несколько разных линий, в которой каждый сможет найти вещи своей мечты.

                                            Мы знаем, что счастье состоит из множества мелочей, которые важно не упустить. Шоппинг — не исключение. Поэтому наши консультанты сделают его максимально комфортным, помогут выбрать подходящий размер с учетом ваших вкусовых предпочтений и параметров, сориентируют по максимально приемлемой и комфортной стоимости.
                                        </p>


                                        <h4>Почему XLiA?</h4>

                                        <ul>
                                            <li>
                                                ⭐ качественные ткани – шелк, хлопок, лён, футер, джинс, гипоаллергенные ткани;
                                            </li>
                                            <li> ⭐ правильный крой - раскройщики точно соблюдают технологии, поэтому после стирок силуэт изделия останется правильной формы;
                                            </li>
                                            <li>
                                                ⭐ модный фасон - выбирая сайты брендовых вещей, можно сразу выделить наш ресурс благодаря стильным изделиям;
                                            </li>
                                            <li>
                                                ⭐ широкий ассортимент - наш магазин с брендовой одеждой предлагает актуальные новинки для прекрасной половины человечества;
                                            </li>
                                            <li>
                                                ⭐ доступная размерная сетка - учитывая индивидуальные особенности каждой фигуры, мы выпускаем изделия разных размеров от XXS до XXL, с учетом фасона;
                                            </li>
                                            <li>
                                                ⭐ стильные расцветки, принты – мы учитываем модные направления каждого сезона, в соответствии с ними производятся изделия разных цветов.
                                            </li>
                                        </ul>


                                        <p>
                                            Для нас одежда - это не просто вещи. Это и есть те составляющие, из которых состоит счастье. Поэтому смело говорим XLiA - это модная среда обитания
                                        </p>


                                    </div>
                                </div>
                            </article>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php if($novelty): ?>
    <section class="promo" id="special_offers_homepage-showcase-modern">
        <div class="layout-wrap">
            <div class="promo-container">
                <div class="catalogTabs">
                    <nav class="catalogTabs-nav">
                        <ul class="catalogTabs-nav-box">
                            <li class="catalogTabs-nav-i __active" rel="novelties">
                                <span class="catalogTabs-nav-a">Новинки</span>
                            </li>
                        </ul>
                    </nav>

                    <div class="catalogTabs-content j-special-offers-content" style="display: block;">
                        <section class="promo-section">
                            <div class="slideCarousel-screen">
                                <div class="catalog-carousel">
                                    <div class="catalog-carousel__container promo-slider">
                                        <ul class="catalog-carousel__wrap promo-slider-list" data-parent-class="catalog-grid">

                                            <?php foreach ($novelty as $noveltyItem):

                                              $noveltyItemImages = explode(',', $noveltyItem['base_img']);
                                              ?>
                                            <li class="catalog-carousel__item promo-slider-i">
                                                <div class="catalogCard j-catalog-card">
                                                    <div class="catalogCard-box j-product-container" data-id="5716">
                                                        <div class="catalogCard-main">
                                                            <div class="catalogCard-main-b">
                                                                <div class="catalogCard-view">
                                                                    <a href='/product/<?=$noveltyItem['alias']?>' class="catalogCard-image ">
                                                                        <div class="catalogCard-image-i">
                                                                            <div class="catalogCard-image-bg" style="background-image:url(<?=UPLOAD_PRODUCT_BASE.$noveltyItemImages[1]?>);"></div>
                                                                            <img alt='Черное платье миди с вырезами' class='catalogCard-img' width='376' height='564' src='<?=UPLOAD_PRODUCT_BASE.$noveltyItemImages[0]?>'>
                                                                        </div>
                                                                    </a>
                                                                    <div class="productSticker __flag2">
                                                                        <div class="productSticker-item __new" data-tooltip="hint-e9121c9cd997297d125e171a35ab3438" style="color: #3da5ca">
                                                                            <div class="productSticker-container">
                                                                                <div class="productSticker-content" style="color: #fff">Новинка            </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="catalogCard-info">
                                                                    <div class="catalogCard-title">
                                                                        <a href='/product/<?=$noveltyItem['alias']?>' title="Черное платье миди с вырезами"><?=$noveltyItem['title']?></a>
                                                                    </div>
                                                                    <div class="catalogCard-priceBox">
                                                                        <div class="catalogCard-price"><?=$noveltyItem['price']?> грн    </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div>
                                    <a class="slideCarousel-nav-btn __slideLeft" href="#" style="display: none;"></a>
                                    <a class="slideCarousel-nav-btn __slideRight" href="#" style="display: none;"></a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</main>