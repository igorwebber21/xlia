<!DOCTYPE html>
<html lang="en">
<?php //session_unset ();
//debug($_SESSION); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=$this->getMeta();?>
    <meta name="author" content="BigSteps">
    <meta name="viewport" content="width=device-width, minimum-scale=1, maximum-scale=1">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- Vendor -->
    <base href="/">
    <link href="js/vendor/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="js/vendor/slick/slick.css" rel="stylesheet">
    <link href="js/vendor/swiper/swiper.min.css" rel="stylesheet">
    <link href="js/vendor/magnificpopup/dist/magnific-popup.css" rel="stylesheet">
    <link href="js/vendor/nouislider/nouislider.css" rel="stylesheet">
    <link href="js/vendor/darktooltip/dist/darktooltip.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/loaders.css" rel="stylesheet">
    <link href="css/typeahead.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom -->
    <link href="css/style.css" rel="stylesheet"><!--
	<link href="css/style-color-tomato.css" rel="stylesheet">  -->
    <link href="css/mystyles.css" rel="stylesheet">
    <link href="css/megamenu.css" rel="stylesheet">
    <link href="css/font-glyphicons.css" rel="stylesheet">

    <!-- Color Schemes -->
    <!-- your style-color.css here  -->

    <!-- Icon Font -->
    <link href="fonts/icomoon-reg/style.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Oswald:300,400,700|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i|Roboto:300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">

</head>

<body class="boxed"> <!--  open-panel -->
<!-- Loader -->
<div id="loader-wrapper" class="off">
    <div class="cube-wrapper">
        <div class="cube-folding">
            <span class="leaf1"></span>
            <span class="leaf2"></span>
            <span class="leaf3"></span>
            <span class="leaf4"></span>
        </div>
    </div>
</div>
<!-- /Loader -->
<div class="fixed-btns">
    <!-- Back To Top -->
    <a href="#" class="top-fixed-btn back-to-top"><i class="icon icon-arrow-up"></i></a>
    <!-- /Back To Top -->
