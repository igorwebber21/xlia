<main class="page-main">
    <div class="block">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="<?=PATH?>"><i class="icon icon-home"></i></a></li>
                 <li><span> / </span></li>
                <li><span>Корзина</span></li>
            </ul>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div id="cart-content">

                <?php if(!empty($_SESSION['cart'])):?>
                    <div class="cart-table">
                        <?php  require APP . "/views/Cart/cart_content.php"; ?>
                    </div>

                    <div class="blockquote hide form-errors"> </div>

                <?php if(!isset($_SESSION['user'])): ?>
                    <!-- Tab panes -->
                    <ul class="nav-tabs product-tab" role="tablist">
                        <li><a href="#orderRegistration" role="tab" data-toggle="tab">Заказать</a></li>
                        <li><a href="#orderQuick" role="tab" data-toggle="tab">Заказать быстро</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="orderRegistration">
                            <form id="orderForm" class="white" method="post" action="cart/checkout" autocomplete="off">

                                <div class="row">
                                    <div class="col-md-4 total-wrapper">

                                        <h2>Заказать</h2>

                                        <div class="form-group">
                                            <label for="orderComment">Комментарий к заказу</label>
                                            <textarea class="form-control" name="orderComment" id="orderComment"></textarea>
                                        </div>
                                        <table class="total-price">
                                            <tr>
                                                <td>Товаров <span class="cartTotalQty"><?=$_SESSION['cart.qty']?></span> на сумму</td>
                                                <td><?=$_SESSION['cart.currency']['symbol_left']?>
                                                    <span class="cartSum"><?=round($_SESSION['cart.sum'])?></span>
                                                    <?=$_SESSION['cart.currency']['symbol_right'] ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Доставка</td>
                                                <td> <?=$_SESSION['cart.currency']['symbol_left']?><span class="cartDeliveryPrice">50</span> <?=$_SESSION['cart.currency']['symbol_right'] ?></td>
                                            </tr>
                                            <tr class="total">
                                                <td>К оплате</td>
                                                <td><?=$_SESSION['cart.currency']['symbol_left']?> <span class="cartTotalSum"><?=round($_SESSION['cart.sum']) + $delivery_methods[0]['price']?></span> <?=$_SESSION['cart.currency']['symbol_right'] ?></td>
                                            </tr>
                                        </table>
                                        <div class="cart-action">
                                            <div>
                                                <button class="btn" type="submit">Заказ подтверждаю</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">

                                        <h2>Ваши контактные данные</h2>

                                        <div class="form-group has-feedback">
                                            <label for="userName">Имя<span class="required">*</span></label>
                                            <input type="text" class="form-control" id="userName" name="userName" required data-minlength="3">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="userLastName">Фамилия <span class="required">*</span></label>
                                            <input type="text" class="form-control" id="userLastName" name="userLastName" required data-minlength="3">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="userPhone">Мобильный телефон <span class="required">*</span></label>
                                            <input type="tel" class="form-control phone-checker" id="userPhone" name="userPhone" required pattern="[\+]\d{2}[\s][\(]\d{3}[\)][\s]\d{3}[\-]\d{2}[\-]\d{2}" placeholder="+38 (___) ___-__-__">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="userEmail">Email <span class="required">*</span></label>
                                            <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                    </div>
                                    <div class="col-sm-6 col-md-4">

                                        <h2>Адрес доставки</h2>

                                        <div class="form-group">
                                            <label for="deliveryMethod">Способ доставки<span class="required">*</span></label>
                                            <div class="select-wrapper">
                                                <select class="form-control cart-select" id="deliveryMethod" name="deliveryMethod">
                                                    <?php if($delivery_methods):
                                                        foreach ($delivery_methods as $delivery_method): ?>
                                                            <option value="<?=$delivery_method['id']?>" data-type="<?=$delivery_method['type']?>"
                                                                    data-price="<?=$delivery_method['price']?>">
                                                                <?=$delivery_method['title']?> (<?=$delivery_method['price']?> <?=$delivery_method['currency']?>, <?=$delivery_method['timing']?>)
                                                            </option>
                                                        <?php endforeach;
                                                    else: ?>
                                                        <option value="0">Не определено</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="deliveryMethod">Способ оплаты<span class="required">*</span></label>
                                            <div class="select-wrapper">
                                                <select class="form-control cart-select" id="paymentMethod" name="paymentMethod">
                                                    <?php if($payment_methods):
                                                        foreach ($payment_methods as $payment_method): ?>
                                                            <option value="<?=$payment_method['id']?>">
                                                                <?=$payment_method['title']?>
                                                            </option>
                                                        <?php endforeach;
                                                    else: ?>
                                                        <option value="0">Не определено</option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback cityBlock">
                                            <label for="userCity" class="userCity">
                                                <span class="labelBlock">
                                                    <span>Город</span>
                                                    <span class="required">*</span>
                                                </span>
                                                <i class="fa fa-refresh fa-spin hide"></i>
                                            </label>
                                            <div class="dropdown">
                                                <input type="text" class="form-control dropdown-toggle" id="userCity" name="userCity" required
                                                       placeholder="Введите населённые пункт">
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="userCityDropdown"></ul>
                                            </div>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback addressBlock">
                                            <label for="warehousesDropdown">
                                                <span id="addressLabel">Отделение</span><span class="required">*</span>
                                                <i class="fa fa-refresh fa-spin hide"></i>
                                            </label>
                                            <div class="dropdown">
                                                <input type="text" class="form-control dropdown-toggle" id="warehousesDropdown" name="warehousesDropdown"
                                                       placeholder="Введите номер отделения или адрес" required>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" id="dropdownMenuWarehouses"></ul>
                                            </div>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="orderQuick">
                            <form id="orderFormQuick" class="white" method="post" action="cart/checkoutQuick" autocomplete="off">

                                        <div class="form-group has-feedback">
                                            <label for="userPhoneQuick">Мобильный телефон <span class="required">*</span></label>
                                            <input type="tel" class="form-control phone-checker" id="userPhoneQuick" name="userPhoneQuick"
                                            required pattern="[\+]\d{2}[\s][\(]\d{3}[\)][\s]\d{3}[\-]\d{2}[\-]\d{2}" placeholder="+38 (___) ___-__-__">
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group">
                                            <label for="orderCommentQuick">Комментарий к заказу</label>
                                            <textarea class="form-control" name="orderCommentQuick" id="orderCommentQuick"></textarea>
                                        </div>

                                        <table class="total-price">
                                            <tr>
                                                <td>Всего</td>
                                                <td> <span class="cartTotalQty"><?=$_SESSION['cart.qty']?></span> шт.</td>
                                            </tr>
                                            <tr class="total">
                                                <td>К оплате</td>
                                                <td><?=$_SESSION['cart.currency']['symbol_left']?> <span class="cartTotalSum"><?=round($_SESSION['cart.sum'])?></span> <?=$_SESSION['cart.currency']['symbol_right'] ?></td>
                                            </tr>
                                        </table>

                                        <div class="cart-action">
                                            <div>
                                                <button class="btn" type="submit">Заказ подтверждаю</button>
                                            </div>
                                        </div>
                            </form>
                        </div>
                    </div>
                    <!-- Tab panes -->
                <?php else: ?>
                        <form id="orderForm" class="white" method="post" action="cart/checkout" autocomplete="off">

                            <div class="row">
                                <div class="col-md-4 total-wrapper">

                                    <h2>Заказать</h2>

                                    <div class="form-group">
                                        <label for="orderComment">Комментарий к заказу</label>
                                        <textarea class="form-control" name="orderComment" id="orderComment"></textarea>
                                    </div>
                                    <table class="total-price">
                                        <tr>
                                            <td>Товаров <span class="cartTotalQty"><?=$_SESSION['cart.qty']?></span> на сумму</td>
                                            <td><?=$_SESSION['cart.currency']['symbol_left']?>
                                                <span class="cartSum"><?=round($_SESSION['cart.sum'])?></span>
                                                <?=$_SESSION['cart.currency']['symbol_right'] ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Доставка</td>
                                            <td> <?=$_SESSION['cart.currency']['symbol_left']?><span class="cartDeliveryPrice">50</span> <?=$_SESSION['cart.currency']['symbol_right'] ?></td>
                                        </tr>
                                        <tr class="total">
                                            <td>К оплате</td>
                                            <td><?=$_SESSION['cart.currency']['symbol_left']?> <span class="cartTotalSum"><?=round($_SESSION['cart.sum']) + $delivery_methods[0]['price']?></span> <?=$_SESSION['cart.currency']['symbol_right'] ?></td>
                                        </tr>
                                    </table>
                                    <div class="cart-action">
                                        <div>
                                            <button class="btn" type="submit">Заказ подтверждаю</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-4">

                                    <h2>Ваши контактные данные</h2>

                                    <div class="form-group has-feedback">
                                        <label for="userName">Имя<span class="required">*</span></label>
                                        <input type="text" class="form-control" id="userName" name="userName" required data-minlength="3" value="<?=$_SESSION['user']['fname']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="userLastName">Фамилия <span class="required">*</span></label>
                                        <input type="text" class="form-control" id="userLastName" name="userLastName" required data-minlength="3" value="<?=$_SESSION['user']['lname']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="userPhone">Мобильный телефон <span class="required">*</span></label>
                                        <input type="tel" class="form-control phone-checker" id="userPhone" name="userPhone" required pattern="[\+]\d{2}[\s][\(]\d{3}[\)][\s]\d{3}[\-]\d{2}[\-]\d{2}" placeholder="+38 (___) ___-__-__" value="<?=$_SESSION['user']['phone']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="userEmail">Email <span class="required">*</span></label>
                                        <input type="email" class="form-control" id="userEmail" name="userEmail" required value="<?=$_SESSION['user']['email']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                </div>
                                <div class="col-sm-6 col-md-4">

                                    <h2>Адрес доставки</h2>

                                    <div class="form-group">
                                        <label for="deliveryMethod">Способ доставки<span class="required">*</span></label>
                                        <div class="select-wrapper">
                                            <select class="form-control cart-select" id="deliveryMethod" name="deliveryMethod">
                                                <?php if($delivery_methods):
                                                    foreach ($delivery_methods as $delivery_method): ?>
                                                        <option value="<?=$delivery_method['id']?>" data-type="<?=$delivery_method['type']?>"
                                                                data-price="<?=$delivery_method['price']?>">
                                                            <?=$delivery_method['title']?> (<?=$delivery_method['price']?> <?=$delivery_method['currency']?>, <?=$delivery_method['timing']?>)
                                                        </option>
                                                    <?php endforeach;
                                                else: ?>
                                                    <option value="0">Не определено</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="deliveryMethod">Способ оплаты<span class="required">*</span></label>
                                        <div class="select-wrapper">
                                            <select class="form-control cart-select" id="paymentMethod" name="paymentMethod">
                                                <?php if($payment_methods):
                                                    foreach ($payment_methods as $payment_method): ?>
                                                        <option value="<?=$payment_method['id']?>">
                                                            <?=$payment_method['title']?>
                                                        </option>
                                                    <?php endforeach;
                                                else: ?>
                                                    <option value="0">Не определено</option>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group has-feedback cityBlock">
                                        <label for="userCity" class="userCity">
                                                <span class="labelBlock">
                                                    <span>Город</span>
                                                    <span class="required">*</span>
                                                </span>
                                                <i class="fa fa-refresh fa-spin hide"></i>
                                        </label>
                                        <div class="dropdown">
                                            <input type="text" class="form-control dropdown-toggle" id="userCity" name="userCity" required
                                                   placeholder="Введите населённые пункт">
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="userCityDropdown"></ul>
                                        </div>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback addressBlock">
                                        <label for="warehousesDropdown">
                                            <span id="addressLabel">Отделение</span><span class="required">*</span>
                                            <i class="fa fa-refresh fa-spin hide"></i>
                                        </label>
                                        <div class="dropdown">
                                            <input type="text" class="form-control dropdown-toggle" id="warehousesDropdown" name="warehousesDropdown"
                                                   placeholder="Введите номер отделения или адрес" required>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu2" id="dropdownMenuWarehouses"></ul>
                                        </div>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                </div>
                            </div>

                        </form>
                <?php endif; ?>

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

                <?php else: ?>
                    <div class="no-products-block">
                        <h1>В корзину ещё не добавлено ни одного товара</h1>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</main>
<!-- /Page Content -->