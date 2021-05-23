<div class="order-header">Ваш заказ</div>

<ul class="order-list">
  <?php foreach ($_SESSION['cart'] as $prodId => $item): ?>
    <li class="order-i j-cart-product">
      <div class="order-i-image">
        <img width='63' height='78' src='<?=UPLOAD_PRODUCT_BASE.$item['img']?>' alt="<?=$item['title']?>">
      </div>
      <div class="order-i-content clr">
        <a class="order-i-remove j-remove-p cart-remove-action" href="#" prod-id="<?=$prodId?>">
          <i class="icon-cart-remove"></i>
        </a>
        <div class="order-i-description">
          <div class="order-i-title">
            <a href="/product/<?=$item['alias']?>"><?=$item['title']?></a>
          </div>
          <div class="order-i-container">
            <?php if($item['old_price']): ?>
              <div class="order-i-price __old"><?=$item['old_price']?> грн</div>
            <?php endif;?>
            <div class="order-i-price"><?=$item['price']?> грн</div>
          </div>
        </div>
        <div class="order-i-control">
          <div class="cart-quantity">
            <div class="counter counter--large">
              <div class="counter__container">
                <button class="counter-btn __minus __disabled j-decrease-p" data-prod="<?=$prodId?>">
                  <span class="icon-minus"></span>
                </button>
                <div class="counter-input">
                  <input class="counter-field j-quantity-p" type="text" value="<?=$item['qty']?>" data-step="1" data-min="1" data-max="9223372036854775807">
                </div>
                <button class="counter-btn __plus j-increase-p" data-prod="<?=$prodId?>">
                  <span class="icon-plus"></span>
                </button>
              </div>
              <div class="counter__units"></div>
              <div class="counter-message j-quantity-reached-message">Больше нет в наличии</div>
            </div>
          </div>
          <div class="order-i-cost j-sum-p"><?=$item['price'] * $item['qty']?> грн            </div>
        </div>
      </div>
    </li>
  <?php endforeach;?>
</ul>

<div class="order-summary">
  <div class="order-summary-h">Итого</div>
  <div class="order-summary-b j-total-sum-delivery"><?=$_SESSION['cart.sum']?> грн</div>
</div>