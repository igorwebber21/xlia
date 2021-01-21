<!-- Page Content -->
<main class="page-main">
    <div class="block">
        <div class="container">
            <ul class="breadcrumbs">
                <?=$breadcrumbs;?>
                <li class="product-nav">
                    <i class="icon icon-angle-left"></i><a href="#" class="product-nav-prev">prev product
                        <span class="product-nav-preview">
							<span class="image"><img src="images/products/product-prev-preview.jpg" alt=""><span class="price">$280</span></span>
							<span class="name">Black swimsuit</span>
						</span></a>/
                    <a href="#" class="product-nav-next">next product
                        <span class="product-nav-preview">
							<span class="image"><img src="images/products/product-next-preview.jpg" alt=""><span class="price">$280</span></span>
							<span class="name">Black swimsuit</span>
						</span></a><i class="icon icon-angle-right"></i>
                </li>
            </ul>
        </div>
    </div>
    <div class="block product-block product-item-inside">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-5">
                    <!-- Product Gallery -->
                    <div class="container">
                        <div class="row">
                            <?php  $previewImg = ($gallery) ? GALLERYIMG.reset($gallery)->img : '/public/upload/images/product-9.jpg';?>
                            <div class="main-image col-xs-10">
                                <img src="<?=$previewImg?>" class="zoom product-image-photo" alt="" data-zoom-image="<?=$previewImg?>" />
                                <?php if($gallery): ?>
                                <div class="dblclick-text"><span>Double click for enlarge</span></div>
                                <a href="<?=$previewImg?>" class="zoom-link"><i class="icon icon-zoomin"></i></a>
                                <?php endif; ?>
                            </div>

                            <?php if($gallery): ?>
                            <div class="product-previews-wrapper col-xs-2">
                                <div class="product-previews-carousel" id="previewsGallery">
                                    <?php foreach ($gallery as $item): ?>
                                    <a href="#" data-image="<?=GALLERYIMG.$item->img?>" data-zoom-image="<?=GALLERYIMG.$item->img?>"><img src="<?=GALLERYIMG.$item->img?>" alt="" /></a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- /Product Gallery -->
                </div>
                <div class="col-sm-6 col-md-6 col-lg-7">
                    <div class="product-info-block classic">
                        <div class="product-name-wrapper">
                            <h1 class="product-name"><?=$product->title?></h1>
                            <div class="product-labels">
                                <span class="product-label sale">SALE</span>
                                <span class="product-label new">NEW</span>
                            </div>
                        </div>
                        <div class="product-availability">Осталось: <span>5 шт.</span></div>
                        <div class="product-description">
                            <p>Брюки из коллекции Medicine. Модель выполнена из гладкой ткани.</p>
                        </div>
                        <div class="product-options">
                            <div class="product-size swatches">
                                <span class="option-label">Размер:</span>
                                <div class="select-wrapper-sm">
                                    <select class="form-control input-sm size-variants">
                                        <option value="36">36 - $114.00 USD</option>
                                        <option value="38" selected>38 - $114.00 USD</option>
                                        <option value="40">40 - $114.00 USD</option>
                                        <option value="42">42 - $114.00 USD</option>
                                    </select>
                                </div>
                                <ul class="size-list">
                                    <li class="absent-option"><a href="#" data-value='36'><span class="value">36</span></a></li>
                                    <li><a href="#" data-value='38'><span class="value">38</span></a></li>
                                    <li><a href="#" data-value='40'><span class="value">40</span></a></li>
                                    <li><a href="#" data-value='42'><span class="value">42</span></a></li>
                                </ul>
                            </div>
                            <div class="product-color swatches">
                                <span class="option-label">Цвет:</span>
                                <div class="select-wrapper-sm">
                                    <select class="form-control input-sm">
                                        <option value="Red">Red</option>
                                        <option value="Green">Green</option>
                                        <option value="Blue" selected>Blue</option>
                                        <option value="Yellow">Yellow</option>
                                        <option value="Grey">Grey</option>
                                        <option value="Violet">Violet</option>
                                    </select>
                                </div>
                                <ul class="color-list">
                                    <li class="absent-option"><a href="#" data-toggle="tooltip" data-placement="top" title="Red" data-value="Red" data-image="images/products/product-color-red.jpg"><span class="value"><img src="images/colorswatch/color-red.png" alt=""></span></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Pink" data-value="Green" data-image="images/products/product-color-green.jpg"><span class="value"><img src="images/colorswatch/color-green.png" alt=""></span></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Marine" data-value="Blue" data-image="images/products/product-color-blue.jpg"><span class="value"><img src="images/colorswatch/color-blue.png" alt=""></span></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Orange" data-value="yellow" data-image="images/products/product-color-yellow.jpg"><span class="value"><img src="images/colorswatch/color-yellow.png" alt=""></span></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Orange" data-value="grey" data-image="images/products/product-color-grey.jpg"><span class="value"><img src="images/colorswatch/color-grey.png" alt=""></span></a></li>
                                    <li><a href="#" data-toggle="tooltip" data-placement="top" title="Orange" data-value="grey" data-image="images/products/product-color-violet.jpg"><span class="value"><img src="images/colorswatch/color-violet.png" alt=""></span></a></li>
                                </ul>
                            </div>
                            <div class="product-qty">
                                <span class="option-label">Кол-во:</span>
                                <div class="qty qty-changer">
                                    <fieldset>
                                        <input type="button" value="&#8210;" class="decrease">
                                        <input type="text" class="qty-input" value="2" data-min="0">
                                        <input type="button" value="+" class="increase">
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="product-actions">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="product-meta">
                                        <span><a href="#"><i class="icon icon-heart"></i> В избранное</a></span>
                                    </div>
                                    <div class="social">
                                        <div class="share-button toLeft">
                                            <span class="toggle">Поделиться</span>
                                            <ul class="social-list">
                                                <li>
                                                    <a href="#" class="icon icon-google google"></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="icon icon-fancy fancy"></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="icon icon-pinterest pinterest"></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="icon icon-twitter-logo twitter"></a>
                                                </li>
                                                <li>
                                                    <a href="#" class="icon icon-facebook-logo facebook"></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="price">
                                        <span class="old-price"><span><?=$curr['symbol_left'];?><?=round($product->old_price * $curr['value']);?><?=$curr['symbol_right'];?></span></span>
                                        <span class="special-price"><span><?=$curr['symbol_left'];?><?=round($product->price * $curr['value']);?><?=$curr['symbol_right'];?></span></span>
                                    </div>
                                    <div class="actions">
                                        <button class="btn btn-lg add-to-cart" data-id="<?=$product->id;?>" href="cart/add?id=<?=$product->id;?>">
                                            <i class="icon icon-cart"></i><span>В корзину</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="block">
        <div class="tabaccordion">
            <div class="container">
                <!-- Nav tabs -->
                <ul class="nav-tabs product-tab" role="tablist">
                    <li><a href="#Tab1" role="tab" data-toggle="tab">Описание</a></li>
                    <li><a href="#Tab2" role="tab" data-toggle="tab">Замеры</a></li>
                    <li><a href="#Tab3" role="tab" data-toggle="tab">Размерная сетка</a></li>
                    <li><a href="#Tab4" role="tab" data-toggle="tab">Отправка</a></li>
                    <li><a href="#Tab5" role="tab" data-toggle="tab">Гарантия и возврат</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="Tab1">
                        <p>Брюки из коллекции Medicine. Модель выполнена из гладкой ткани.</p>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                <tr>
                                    <td><strong>Крой </strong></td>
                                    <td>slim</td>
                                </tr>
                                <tr>
                                    <td><strong>Карманы</strong></td>
                                    <td>Прорезные карманы</td>
                                </tr>
                                <tr>
                                    <td><strong>Застегивается</strong></td>
                                    <td>На пуговицу и молнию</td>
                                </tr>
                                <tr>
                                    <td><strong>Фасон</strong></td>
                                    <td>Приталенный</td>
                                </tr>
                                <tr>
                                    <td><strong>Материал</strong></td>
                                    <td>Ткань с эластаном</td>
                                </tr>
                                <tr>
                                    <td><strong>Состав</strong></td>
                                    <td>2% Эластан, 98% Хлопок</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Tab2">
                        <h3 class="custom-color">Параметры указаны для размера - <span>31</span></h3>
                        <table class="table table-bordered table-striped">
                            <tbody>
                            <tr>
                                <td><strong>Ширина по поясу </strong></td>
                                <td>42 см</td>
                            </tr>
                            <tr>
                                <td><strong>Полуобхват бедер </strong></td>
                                <td>51 см</td>
                            </tr>
                            <tr>
                                <td><strong>Высота талии </strong></td>
                                <td>26 см</td>
                            </tr>
                            <tr>
                                <td><strong>Ширина штанины снизу </strong></td>
                                <td>42 см</td>
                            </tr>
                            <tr>
                                <td><strong>Ширина по поясу </strong></td>
                                <td>17 см</td>
                            </tr>
                            <tr>
                                <td><strong>Ширина штанины сверху </strong></td>
                                <td>27 см</td>
                            </tr><tr>
                                <td><strong>Длина </strong></td>
                                <td>104 см</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Tab3">
                        <h3 class="custom-color">Размерная сетка</h3>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td><strong>РАЗМЕР</strong></td>
                                    <td>
                                        <ul class="params-row">
                                            <li>S</li>
                                            <li>M</li>
                                            <li>L</li>
                                            <li>XL</li>
                                            <li>XXL</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>ОБХВАТ ТАЛИИ, см</strong></td>
                                    <td>
                                        <ul class="params-row">
                                            <li>78-82</li>
                                            <li>83-87</li>
                                            <li>88-92</li>
                                            <li>93-97</li>
                                            <li>98-102</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>ВНУТРЕННЯЯ ДЛИНА ЩИКОЛОТКИ, см</strong></td>
                                    <td>
                                        <ul class="params-row">
                                            <li>84</li>
                                            <li>84</li>
                                            <li>86</li>
                                            <li>86</li>
                                            <li>86</li>
                                        </ul>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Tab4">
                        <p>Отправка товара происходит в день после оформления заказа, при условии, что заказ оформлен до 16:00</p>
                        <p>Срок доставки 1-3 дня по Украине в зависимости от графика перевозчика.</p>
                        <p>Доставка осуществляется Новой Почтой или УкрПочтой</p>
                        <p>Подробнее о доставке и оплате читайте <a href="dostavka-i-oplata"><strong>тут</strong></a>.</p>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="Tab5">
                        <p>
                            Вы вправе вернуть или обменять товар в течении 14 дней с момента получения заказа.
                        </p>
                        <p>
                            При обмене или возврате нового изделия пересылку оплачивает покупатель (или продавец, но в таком случае цена доставки будет вычтена из суммы возврата средств)
                        </p>
                        <p>
                            Обмену и возврату подлежат: изделия, которые не использовались; при наличии всех товарных ярлыков и бирок; изделия, которые невозможно эксплуатировать из-за выявленных дефектов.
                        </p>
                        <p>
                            Подробнее о возврате читайте <a href="dostavka-i-oplata"><strong>тут</strong></a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="row">

                <?php if($related): ?>
                <div class="col-md-12">
                    <!-- Deal Carousel -->
                    <div class="title">
                        <h2 class="custom-color">Похожие товары</h2>
                        <div class="toggle-arrow"></div>
                        <div class="carousel-arrows"></div>
                    </div>
                    <div class="collapsed-content">
                        <div class="similar-products-carousel products-grid product-variant-5">
                            <!-- Product Item -->
                            <?php foreach ($related as $item): ?>
                            <div class="product-item large">
                                <div class="product-item-inside">
                                    <div class="product-item-info">
                                        <!-- Product Photo -->
                                        <div class="product-item-photo">
                                            <!-- Product Label -->
                                            <div class="product-item-label label-new"><span>New</span></div>
                                            <!-- /Product Label -->
                                            <div class="product-item-gallery">
                                                <!-- product main photo -->
                                                <div class="product-item-gallery-main">
                                                    <a href="product/<?=$item['alias']?>"><img class="product-image-photo" src="<?=PRODUCTIMG.$item['img']?>" alt=""></a>

                                                </div>
                                                <!-- /product main photo  -->
                                            </div>
                                            <!-- Product Actions -->
                                            <a href="#" title="Add to Wishlist" class="no_wishlist"> <i class="icon icon-heart"></i><span>В избранное</span> </a>

                                            <!-- /Product Actions -->
                                        </div>
                                        <!-- /Product Photo -->
                                        <!-- Product Details -->
                                        <div class="product-item-details">
                                            <div class="product-item-name"> <a title="Style Dome Men's Solid Red Color" href="product/<?=$item['alias']?>" class="product-item-link"><?=$item['title']?></a> </div>

                                            <div class="price-box">
                                                    <span class="price-container">
                                                           <span class="price-wrapper">
                                                               <span class="old-price"><?=$curr['symbol_left'];?><?=$item['old_price']?><?=$curr['symbol_right'];?></span>
                                                                <span class="special-price">
                                                                    <?=$curr['symbol_left'];?><?=$item['price'];?><?=$curr['symbol_right'];?>
                                                                </span>
                                                           </span>
												    </span>
                                            </div>

                                            <button class="btn add-to-cart" data-id="<?=$item['id'];?>"> <i class="icon icon-cart"></i><span>В корзину</span> </button>
                                        </div>
                                        <!-- /Product Details -->
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <!-- /Deal Carousel -->
                </div>
                <?php endif; ?>

                <?php if($recentlyViewed): ?>
                <div class="col-md-12">
                    <!-- Deal Carousel -->
                    <div class="title">
                        <h2 class="custom-color">Просмотренные товары</h2>
                        <div class="toggle-arrow"></div>
                        <div class="carousel-arrows"></div>
                    </div>
                    <div class="collapsed-content">
                        <div class="viewed-products-carousel products-grid product-variant-5">
                            <!-- Product Item -->
                            <?php foreach ($recentlyViewed as $item): ?>
                                <div class="product-item large">
                                    <div class="product-item-inside">
                                        <div class="product-item-info">
                                            <!-- Product Photo -->
                                            <div class="product-item-photo">
                                                <!-- Product Label -->
                                                <div class="product-item-label label-new"><span>New</span></div>
                                                <!-- /Product Label -->
                                                <div class="product-item-gallery">
                                                    <!-- product main photo -->
                                                    <div class="product-item-gallery-main">
                                                        <a href="product/<?=$item['alias']?>"><img class="product-image-photo" src="<?=PRODUCTIMG.$item['img']?>" alt=""></a>

                                                    </div>
                                                    <!-- /product main photo  -->
                                                </div>
                                                <!-- Product Actions -->
                                                <a href="#" title="Add to Wishlist" class="no_wishlist"> <i class="icon icon-heart"></i><span>Add to Wishlist</span> </a>

                                                <!-- /Product Actions -->
                                            </div>
                                            <!-- /Product Photo -->
                                            <!-- Product Details -->
                                            <div class="product-item-details">
                                                <div class="product-item-name"> <a title="Style Dome Men's Solid Red Color" href="product/<?=$item['alias']?>" class="product-item-link"><?=$item['title']?></a> </div>

                                                <div class="price-box">
                                                    <span class="price-container">
                                                           <span class="price-wrapper">
                                                               <span class="old-price"><?=$curr['symbol_left'];?><?=$item['old_price']?><?=$curr['symbol_right'];?></span>
                                                                <span class="special-price">
                                                                    <?=$curr['symbol_left'];?><?=$item['price'];?><?=$curr['symbol_right'];?>
                                                                </span>
                                                           </span>
												    </span>
                                                </div>

                                                <button class="btn add-to-cart" data-product="789123"> <i class="icon icon-cart"></i><span>В корзину</span> </button>
                                            </div>
                                            <!-- /Product Details -->
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <!-- /Product Item -->

                        </div>
                    </div>
                    <!-- /Deal Carousel -->
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<!-- /Page Content -->