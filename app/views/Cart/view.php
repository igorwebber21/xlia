<main class="page-main">
    <div class="block">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="<?=PATH?>"><i class="icon icon-home"></i></a></li>
                <span> / </span>
                <li>Корзина</li>
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

                    <form id="orderForm" class="white" method="post" action="cart/checkout">
                        <div class="row">
                            <div class="col-md-3 total-wrapper">
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
                                    <label for="userPhone">Email <span class="required">*</span></label>
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
                                               placeholder="Введите населённые пункт" aria-haspopup="true" aria-expanded="true" autocomplete="off">
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