</div>
<div id="wrapper">
    <!-- Page -->
    <div class="page-wrapper">
        <!-- Header -->
        <header class="page-header variant-2 fullboxed sticky smart">
            <div class="navbar">
                <div class="container">
                    <!-- Menu Toggle -->
                    <div class="menu-toggle"><a href="#" class="mobilemenu-toggle"><i class="icon icon-menu"></i></a></div>
                    <!-- /Menu Toggle -->
                    <!-- Header Cart -->
                    <div class="header-link dropdown-link header-cart variant-1" id="header-cart-block">
                        <?php  require APP . "/views/Cart/cart_header.php"; ?>
                    </div>
                    <!-- /Header Cart -->
                    <!-- Header Links -->
                    <div class="header-links">
                        <!-- Header Language -->
                        <div class="header-link header-select dropdown-link header-language">
                            <a href="#">RU</a>
                            <ul class="dropdown-container" id="currency">
                                <li class="active">
                                    <a href="#"><img src="images/flags/ru.png" alt />RU</a>
                                </li>
                                <li>
                                    <a href="#"><img src="images/flags/ua.png" alt />UA</a>
                                </li>
                                <li>
                                    <a href="#"><img src="images/flags/us.png" alt />EN</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /Header Language -->
                        <!-- Header Currency -->
                        <div class="header-link header-select dropdown-link header-currency">
                            <?php new \app\widgets\currency\Currency(); ?>
                        </div>
                        <!-- /Header Currency -->
                        <!-- Header Account -->
                        <div class="header-link dropdown-link header-account">
                            <?php if(isset($_SESSION['user']) && $_SESSION['user']): ?>
                                <a href="user/cabinet"><i class="icon icon-user user-active"></i></a>
                            <?php else: ?>
                                <a href="#modalUserAuth" data-toggle="modal"><i class="icon icon-user"></i></a>
                            <?php endif;?>
                        </div>
                        <!-- /Header Account -->
                    </div>
                    <!-- /Header Links -->
                    <!-- Header Search -->
                    <div class="header-link header-search header-search">
                        <div class="exp-search">
                            <form action="search" method="get" autocomplete="off">
                                <input name="s" id="typeahead"  class="exp-search-input typeahead" placeholder="Я ищу ..." type="text">
                                <input class="exp-search-submit" type="submit">
                                <span class="exp-icon-search"><i class="icon icon-magnify"></i></span>
                                <span class="exp-search-close"><i class="icon icon-close"></i></span>
                            </form>
                        </div>
                    </div>
                    <!-- /Header Search -->
                    <!-- Logo -->
                    <div class="header-logo">
                        <a href="/" title="Logo"><img src="images/ms-logo-1-1.png" alt="Logo" /></a>
                    </div>
                    <!-- /Logo -->
                    <!-- Mobile Menu -->
                    <div class="mobilemenu dblclick">
                        <div class="mobilemenu-header">
                            <div class="title">MENU</div>
                            <a href="#" class="mobilemenu-toggle"></a>
                        </div>
                        <div class="mobilemenu-content">
                            <ul class="nav">
                                <li><a href="/?v=category">Мужчинам</a></li>
                                <li><a href="category.html">Женчинам</a></li>
                                <li><a href="category.html">Детям</a></li>
                                <li><a href="category.html">Sale</a></li>
                                <li><a href="category.html">Новинки</a></li>
                                <li><a href="/blog">Блог</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <!-- Mega Menu -->
                    <div class="megamenu fadein blackout">
                        <ul class="nav">
                            <?php
                            new \app\widgets\menu\Menu([
                                'tpl' => WWW . '/menu/menu.php',
                                'default' => false,
                                'attrs' => [
                                    //'style' => 'border: 1px solid'
                                ]
                            ]);
                            ?>
                            <li><a href="category.html">Sale<span class="menu-label">-15%</span></a></li>
                            <li><a href="category.html">Новинки<span class="menu-label-alt">NEW</span></a></li>
                            <li><a href="/blog">Блог</li>
                        </ul>
                    </div>
                    <!-- /Mega Menu -->
                </div>
            </div>
        </header>
        <!-- /Header -->
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <div class="sidebar-top"><a href="#" class="slidepanel-toggle"><i class="icon icon-left-arrow-circular"></i></a></div>
            <ul class="sidebar-nav">
                <li> <a href="index.html">HOME</a> </li>
                <li> <a href="gallery.html">GALLERY</a> </li>
                <li> <a href="blog.html">BLOG</a> </li>
                <li> <a href="category-fixed-sidebar.html">SHOP</a> </li>
                <li> <a href="faq.html">FAQ</a> </li>
                <li> <a href="contact.html">CONTACT</a> </li>
            </ul>
            <div class="sidebar-bot">
                <div class="share-button toTop">
                    <span class="toggle"></span>
                    <ul class="social-list">
                        <li>
                            <a href="#" class="icon icon-google google"></a>
                        </li>
                        <li>
                            <a href="#" class="icon icon-fancy fancy"></a>
                        </li>
                        <li>
                            <a href="#" class="icon icon-pinterest pinterest"></a>
                        </li>
                        <li>
                            <a href="#" class="icon icon-twitter-logo twitter"></a>
                        </li>
                        <li>
                            <a href="#" class="icon icon-facebook-logo facebook"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Sidebar -->

        <?=$content;?>

        <!-- Footer -->
        <footer class="page-footer variant3 fullboxed">
            <div class="footer-top">
                <div class="container">
                    <!-- newsletter -->
                    <div class="newsletter variant2 row">
                        <div class="col-sm-3">
                            <a href="/" title="Logo"><img src="images/ms-logo-1-1.png" alt class="img-responsive" /></a>
                        </div>
                        <div class="col-sm-9">
                            <!-- input-group -->
                            <form action="#" id="subscribe-from">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="Подпишись на новости" required
                                    <?php if(isset($_SESSION['user']['email'])) echo 'value="'.$_SESSION['user']['email'].'"';?>>
                                    <span class="input-group-btn">
											<button class="btn btn-default" type="submit"><i class="icon icon-close-envelope"></i></button>
											</span>
                                </div>
                            </form>
                            <!-- /input-group -->
                        </div>
                    </div>
                    <!-- /newsletter -->
                </div>
            </div>
            <div class="page-footer fullboxed variant3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-lg-3">
                            <div class="footer-block collapsed-mobile">
                                <div class="title">
                                    <h4>Покупателям</h4>
                                    <div class="toggle-arrow"></div>
                                </div>
                                <div class="collapsed-content">
                                    <ul class="marker-list">
                                        <li><a href="?v=oplata-i-dostavka">Оплата и доставка</a></li>
                                        <li><a href="?v=faq">Вопросы и ответы</a></li>
                                        <li><a href="?v=vozvrat">Возврат</a></li>
                                        <li><a href="?v=contact">Контакты</a></li>
                                        <li><a href="?v=about">О нас</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3">
                            <div class="footer-block collapsed-mobile">
                                <div class="title">
                                    <h4>Личный кабинет</h4>
                                    <div class="toggle-arrow"></div>
                                </div>
                                <div class="collapsed-content">
                                    <ul class="marker-list">
                                        <li><a href="about.html">Регистрация</a></li>
                                        <li><a href="blog.html">История покупок</a></li>
                                        <li><a href="search.html">Мои данные</a></li>
                                        <li><a href="contact.html">Адрес доставки</a></li>
                                        <li><a href="faq.html">Избранное</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3">
                            <div class="footer-block collapsed-mobile">
                                <div class="title">
                                    <h4>Одежда</h4>
                                    <div class="toggle-arrow"></div>
                                </div>
                                <div class="collapsed-content">
                                    <ul class="marker-list">
                                        <li><a href="about.html">Мужчинам</a></li>
                                        <li><a href="faq.html">Женщинам</a></li>
                                        <li><a href="about.html">Детям</a></li>
                                        <li><a href="blog.html">Новинки</a></li>
                                        <li><a href="search.html">Sale</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-lg-3">
                            <div class="footer-block collapsed-mobile">
                                <div class="title">
                                    <h4>Контакты</h4>
                                    <div class="toggle-arrow"></div>
                                </div>
                                <div class="collapsed-content">
                                    <ul class="simple-list">
                                        <li><i class="icon icon-phone"></i>+38 (096) 666-66-66</li>
                                        <li><i class="icon icon-close-envelope"></i><a href="mailto:support@seiko.com">support@megashop.com</a></li>
                                        <li><i class="icon icon-clock"></i>8:00 - 19:00, Пн - Сб</li>
                                    </ul>
                                    <div class="footer-social">
                                        <a href="#"><i class="icon icon-facebook-logo icon-circled"></i></a> <a href="#"><i class="icon icon-twitter-logo icon-circled"></i></a> <a href="#"><i class="icon icon-skype-logo icon-circled"></i></a> <a href="#"><i class="icon icon-vimeo icon-circled"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="after-footer">
                    <div class="footer-copyright text-center"> © 2020-<?=date("Y")?>. Все права защищены </div>
                </div>
            </div>
        </footer>
        <!-- /Footer -->
        <a class="back-to-top back-to-top-mobile" href="#">
            <i class="icon icon-angle-up"></i> To Top
        </a>
    </div>
    <!-- Page Content -->
