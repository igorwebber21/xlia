<?php if(!empty($_SESSION['cart'])):?>

        <div class="table-header">
            <div class="photo">
            </div>
            <div class="name">
            </div>
            <div class="price">
                Цена
            </div>
            <div class="qty">
                Кол-во
            </div>
            <div class="subtotal">
                Сумма
            </div>
            <div class="remove">
            </div>
        </div>
        <?php foreach($_SESSION['cart'] as $id => $item): ?>
            <div class="table-row">
                <div class="photo">
                    <a href="product/<?=$item['alias']?>"><img src="<?=PRODUCTIMG?><?=$item['img'];?>" alt="<?=$item['title'] ?>"></a>
                </div>
                <div class="name">
                    <a href="product/<?=$item['alias']?>"><?=$item['title'] ?></a>
                </div>
                <div class="price">
                    <?=$_SESSION['cart.currency']['symbol_left']?> <?=round($item['price'])?> <?=$_SESSION['cart.currency']['symbol_right'] ?>
                </div>
                <div class="qty qty-changer product-item-qty">
                    <fieldset>
                        <input type="button" value="&#8210;" class="decrease icon icon-minus" data-id="<?=$id?>">
                        <input type="text" class="qty-input" value="<?=$item['qty']?>" data-min="0" data-max="1000">
                        <input type="button" value="+" class="increase icon icon-plus" data-id="<?=$id?>">
                    </fieldset>
                </div>
                <div class="subtotal">
                    <?=$_SESSION['cart.currency']['symbol_left']?> <?=round($item['price']*$item['qty'])?> <?=$_SESSION['cart.currency']['symbol_right'] ?>
                </div>
                <div class="remove">
                    <a href="#" class="icon icon-close-2 action delete" data-id="<?=$id?>"></a>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="table-footer">
            <button class="btn btn-alt pull-right cart-clear"><i class="icon icon-bin"></i><span>Очистить корзину</span></button>
        </div>

<?php else: ?>
    <div class="no-products-block">
        <h1>В корзину ещё не добавлено ни одного товара</h1>
    </div>
<?php endif; ?>
