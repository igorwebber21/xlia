<main id="main" class="main">
    <div class="wrapper">
        <div class="layout">
            <section class="product" itemscope="">
                <div class="product__top">
                    <div class="product__column-item" data-view-block="header">
                        <div class="product__section product__section--header">
                            <nav class="breadcrumbs" itemscope >
                                <div class="breadcrumbs-i" itemprop="itemListElement">
                                    <a itemprop="item" href="/">
                                        <span itemprop="name">Главная</span>
                                    </a>
                                    <meta itemprop="position" content="1">
                                    <span class="breadcrumbs-arrow">
                                        <i class="icon-breadcrumbs-arrow"></i>
                                    </span>
                                </div>
                                <div class="breadcrumbs-i" itemprop="itemListElement" itemscope>
                                    <a itemprop="item" href="?view=category">
                                        <span itemprop="name">Каталог</span>
                                    </a>
                                    <meta itemprop="position" content="2">
                                    <span class="breadcrumbs-arrow">
                                        <i class="icon-breadcrumbs-arrow"></i>
                                    </span>
                                </div>
                                <div class="breadcrumbs-i" itemprop="itemListElement" itemscope>
                                    <a itemprop="item" href="/category/<?=$category['alias']?>">
                                        <span itemprop="name"><?=$category['title']?></span>
                                    </a>
                                    <meta itemprop="position" content="3">
                                    <span class="breadcrumbs-arrow">
                                        <i class="icon-breadcrumbs-arrow"></i>
                                    </span>
                                </div>
                                <div class="breadcrumbs-i" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                    <span itemprop="item">
                                        <span itemprop="name"><?=$product['title'];?></span>
                                    </span>
                                    <meta itemprop="position" content="4">
                                </div>
                            </nav>
                            <meta itemprop="category" content="Мастерки и худи">
                            <meta itemprop="sku" content="642BeigeUNI"/>
                            <meta itemprop="mpn" content="no-content"/>
                            <div itemprop="brand" itemtype="https://schema.org/Thing" itemscope>
                                <meta itemprop="name" content="Lior"/>
                            </div>
                            <div class="product-header">
                                <div class="product-header__row product-header__row--top">
                                    <div class="product-header__block product-header__block--wide">
                                        <h1 class="product-title" itemprop="name"><?=$product['title']?></h1>
                                    </div>
                                    <div class="product-header__block">
                                        <div class="product-header__code product-header__code--filled">
                                            <span class="product-header__code-title">Артикул</span>
                                            <?=$product['vendor_code']?>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-header__row">
                                    <div class="product-header__availability">В наличии</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="product__grid">
                    <div class="product__column product__column--left product__column--sticky">
                        <div class="product__column-container j-product-left-column">
                            <div class="product__column-item" data-view-block="group_4">
                                <div class="product__group product__group--tabs">
                                    <div class="product__group-item">
                                        <div data-view-block="group_4.gallery">
                                            <div class="product__section product__section--gallery">
                                                <section class="gallery">
                                                    <div class="gallery__photos">
                                                        <div class="gallery__photos-container">
                                                            <ul class="gallery__photos-list">
                                                                <?php foreach ($gallery as $item): ?>
                                                                <li class="gallery__item ">
                                                                    <span class="gallery__link  j-gallery-link" data-href="<?=UPLOAD_PRODUCT_GALLERY.$item['img']?>" onclick="TMGallery.getInstance() && TMGallery.getInstance().loadContentToModal(0); return false;">
                                                                        <img alt='<?=$product['title']?>' class='gallery__photo-img' width='670' height='717' src='<?=UPLOAD_PRODUCT_GALLERY.$item['img']?>' itemprop="image">
                                                                    </span>
                                                                </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
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
                                                            <div class="productSticker-item __discount" style="color: #e93f11">
                                                                <div class="productSticker-container">
                                                                    <div class="productSticker-content" style="color: #fff">- <?=round(($product['old_price'] - $product['price']) / ($product['old_price'] / 100))?>%</div>
                                                                </div>
                                                            </div>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                    <div class="gallery__thumbnails">
                                                        <div class="gallery__thumbnails-container">
                                                            <ul class="gallery__thumbnails-list">
                                                                <?php $counter = 0; foreach ($gallery as $thumb): ?>
                                                                <li class="gallery__thumb <?php if($counter==0) echo 'is-active'; ?>">
                                                                    <a class="gallery__thumb-link j-gallery-thumb" data-href="<?=UPLOAD_PRODUCT_THUMBS.$thumb['img']?>" data-index="<?=$counter?>">
                                                                        <img alt='<?=$product['title']?>' class='gallery__thumb-img' width='73' height='78' src='<?=UPLOAD_PRODUCT_THUMBS.$thumb['img']?>'>
                                                                    </a>
                                                                </li>
                                                                <?php $counter++; endforeach; ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </section>
                                                <script type="text/javascript">
                                                  (function($) {
                                                      $(function() {

                                                        var $spiner = $("#gallery-360-container");
                                                        var photoSwiper = new Swiper('.gallery__photos-container',{
                                                          wrapperClass: 'gallery__photos-list',
                                                          slideClass: 'gallery__item',
                                                          slideActiveClass: 'is-active',
                                                          effect: 'fade',
                                                          onInit: function(s) {
                                                            $(s.slides[s.activeIndex]).find('.j-gallery-zoom').easyZoom({
                                                              wrapper: '.gallery__item',
                                                              onShow: function() {
                                                                $('.j-product-logo, .productSticker').fadeOut(150);
                                                              },
                                                              onHide: function() {
                                                                $('.j-product-logo, .productSticker').fadeIn(250);
                                                              }
                                                            });
                                                            $(s.slides[s.activeIndex]).imagesLoaded();
                                                          },
                                                          onSlideChangeStart: function(s) {
                                                            $('.gallery__thumb').removeClass('is-active').eq(s.activeIndex).addClass('is-active');

                                                            if ($(s.slides[s.activeIndex]).hasClass('is-video')) {
                                                              $('.productSticker').fadeOut(150);
                                                            } else {
                                                              $('.productSticker').fadeIn(150);
                                                            }
                                                          },
                                                          onSlideChangeEnd: function(s) {
                                                            if ($spiner.length && $spiner.spritespin('animate')) {
                                                              $spiner.spritespin('animate', false);
                                                              $spiner.spritespin('update', 0);
                                                            }
                                                            $(s.slides[s.activeIndex]).find('.j-gallery-zoom').easyZoom({
                                                              wrapper: '.gallery__item',
                                                              onShow: function() {
                                                                $('.j-product-logo, .productSticker').fadeOut(150);
                                                              },
                                                              onHide: function() {
                                                                $('.j-product-logo, .productSticker').fadeIn(250);
                                                              }
                                                            });
                                                            $(s.slides[s.activeIndex]).imagesLoaded();
                                                          }
                                                        });

                                                        $('.j-gallery-thumb').on('click', function(e) {
                                                          photoSwiper.slideTo($(this).data('index'));
                                                          e.preventDefault();
                                                        });

                                                      });


                                                      // initGallery
                                                      var galleryImages = JSON.parse('<?=json_encode($gallery);?>');
                                                      var galleryContent = [];
                                                      var imageMainSrc = '<?=UPLOAD_PRODUCT_GALLERY;?>';
                                                      var imageThumbsSrc = '<?=UPLOAD_PRODUCT_THUMBS;?>';

                                                      $.each(galleryImages,function(index,value){
                                                        galleryContent.push({
                                                          "src": imageMainSrc + value['img'],
                                                          "thumb": imageThumbsSrc + value['img'],
                                                          "html": null,
                                                          "video": false
                                                        });
                                                      });

                                                      var initGallery = function() {
                                                        TMGallery.init({
                                                          "content": galleryContent,
                                                          "title": "<?=$product['title']?>",
                                                          "zoom": true
                                                        }, {
                                                          afterInit: function() {
                                                            var rating = $("<div class=\"tmGallery-rating\" id=\"eda7971a88308a51587bd896890f3aa1\">\n    <\/div>\n    <script type=\"text\/javascript\">\n        $(function () {\n            if (AjaxComments.getInstance()) {\n                var object = $(\"#eda7971a88308a51587bd896890f3aa1\");\n                AjaxComments.getInstance().attachEventHandlers({\n                    afterSubmit: function (status) {\n                        if (status === 'OK') {\n                            sendAjax(\"\\\/_widget\\\/product_rating\\\/render\\\/gallery\\\/5245\\\/\", function (status, response) {\n                                if (status === 'OK') {\n                                    object.html($(response.html).html());\n                                }\n                            });\n                        }\n                    }\n                });\n            }\n        });\n    <\/script>");
                                                            rating.appendTo(this.top.find('.tmGallery-header'));
                                                          }
                                                        });
                                                      };
                                                      var images = $('.j-gallery-link');

                                                      if (images.length > 1) {
                                                        initGallery();
                                                      } else {
                                                        var bigImgPath = images.attr('href') || images.data('href'), smallImg = images.find('img'), smallImgPath = smallImg.attr('src'), big, small;

                                                        var loading = 2;

                                                        var checkLoading = function() {
                                                          if (--loading == 0) {
                                                            var divergence = 0.2;
                                                            var bigWidth = big.width - big.width * divergence
                                                              , bigHeight = big.height - big.height * divergence
                                                              , smallImgStyle = getComputedStyle(smallImg[0]);

                                                            if (bigWidth <= parseFloat(smallImgStyle.width) || bigHeight <= parseFloat(smallImgStyle.height)) {
                                                              images.attr('onclick', '');
                                                            } else {
                                                              initGallery();
                                                            }
                                                          }
                                                        };

                                                        big = new Image();
                                                        big.onload = checkLoading;
                                                        big.onerror = checkLoading;
                                                        big.src = bigImgPath;

                                                        small = new Image();
                                                        small.onload = checkLoading;
                                                        small.onerror = checkLoading;
                                                        small.src = smallImgPath;
                                                      }
                                                    }
                                                  )(jQuery);
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product__column-item" data-view-block="group_3">
                                <div class="product__group product__group--tabs">
                                    <div class="product__group-item">
                                        <div class="product-heading product-heading--first">
                                            <div class="product-heading__title">Описание</div>
                                        </div>
                                        <div>
                                            <div class="product__section">
                                                <div class="product-description j-product-description " itemprop="description">
                                                    <div class="text"><?=$product['content'];?>      </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product__column product__column--right product__column--sticky">
                        <div class="product__column-container j-product-right-column">
                            <div class="product__column-item" data-view-block="group_1">
                                <div class="product__group ">
                                    <div class="product__group-item">
                                        <div data-view-block="group_1.price">
                                            <div class="product__section product__section--price">
                                                <div class="product__row">
                                                    <div class="product__block product__block--wide">
                                                        <div class="product-price">
                                                            <div class="product-price__box" itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
                                                                <div class="product-price__item product-price__item--new">
                                                                    <meta itemprop="price" content="1040">
                                                                    <meta itemprop="priceCurrency" content="UAH"><?=$product['price']?> грн.
                                                                </div>
                                                                <?php if($product['old_price']): ?>
                                                                <div class="product-price__old-price"><?=$product['old_price']?> грн. </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product__block"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="product__group-item">
                                        <div data-view-block="group_1.modifications">
                                            <section class="product__section product__section--modifications">
                                                <div class="product__modifications">
                                                    <form method="post" action="/catalog/load-modification/5245/" id="1327286ec55ad891556f8459cfad5ec5" autocomplete="off">
                                                        <div class="modification">
                                                            <div class="modification__head">
                                                                <div class="modification__title">Размер                                                </div>
                                                            </div>
                                                            <div class="modification__body">
                                                                <div class="modification__list">
                                                                    <a href="javascript:void(0);" data-value="15" class="modification__button btn">XS</a>
                                                                    <a href="javascript:void(0);" data-value="15" class="modification__button btn">S</a>
                                                                    <a href="javascript:void(0);" data-value="15" class="modification__button btn">M</a>
                                                                    <a href="javascript:void(0);" data-value="15" class="modification__button btn">L</a>
                                                                </div>
                                                                <input type="hidden" id="j-mod-prop-volume" data-prop="volume" name="param[volume]" value="15">
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <script type="text/javascript">
                                                      ModificationChange.setSelector("#1327286ec55ad891556f8459cfad5ec5");
                                                      ModificationChange.getInstance();
                                                    </script>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                    <div class="product__group-item">
                                        <div data-view-block="group_1.order">
                                            <div class="product__section product__section--order">
                                                <div class="product-order">
                                                    <div class="product-order__row">
                                                        <div class="product-order__block">
                                                            <div class="counter counter--large j-product-card-quantity-5245">
                                                                <div class="counter__container">
                                                                    <button class="counter-btn __minus j-product-decrease __disabled">
                                                                        <span class="icon-minus"></span>
                                                                    </button>
                                                                    <div class="counter-input">
                                                                        <input class="counter-field j-product-counter" type="text" value="1" data-max="999999" data-step="1" data-min="1">
                                                                    </div>
                                                                    <button class="counter-btn __plus j-product-increase">
                                                                        <span class="icon-plus"></span>
                                                                    </button>
                                                                </div>
                                                                <div class="counter__units"></div>
                                                            </div>

                                                        </div>
                                                        <div class="product-order__block product-order__block--buy">
                                                            <span class="btn __special add-to-cart" id="prod-<?=$product['id']?>">
                                                                <span class="btn-content">Купить</span>
                                                            </span>
                                                        </div>
                                                        <div class="product-order__block product-order__block--buy product-order__block--tryon">
                                                            <a class="btn __special green-btn" data-quantity="1" id="productTryOn"  href="javascript:void(0);"
                                                               onclick="productTryOn()">
                                                                <span class="btn-content">Примерить</span>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product__column-item" data-view-block="group_4">
                                <div class="product__group product__group--tabs">
                                    <div class="product-heading product-heading--first">
                                        <nav class="product-heading__nav" id="60813fe0872a1">
                                            <a class="product-heading__tab" href="#dostavka-4">
                                                <div class="product-heading__title">Доставка</div>
                                            </a>
                                            <a class="product-heading__tab" href="#oplata-4">
                                                <div class="product-heading__title">Оплата</div>
                                            </a>
                                            <a class="product-heading__tab" href="#garantija-4">
                                                <div class="product-heading__title">Обмен и возврат</div>
                                            </a>
                                        </nav>
                                    </div>
                                    <div id="dostavka-4">
                                        <div class="product__section">
                                            <div class="text mt-35">
                                                <p>
                                                    Доставка заказов осуществляется Транспортной Компанией <strong>«Новая Почта»</strong> или <strong>«Укр Почта»</strong>. Срок доставки 2-3 дня с момента подтверждения заказа при наличии товара на складе. При заказе товара от 5 единиц доставка осуществляется бесплатно.
                                                </p>
                                                <p>Подробнее читайте <a href="/oplata-i-dostavka" class="a-pseudo-active">тут</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="oplata-4">
                                        <div class="product__section">
                                            <div class="text mt-35">
                                                <p>
                                                    <strong>Безналичный расчет</strong><br/>
                                                    Оплата производится в гривне на карту Приват Банка через приложение Приват24 или терминал с учетом комиссии Вашего Банка.
                                                </p>
                                                <p>
                                                    <strong>Наложенный платеж</strong><br/>
                                                    Оплата при получении в отделении «Нова Почта» + 2% комиссии от суммы заказа за наложенный платеж Заказы отправляются по предоплате 10% от стоимости заказа, но не менее 100 UAH.
                                                </p>
                                                <p>Подробнее читайте <a href="/oplata-i-dostavka" class="a-pseudo-active">тут</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="garantija-4">
                                        <div class="product__section">
                                            <div class="text mt-35">
                                                <p>
                                                    Вы можете обменять или вернуть купленный товар в течение 14 дней после получения посылки.
                                                    Как только возвращенный вами товар будет получен и проверен на нашем складе, мы незамедлительно свяжемся с вами по телефону либо эл. почту.
                                                </p>
                                                <p>Подробнее читайте <a href="/obmen-i-vozvrat" class="a-pseudo-active">тут</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                      $('#60813fe0872a1').children().TMTabs({
                                        watchHash: false,
                                        activeClass: 'is-active'
                                      });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($related): ?>
                <div class="product__bottom">
                    <div class="product__bottom-item" data-view-block="associatedProducts">
                        <section class="product__group" typeof="SomeProducts" resource="#product">
                            <div class="product__related">
                                <div class="product__related-container">
                                    <div class="product-heading product-heading--first">
                                        <div class="product-heading__title">Смотрите также</div>
                                    </div>
                                    <div class="productsSlider">
                                        <div class="productsSlider-container swiper-container-horizontal __hr __hl">
                                            <ul class="productsSlider-wrapper">

                                                <?php foreach ($related as $item): ?>
                                                <li class="productsSlider-i" style="margin-right: 20px;">
                                                    <a href="/product/<?=$item['alias']?>" property="url">
                                                        <div class="productsSlider-image">
                                                            <img class="productsSlider-img" src="<?=UPLOAD_PRODUCT_BASE.explode(',', $item['base_img'])[0]?>" property="image">                    </div>
                                                        <div class="productsSlider-title"><span class="a-link" property="name"><?=$item['title']?></span></div>
                                                    </a>

                                                    <div class="catalogCard-priceBox" style="justify-content: center; column-gap: initial;">
                                                      <?php if($item['old_price']): ?>
                                                          <div class="catalogCard-oldPrice text-center" style="margin-left: 5px;"><?=$item['old_price']?> грн.</div>
                                                      <?php endif; ?>

                                                        <div class="productsSlider-price"><?=$item['price']?> грн.</div>
                                                    </div>
                                                </li>
                                                <?php endforeach; ?>

                                            </ul>
                                        </div>

                                        <div class="slideCarousel-nav-btn __slideLeft" style="top: 89px; margin-top: 0px;"></div>
                                        <div class="slideCarousel-nav-btn __slideRight" style="top: 89px; margin-top: 0px;"></div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
                <?php endif; ?>

            </section>
        </div>

        <?php if($recentlyViewed): ?>
        <div class="mb-30">
            <section class="recentProducts">
                <div class="recentProducts-head">
                    <div class="h2">Просмотренные  товары</div>
                </div>
                <div class="recentProducts-body">

                    <div class="recentProducts-container swiper-container-horizontal __hr">
                        <ul class="recentProducts-wrapper">

                            <?php foreach ($recentlyViewed as $recentlyProduct): ?>
                            <li class="recentProducts-i swiper-slide-active">
                                <a href="/product/<?=$recentlyProduct['alias']?>">
                                    <div class="recentProducts-image">
                                        <img alt="<?=$recentlyProduct['title']?>" width="115" height="160" src="<?=UPLOAD_PRODUCT_BASE.explode(',', $recentlyProduct['base_img'])[0]?>">        </div>
                                    <div class="recentProducts-title">
                                        <span class="a-link"><?=$recentlyProduct['title']?></span>
                                    </div>
                                </a>

                                <div class="catalogCard-priceBox" style="justify-content: center; column-gap: initial;">
                                  <?php if($recentlyProduct['old_price']): ?>
                                      <div class="catalogCard-oldPrice text-center" style="margin-left: 5px;"><?=$recentlyProduct['old_price']?> грн.</div>
                                  <?php endif; ?>

                                    <div class="recentProducts-price"><?=$recentlyProduct['price']?> грн.</div>
                                </div>

                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="slideCarousel-nav-btn __slideLeft __disabled" style="top: 69px; margin-top: 0px;"></div>
                    <div class="slideCarousel-nav-btn __slideRight" style="top: 69px; margin-top: 0px;"></div>
                </div>
            </section>

            <script type="text/javascript">

              setTimeout(function(){
                initRecentProductsSwiper();
              }, 500);

            </script>
        </div>
        <?php endif;?>

    </div>

</main>