</div>

<!-- ProductStack -->
<div class="productStack hide_on_scroll <?php if(empty($_SESSION['cart'])) echo 'disable'; ?>" id="footer-cart-block">
    <?php  require APP . "/views/Cart/cart_footer.php"; ?>
</div>
<!-- /ProductStack -->

<!-- Modal Quick View -->
<div class="modal quick-view zoom" id="quickView">
    <div class="modal-dialog">
        <div class="modalLoader-wrapper">
            <div class="modalLoader bg-striped"></div>
        </div>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&#10006;</button>
        </div>
        <div class="modal-content">
            <iframe></iframe>
        </div>
    </div>
</div>
<!-- /Modal Quick View -->

<!-- Modal -->
<div class="modal fade zoom" id="clearCart">
    <div class="modal-dialog">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&#10006;</button>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <h3 class="title">Очистить корзину</h3>
                            <p>Вы уверены, что хотите удалить все товары из корзины?</p>
                            <div class="actions">
                                <div class="secondary">
                                    <a href="#" class="btn btn-alt" data-dismiss="modal">
                                        <span> Нет </span>
                                    </a>
                                </div>
                                <div class="primary">
                                    <a class="btn btn-alt cart-clear-confirm" href="#">
                                        <span>Да </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Modal -->


<!-- Modal -->
<?php if(!isset($_SESSION['user'])): ?>
<div class="modal fade zoom" id="modalUserAuth">
    <div class="modal-dialog modal-md">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">&#10006;</button>
        </div>
        <div class="modal-content"   id="authWrapp">

            <div class="modal-body">
                <div class="row" id="authRow">

                    <div class="col-lg-7 header-account leftBlock">
                        <div class="dropdown-container right" id="authBlock">

                            <div class="title">Личный кабинет</div>
                            <div class="top-text">Если у вас уже есть аккаунт, ввойдите в него</div>

                            <!-- form -->
                            <form action="user/login" id="authForm">
                                <div class="form-group has-feedback">
                                    <input type="email" class="form-control" id="userLogin" name="userLogin" placeholder="E-mail*" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Пароль*" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>

                                <button type="submit" class="btn">Войти</button>
                            </form>
                            <!-- /form -->

                            <div class="bottom-text"><a href="#" id="forgotPassword">Забыли пароль?</a></div>


                        </div>
                        <div class="dropdown-container right" id="forgotPasswordBlock" style="display: none">

                            <div class="title">Восстановление пароля</div>
                            <div class="top-text">Введите Ваш Email и мы отправим письмо для с инструкцией по восстановлению пароля </div>

                            <!-- form -->
                            <form action="user/passwordRecovery" id="forgotPasswordForm">
                                <div class="form-group has-feedback">
                                    <input type="email" class="form-control" id="emailRecovery" name="emailRecovery" placeholder="E-mail*" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <button type="submit" class="btn">Отправить</button>
                            </form>
                            <!-- /form -->

                            <div class="bottom-text"><a href="#" id="forgotPasswordBack">Войти на сайт</a></div>


                        </div>
                    </div>

                    <div class="col-lg-5 header-account rightBlock">
                        <div class="dropdown-container right">
                            <div class="top-text">Войдите с помощью Google или Facebook:</div>

                            <a href="#" class="btn btn-blue">
                                <i class="icon facebook icon-facebook-logo icon-circled"></i>
                                <span>Войти с Facebook</span>
                            </a>
                            <a href="#" class="btn">
                                <i class="icon icon-google icon-circled"></i>
                                <span>Войти с Google</span>
                            </a>

                            <div class="title">ИЛИ</div>
                            <div class="bottom-text"><a href="/user/signup">Создайте аккаунт</a></div>
                        </div>

                    </div>

                    <div class="col-xs-12 blockquote hide form-errors"></div>

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
    </div>
