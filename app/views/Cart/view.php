<main class="main" id="main">
    <div class="wrapper">
        <div class="layout">
            <section class="checkout">
                <h1 class="main-h">Оформление заказа</h1>

                <div class="checkout-wrapp">
                    <div class="checkout-main">
                        <div class="checkout-body" id="checkout-signup">
                            <form action="/cart/checkout" method="post" id="orderForm">

                                <section class="checkout-step j-component" data-component="Recipient">
                                    <div class="checkout-step-h">Получатель заказа</div>

                                    <dl class="form">
                                        <dt class="form-head">ФИО</dt>
                                        <dd class="form-item">
                                            <input class="field" type="text" name="userName" id="userName" placeholder="Имя Фамилия" required value="<?php if(isset($_SESSION['user']['name'])) echo $_SESSION['user']['name']; ?>">
                                        </dd>
                                        <dt class="form-head">Телефон</dt>
                                        <dd class="form-item">
                                            <input placeholder="+38 (___) ___-__-__" class="field phone-checker" type="text" name="userPhone" id="userPhone" required value="<?php if(isset($_SESSION['user']['phone'])) echo $_SESSION['user']['phone']; ?>">
                                        </dd>
                                        <dt class="form-head">Почта</dt>
                                        <dd class="form-item">
                                            <input placeholder="Ваш Email" class="field j-phone" type="email" name="userEmail" id="userEmail" required value="<?php if(isset($_SESSION['user']['email'])) echo $_SESSION['user']['email']; ?>">
                                        </dd>
                                        <dt class="form-head">Адрес доставки</dt>
                                        <dd class="form-item">
                                            <input class="field j-ignore" type="text" name="userCity" id="userCity" required value="<?php if(isset($_SESSION['user']['address'])) echo $_SESSION['user']['address']; ?>" placeholder="Пример: г. Киев, Новая Почта, отделение №1">
                                        </dd>
                                        <dt class="form-head">Доставка</dt>
                                        <dd class="form-item j-delivery-main-container">
                                            <select class="select j-ignore j-delivery-type" name="deliveryMethod" id="deliveryMethod">
                                                <option value="1" data-price="0.00" data-by-carrier="0" selected>Новой почтой</option>
                                                <option value="2" data-price="-1" data-by-carrier="1">Укр почтой</option>
                                            </select>
                                        </dd>
                                        <dt class="form-head">Оплата</dt>
                                        <dd class="form-item">
                                            <select class="select j-payment-type j-ignore" name="paymentMethod" id="paymentMethod">
                                                <option value="1" selected>Предоплата на карту                   </option>
                                                <option value="2">Наложенный платеж                   </option>
                                            </select>
                                            <div class="form-item-txt"></div>
                                        </dd>
                                       <!-- <dt class="form-head j-comment-head">Комментарий</dt>
                                        <dd class="form-item j-comment-body">
                                            <textarea name="userComment" class="field __text"></textarea>
                                        </dd>-->
                                    </dl>
                                </section>

                                <div class="checkout-footer">
                                                <span class="btn j-submit __special">
                                                    <span class="btn-content">Оформить заказ</span>
                                                    <input class="btn-input" value="Оформить заказ" type="submit">
                                                </span>
                                </div>



                                <div class="col-xs-12 blockquote hide form-errors" style="margin: 20px 30px 25px;"></div>


                            </form>
                        </div>
                    </div>
                    <div class="checkout-aside">
                        <section class="order" id="cartCheckout">
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
                        </section>
                    </div>

                    <!-- loader -->
                    <div class="bg-loader hide"></div>
                    <div class="hide spinningSquaresLoader">
                        <div id="spinningSquaresG_1" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_2" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_3" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_4" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_5" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_6" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_7" class="spinningSquaresG"></div>
                        <div id="spinningSquaresG_8" class="spinningSquaresG"></div>
                    </div>
                    <!-- loader -->

                </div>

            </section>
        </div>
    </div>
</main>