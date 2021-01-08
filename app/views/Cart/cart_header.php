
    <a href="/cart/view"> <i class="icon icon-cart"></i>
        <?php if(isset($_SESSION['cart'])): ?><span class="badge"><?=$_SESSION['cart.qty']?></span> <?php endif;?>
    </a>
    <!-- minicart wrapper -->
    <div class="right dropdown-container">
        <!-- minicart content -->
        <div class="block block-minicart">
            <div class="minicart-content-wrapper">
                <?php if(isset($_SESSION['cart'])): ?>
                    <div class="block-title">
                        <span>Товары в корзине</span>
                    </div>
                    <a class="btn-minicart-close" title="Close">&#10060;</a>
                    <div class="block-content">
                        <div class="minicart-items-wrapper overflowed">
                            <ol class="minicart-items">
                                <?php foreach ($_SESSION['cart'] as $id =>  $item): ?>
                                    <li class="item product product-item">
                                        <div class="product">
                                            <a class="product-item-photo" href="/product/<?=$item['alias'];?>" title="Long sleeve overall">
                                                                        <span class="product-image-container">
                                                                        <span class="product-image-wrapper">
                                                                        <img class="product-image-photo" src="<?=PRODUCTIMG?><?=$item['img'];?>" alt="Long sleeve overall">
                                                                        </span>
                                                                        </span>
                                            </a>
                                            <div class="product-item-details">
                                                <div class="product-item-name">
                                                    <a href="/product/<?=$item['alias'];?>"><?=$item['title']?></a>
                                                </div>
                                                <div class="product-item-qty">
                                                    <label class="label">Qty</label>
                                                    <i class="icon icon-minus" data-id="<?=$id?>"></i>
                                                    <input readonly class="item-qty cart-item-qty" maxlength="12" value="<?=$item['qty']?>">
                                                    <i class="icon icon-plus" data-id="<?=$id?>"></i>
                                                    <button class="update-cart-item" style="display: none" title="Update">
                                                        <span>Update</span>
                                                    </button>
                                                </div>
                                                <div class="product-item-pricing">
                                                    <div class="price-container">
                                                                                <span class="price-wrapper">
                                                                                    <span class="price-excluding-tax">
                                                                                    <span class="minicart-price">
                                                                                    <span class="price"><?=$_SESSION['cart.currency']['symbol_left'];?><?php echo round($item['price'] * $item['qty']); ?><?=$_SESSION['cart.currency']['symbol_right'];?></span> </span>
                                                                                </span>
                                                                                </span>
                                                    </div>
                                                    <div class="product actions">
                                                        <div class="secondary">
                                                            <a href="#" data-id="<?=$id?>" class="action delete" title="Удалить">
                                                                <span>Delete</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                        <div class="subtotal">
                                                        <span class="label">
                                                            <span>Subtotal</span>
                                                        </span>
                            <div class="amount price-container">
                                                        <span class="price-wrapper">
                                                            <span class="price"><?=$_SESSION['cart.currency']['symbol_left'];?><?=round($_SESSION['cart.sum'])?><?=$_SESSION['cart.currency']['symbol_right'];?></span>
                                                        </span>
                            </div>
                        </div>
                        <div class="actions cart-actions-btns">
                            <div class="secondary">
                                <a href="#" class="btn btn-alt cart-clear">
                                    <i class="icon icon-trash-alt"></i><span> Очистить </span>
                                </a>
                            </div>
                            <div class="primary">
                                <a class="btn btn-alt" href="/cart/view">
                                    <i class="icon icon-external-link"></i><span>В корзину </span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <h3 class="text-center">Корзина пуста</h3>
                <?php endif; ?>
            </div>
        </div>
        <!-- /minicart content -->
    </div>
    <!-- /minicart wrapper -->