</div>
<?php endif; ?>
<!-- /Modal -->


<?php $curr = \ishop\App::$app->getProperty('currency');
$newPriceSliderStart = isset($_GET['minPrice']) && $_GET['minPrice'] > 0 ? $_GET['minPrice'] : '';
$newPriceSliderEnd = isset($_GET['maxPrice']) && $_GET['maxPrice'] > 0 ? $_GET['maxPrice'] : '';
?>
<script>
    var path = '<?=PATH?>',
        course = <?=$curr['value']?>,
        symbolLeft = '<?=$curr['symbol_left']?> ',
        symbolRight = ' <?=$curr['symbol_right']?>';
        newPriceSliderStart = ' <?=$newPriceSliderStart?>',
        newPriceSliderEnd = ' <?=$newPriceSliderEnd?>';
</script>

<!-- jQuery Scripts  -->
<script src="js/vendor/jquery/jquery.js"></script>
<script src="js/vendor/bootstrap/bootstrap.min.js"></script>
<script src="js/vendor/swiper/swiper.min.js"></script>
<script src="js/vendor/slick/slick.min.js"></script>
<script src="js/vendor/parallax/parallax.js"></script>
<script src="js/vendor/isotope/isotope.pkgd.min.js"></script>
<script src="js/vendor/magnificpopup/dist/jquery.magnific-popup.js"></script>
<script src="js/vendor/countdown/jquery.countdown.min.js"></script>
<script src="js/vendor/nouislider/nouislider.min.js"></script>
<script src="js/vendor/ez-plus/jquery.ez-plus.js"></script>
<script src="js/vendor/tocca/tocca.min.js"></script>
<script src="js/vendor/bootstrap-tabcollapse/bootstrap-tabcollapse.js"></script>
<script src="js/vendor/scrollLock/jquery-scrollLock.min.js"></script>
<script src="js/vendor/darktooltip/dist/jquery.darktooltip.js"></script>
<script src="js/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
<script src="js/vendor/instafeed/instafeed.min.js"></script>
<script src="js/share.js"></script>
<script src="js/validator.min.js"></script>
<script src="js/megamenu.min.js"></script>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/typeahead.bundle.js"></script>
<script src="js/app.js"></script>
<script src="js/myscripts.js"></script>


</body>

</html>