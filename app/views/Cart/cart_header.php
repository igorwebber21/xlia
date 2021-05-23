<div class="basket__icon basket__icon--bag j-basket-icon">
    <svg class="icon icon--bag">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-bag"></use>
    </svg>
    <div class="basket__items"><?php echo isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] : 0; ?></div>
</div>
<div class="basket__contents">
    <div class="basket__title">Мой заказ</div>
    <div class="basket__value"><?php echo isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] : 0; ?> грн</div>
</div>