<a href="#" class="toggleStack"><i class="icon icon-cart"></i> (<?php echo (!empty($_SESSION['cart'])) ? $_SESSION['cart.qty'] : 0;?>) шт.</a>
<div class="productstack-content">
    <div class="products-list-wrapper">
        <?php if(isset($_SESSION['cart'])): ?>
            <ul class="products-list">
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <li>
                        <a href="/product/<?=$item['alias'];?>" title="Product Name Long Name">
                            <img class="product-image-photo" src="<?=PRODUCTIMG?><?=$item['img'];?>" alt=""></a> <span class="item-qty"><?=$item['qty']?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
    <?php if(isset($_SESSION['cart'])): ?>
    <div class="total-cart">
        <div class="items-total">Товаров: <span class="count"><?=$_SESSION['cart.qty']; ?></span></div>
        <div class="subtotal">Цена: <span class="price"><?=$_SESSION['cart.currency']['symbol_left'];?><?php echo round($_SESSION['cart.sum']); ?><?=$_SESSION['cart.currency']['symbol_right'];?></span></div>
        <div class="items-go-to-cart">
            <a href="/cart/view">
                <button type="button" class="btn"> <span>Заказать</span> </button>
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

