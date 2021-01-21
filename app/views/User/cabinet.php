<!-- Page Content -->
<main class="page-main">
    <div class="block">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="<?=PATH?>"><i class="icon icon-home"></i></a></li>
                <li> <span> / </span> </li>
                <li> <span>Личные данные</span> </li>
            </ul>
        </div>
    </div>
    <div class="block">
        <div class="container">

            <div class="form-card" id="userCabinet">

                <h1 class="text-center">Личный кабинет</h1>

                <!-- Tab panes -->
                <ul class="nav-tabs product-tab" role="tablist" id="userCabinetMenu">
                    <li>
                        <i class="icon icon-user"></i>
                        <span class="userName"><?=$_SESSION['user']['fname']?> <?=$_SESSION['user']['lname']?></span>
                    </li>
                    <li class="active"><a href="#userInfo" role="tab" data-toggle="tab">Личные данные</a></li>
                    <li><a href="#userChangePassword" role="tab" data-toggle="tab">Смена пароля</a></li>
                    <li><a href="#userOrders" role="tab" data-toggle="tab">Мои заказы</a></li>
                    <li><a href="#userFavourites" role="tab" data-toggle="tab">Избранное</a></li>
                    <li><a href="#userBonusCash" role="tab" data-toggle="tab">Бонусный счёт</a></li>
                    <li>
                        <a href="user/logout" class="btn-out">
                            <span>Выйти из аккаунта</span>
                            <i class="icon icon-arrow-right"></i>
                        </a>
                    </li>
                </ul>

                <div class="tab-content" id="userCabinetPanel">

                    <div role="tabpanel" class="tab-pane" id="userInfo">

                        <div class="blockquote hide form-errors"> </div>
                        <div class="blockquote hide form-success"> </div>

                        <form id="userInfoForm" class="white" method="post" action="user/edit" autocomplete="off">

                            <div class="row">
                                <div class="col-xs-5">

                                    <h2>Мои личные данные</h2>

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
                                        <label for="userBirthday">Дата рождения <span class="required">*</span></label>
                                        <input type="date" class="form-control" id="userBirthday" name="userBirthday" required data-minlength="3" value="<?=$_SESSION['user']['birthday']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
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
                                                   placeholder="Введите населённые пункт" value="<?=$_SESSION['user']['address']?>">
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" id="userCityDropdown"></ul>
                                        </div>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                </div>

                                <div class="col-xs-5  col-xs-offset-1">

                                    <h2>Мои контакты</h2>

                                    <div class="form-group has-feedback">
                                        <label for="userPhone">Мобильный телефон <span class="required">*</span></label>
                                        <input type="tel" class="form-control phone-checker" id="userPhone" name="userPhone" readonly required pattern="[\+]\d{2}[\s][\(]\d{3}[\)][\s]\d{3}[\-]\d{2}[\-]\d{2}" placeholder="+38 (___) ___-__-__" value="<?=$_SESSION['user']['phone']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="userEmail">Email <span class="required">*</span></label>
                                        <input type="email" class="form-control" id="userEmail" name="userEmail" readonly required value="<?=$_SESSION['user']['email']?>">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                </div>
                                
                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-alt">Сохранить</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="userChangePassword">
                        <form id="changePasswordForm" class="white" method="post" action="cart/changePassword" autocomplete="off">
                            <div class="blockquote hide form-errors"> </div>
                            <div class="blockquote hide form-success"> </div>
                            <div class="row">
                                <div class="col-xs-5">

                                    <h2>Смена пароля</h2>

                                    <div class="form-group has-feedback">
                                        <label for="userCurrentPassword">Текущий пароль<span class="required">*</span></label>
                                        <input type="password" class="form-control" id="userCurrentPassword" name="userCurrentPassword" required data-minlength="3">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="userNewPassword">Новый пароль <span class="required">*</span></label>
                                        <input type="password" class="form-control" id="userNewPassword" name="userNewPassword" required data-minlength="3">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label for="userRepeatPassword">Повторите новый пароль <span class="required">*</span></label>
                                        <input type="password" class="form-control" id="userNewPassword" name="userRepeatPassword" required data-minlength="3">
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                </div>

                                <div class="col-xs-12">
                                    <button type="submit" class="btn btn-alt">Сохранить</button>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div role="tabpanel" class="tab-pane  <?php if(!$orders) echo 'no-products'; ?>" id="userOrders">

                        <?php if($orders):  //debug($orders,1 );?>

                            <h2>Мои заказы</h2>

                            <div class="panel-group faq" id="delivery">

                                <?php foreach ($orders as $order_id => $order):

                                    $status = 'Новый';

                                    if($order[0]['status'] == 'new')
                                    {
                                        $status = 'Новый';
                                    }
                                    ?>
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <a data-toggle="collapse" data-parent="#delivery" href="#order-<?=$order_id?>" class="collapsed" aria-expanded="false">
                                                <span class="closed"><i>–</i></span>
                                                <span class="opened"><i>+</i></span>
                                                <div class="panel-title">
                                                    <span class="order-date"><?=date_point_format($order[0]['orderDate'])?></span>
                                                    <span>-</span>
                                                    <span>Заказ №<?=$order_id?> на сумму <?=$order[0]['orderSum'] + $order[0]['deliveryPrice']?> <?=$order[0]['currency']?></span>
                                                    <span class="order-status"><?=$status?></span>
                                                </div>
                                            </a>
                                        </div>
                                        <div id="order-<?=$order_id?>" class="panel-collapse collapse" aria-expanded="false" style="height: 0;">
                                            <div class="panel-body">

                                                <div class="table-responsive">
                                                    <h3>Состав заказа:</h3>
                                                    <table class="table table-bordered table-striped text-center">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col"> </th>
                                                            <th scope="col">Товар</th>
                                                            <th scope="col">Цена </th>
                                                            <th scope="col">Количество</th>
                                                            <th scope="col">Сумма</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php foreach ($order as $product): ?>
                                                        <tr>
                                                            <td>
                                                                <a href="product/<?=$product['alias']?>">
                                                                    <img class="orderImg" src="<?=PRODUCTIMG.$product['img']?>" alt="<?=$product['title']?>">
                                                                </a>
                                                            </td>
                                                            <td><a href="product/<?=$product['alias']?>"><?=$product['title']?></a> </td>
                                                            <td><?=$product['price']?> <?=$product['currency']?> </td>
                                                            <td><?=$product['qty']?></td>
                                                            <td><?=$product['price'] * $product['qty'];?> <?=$product['currency']?></td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                        </tbody>
                                                    </table>

                                                    <p class="orderTotal">Итого: <?=$order[0]["orderSum"]?> <?=$order[0]["currency"]?></p>

                                                    <h3>Способ доставки:</h3>
                                                    <p><?=$order[0]["deliveryMethod"]?> (+ <?=$order[0]['deliveryPrice']?> <?=$order[0]['currency']?>)<br>
                                                        <?=$order[0]["deliveryBranch"]?> <br>
                                                        <?=$order[0]["deliveryCity"]?></p>

                                                    <h3>Способ оплаты:</h3>
                                                    <p><?=$order[0]["paymentMethod"]?></p>

                                                    <?php if ($order[0]['note']): ?>
                                                        <h3>Комментарий:</h3>
                                                        <p><?=$order[0]['note']?></p>
                                                    <?php endif; ?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        <?php else: ?>

                            <div class="image-empty-category">
                                <img src="<?=PATH?>/images/empty-category.png" alt="">
                                <div class="text-empty-category-1"></div>
                                <div class="text-empty-category-2">Вы ещё не совершили ни одной покупки</div>
                            </div>
                        <?php endif; ?>

                    </div>

                    <div role="tabpanel" class="tab-pane" id="userFavourites"> </div>

                    <div role="tabpanel" class="tab-pane" id="userBonusCash">
                        <h2> На Вашем бонусном счёте <span>0</span> грн.</h2>

                        <div>
                            <p>На данный момент у Вас нет начислений на бонусный счёт </p>
                        </div>
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
                <!-- Tab panes -->
            </div>
        </div>
    </div>
</main>
<!-- /Page Content -->