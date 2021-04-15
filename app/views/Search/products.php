<?php if(!empty($products)): ?>

    <!-- Product Item -->
    <?php  $curr = \ishop\App::$app->getProperty('currency'); ?>
    <?php foreach ($products as $product):
           $productImages = explode(',', $product['base_img']);
    ?>
        <div class="product-item large category1">
            <div class="product-item-inside">
                <div class="product-item-info">
                    <!-- Product Photo -->
                    <div class="product-item-photo">
                        <!-- Product Label -->
                        <div class="product-item-label label-new"><span>New</span></div>
                        <!-- /Product Label -->
                        <!-- product main photo -->
                        <!-- product inside carousel -->
                        <div class="carousel-inside slide" data-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                <?php if($productImages[0]): ?>
                                    <?php for ($im = 0; $im< count($productImages); $im++): ?>
                                    <div class="item<?php if($im == 0) echo ' active';?>">
                                        <a href="product/<?=$product['alias']?>"><img class="product-image-photo" src="<?=PRODUCTIMG.$productImages[$im]?>" alt=""></a>
                                    </div>
                                    <?php endfor; ?>
                                <?php else:?>
                                    <div class="item active">
                                        <a href="product/<?=$product['alias']?>">
                                            <img class="product-image-photo" src="<?=PRODUCTIMG?>no_image.jpg" alt="">
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <a class="carousel-control next"></a>
                            <a class="carousel-control prev"></a>
                        </div>
                        <!-- /product inside carousel -->

                        <!-- /product main photo  -->
                        <!-- Product Actions -->
                        <a href="#" title="Add to Wishlist" class="no_wishlist"> <i class="icon icon-heart"></i><span>Add to Wishlist</span> </a>

                        <!-- /Product Actions -->
                    </div>
                    <!-- /Product Photo -->
                    <!-- Product Details -->
                    <div class="product-item-details">
                        <div class="product-item-name"> <a title="Lace back mini dress" href="product/<?=$product['alias']?>" class="product-item-link"><?=$product['title']?></a> </div>
                        <div class="product-item-description">Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia nonkdni numquam eius modi tempora incidunt ut labore</div>
                        <div class="price-box">
                                        <span class="price-container">
                                            <span class="price-wrapper">
                                                <?php if($product['old_price']): ?>
                                                    <span class="old-price"><?=$curr['symbol_left'];?><?=round($product['old_price']  * $curr['value'])?><?=$curr['symbol_right'];?></span>
                                                <?php endif; ?>
                                                <span class="special-price">
                                                    <?=$curr['symbol_left'];?><?=round($product['price'] * $curr['value']);?><?=$curr['symbol_right'];?>
                                                </span>
                                            </span>
                                        </span>
                        </div>

                        <button class="btn add-to-cart" data-id="<?=$product['id'];?>" href="cart/add?id=<?=$product['id'];?>">
                            <i class="icon icon-cart"></i><span>В корзину</span>
                        </button>
                    </div>
                    <!-- /Product Details -->
                </div>
            </div>
        </div>
    <?php
    endforeach; ?>
    <!-- /Product Item -->

<?php else: ?>

    <h2>По данным фильтрам товаров не найдено</h2>
<?php endif; ?>

