<?php if(isset($_SESSION['cart']) && $_SESSION['cart']): ?>
    <table class="cart-items">
        <thead>
        <tr>
            <td></td>
            <td></td>
            <td class="cart-header">
                <div class="cart-header-b">
                    <span class="cart-header-content">Количество</span>
                </div>
            </td>
            <td class="cart-header __cost">
                <div class="cart-header-b">
                    <span class="cart-header-content">Стоимость</span>
                </div>
            </td>
        </tr>
        </thead>
        <tbody class="cart-section">
        <?php foreach ($_SESSION['cart'] as $prodId => $item): ?>
            <tr class="j-cart-product j-remove-container" id="prodCartModal-<?=$prodId?>">
                <td class="cart-cell __image">
                    <div class="cart-remove">
                        <a class="cart-remove-btn j-remove-p cart-remove-action" href="#" prod-id="<?=$prodId?>">
                            <i class="icon-cart-remove"></i>
                        </a>
                    </div>
                    <div class="cart-image">
                        <a href="/product/<?=$item['alias']?>">
                            <img width='63' height='78' alt="<?=$item['title']?>" src='<?=UPLOAD_PRODUCT_BASE.$item['img']?>' />
                        </a>
                    </div>
                </td>
                <td class="cart-cell __details">
                    <div class="cart-title">
                        <a href="/product/<?=$item['alias']?>"><?=$item['title']?> </a>
                    </div>
                    <div class="cart-price"><?=$item['price']?> грн        </div>
                </td>
                <td class="cart-cell __quantity">
                    <div class="cart-quantity">
                        <div class="counter counter--large">
                            <div class="counter__container">
                                <button class="counter-btn __minus __disabled j-decrease-p" data-prod="<?=$prodId?>">
                                    <span class="icon-minus"></span>
                                </button>
                                <div class="counter-input">
                                    <input class="counter-field j-quantity-p" type="text" value="<?=$item['qty']?>" data-step="1" data-min="1" data-max="9223372036854775807" />
                                </div>
                                <button class="counter-btn __plus j-increase-p" data-prod="<?=$prodId?>">
                                    <span class="icon-plus"></span>
                                </button>
                            </div>
                            <div class="counter__units"></div>
                            <div class="counter-message j-quantity-reached-message">Больше нет в наличии</div>
                        </div>
                    </div>
                </td>
                <td class="cart-cell __cost">
                    <div class="cart-cost j-sum-p"><?=$item['price'] * $item['qty']?> грн</div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tr class="j-cart-loader" style="display: none;">
            <td class="cart-cell __details" colspan="4">
                <div class="loader" style="position: relative;margin: 0 auto;"></div>
            </td>
        </tr>
        <tfoot class="cart-foot">

        <tr>
            <td class="cart-footer" colspan="4">
                <div class="cart-summary">
                    <div class="cart-footer-h">Итого</div>
                    <div class="cart-footer-b cart-cost j-total-sum"><?=$_SESSION['cart.sum']?> грн</div>
                </div>
                <div class="cart-buttons">
                    <div class="cart-btnBack">
                        <a class="a-btn" href="javascript:void(0);" onclick="closeModal(); return false;">
                            <i class="icon-arrow-left2"></i>
                            <span class="a-pseudo">Вернуться к покупкам</span>
                        </a>
                    </div>
                    <div class="cart-btnOrder">
                        <a class="btn __special" rel="nofollow" href="/cart/view">
                            <span class="btn-content">Оформить заказ</span>
                        </a>
                    </div>
                </div>
            </td>
        </tr>
        </tfoot>
    </table>
<?php else: ?>
    <h3 class="empty-cart-title">Корзина пуста</h3>
<?php endif;?>