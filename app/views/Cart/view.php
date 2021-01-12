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

                    <!-- Tab panes -->
                    <ul class="nav-tabs product-tab" role="tablist">
                        <li><a href="#orderRegistration" role="tab" data-toggle="tab">Заказать</a></li>
                        <li><a href="#orderQuick" role="tab" data-toggle="tab">Заказать быстро</a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="orderRegistration">
                            <form id="orderForm" class="white" method="post" action="cart/checkout" autocomplete="off">

                                <div class="row">
                                    <div class="col-md-3 total-wrapper">

                                        <h2>Заказать</h2>

                                        <div class="form-group">
                                            <label for="orderComment">Комментарий к заказу</label>
                                            <textarea class="form-control" name="orderComment" id="orderComment"></textarea>
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
                                    </div>
                                    <div class="col-sm-6 col-md-5">

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
                                            <label for="deliveryMethod">Способ<span class="required">*</span></label>
                                            <div class="select-wrapper">
                                                <select class="form-control cart-select" id="deliveryMethod" name="deliveryMethod">
                                                    <option value="УкрПочта">УкрПочта</option>
                                                    <option value="Новая Почта" selected>Новая Почта</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="userCity" class="userCity">
                                                <span class="labelBlock">
                                                    <span>Город</span>
                                                    <span class="required">*</span>
                                                </span>
                                            </label>
                                            <div class="dropdown">
                                                <input type="text" class="form-control dropdown-toggle" id="userCity" name="userCity" required
                                                       placeholder="Введите населённые пункт">
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="userCityDropdown"></ul>
                                            </div>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <label for="warehousesDropdown">Отделение<span class="required">*</span></label>
                                            <div class="select-wrapper">
                                                <select class="form-control cart-select" name="warehousesDropdown" id="warehousesDropdown" required>
                                                    <option value="" readonly="readonly" selected>Не выбрано</option>
                                                </select>
                                            </div>
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

                    <!-- loader -->
                    <div class="bg-loader hide"></div>
                    <div id="orderLoader" class="hide">
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