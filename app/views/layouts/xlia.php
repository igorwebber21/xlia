<?php //session_destroy(); ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>XLiA - модная среда обитания</title>
    <meta name="robots" content="all">
    <meta name="keywords" content="интернет магазин женской одежды, магазин женской одежды, женская одежда, магазин женской одежды киев, магазин женской одежды москва">
    <meta name="description" content="Интернет-магазин женской одежды XLiA. Стильная и модная женская одежда для девушек ❤ Доставка в любой уголок ✈ Планеты. Скидки постоянным клиентам✔">
    <meta property="og:locale" content="ru_RU">
    <meta property="og:site_name" content="Интернет магазин женской одежды - XLiA">
    <meta property="og:title" content="Главная">
    <meta property="og:url" content="https://lxlia.vip/">
    <meta property="og:description" content="Интернет магазин женской одежды - XLiA">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">

    <link href='/css/loaders.css?v=2.1' type='text/css' rel='stylesheet'>
    <link href='/css/styles.css?v=1.4' type='text/css' rel='stylesheet'>
    <link href='/css/mystyles.css?v=3.6' type='text/css' rel='stylesheet'>
    <script type='text/javascript' src='/js/globals.js'></script>
    <script type='text/javascript' src='/js/main.js'></script>

</head>
<?php // debug($_SESSION); ?>
<body class="<?php if($this->controller == 'Main') echo 'homepage'; ?> ru-RU" itemscope itemtype="https://schema.org/WebPage">
<script>
  // source file: /vendor/helpers/SVGCache.js
  !function(e, t) {
    "use strict";
    var n = "/fonts/svgdefs.svg"
      , o = 1617709184;
    if (!t.createElementNS || !t.createElementNS("http://www.w3.org/2000/svg", "svg").createSVGRect)
      return !0;
    var a, r, l = "localStorage"in e && null !== e.localStorage, i = function() {
      t.body.insertAdjacentHTML("afterbegin", r)
    }, s = function() {
      t.body ? i() : t.addEventListener("DOMContentLoaded", i)
    };
    if (l && localStorage.getItem("inlineSVGrev") == o && (r = localStorage.getItem("inlineSVGdata")))
      return s(),
        !0;
    try {
      a = new XMLHttpRequest,
        a.open("GET", n, !0),
        a.onload = function() {
          a.status >= 200 && a.status < 400 && (r = a.responseText,
            s(),
          l && (localStorage.setItem("inlineSVGdata", r),
            localStorage.setItem("inlineSVGrev", o)))
        }
        ,
        a.send()
    } catch (c) {}
  }(window, document);
</script>


<div class="session-messages" id="j-sm" style="display:none;"></div>

<div class="container">

    <div class="header">
        <div class="header__container">
            <div class="header__top">
                <div class="header__wrapper">
                    <div class="header__layout header__layout--top">
                        <div class="header__column header__column--left ">
                            <div class="header__section">
                                <nav class="site-menu">

                                    <span class="site-menu__item">
                                        <a class="site-menu__link" href="/">Главная</a>
                                    </span>

                                    <span class="site-menu__item">
                                        <a class="site-menu__link" href="?view=category">Каталог</a>
                                    </span>


                                    <?php if($pages): foreach ($pages as $page): ?>

                                    <span class="site-menu__item">
                                        <a class="site-menu__link" href="/<?=$page['alias']?>"><?=$page['title']?></a>
                                    </span>

                                    <?php endforeach; endif; ?>

                                </nav>
                                <script>
                                  $(function() {
                                    $('.site-menu').siteMenuDropdown({
                                      buttonText: "Еще",
                                      wrapper: '.header__column',
                                      siblings: '.header__section'
                                    })
                                  });
                                </script>
                            </div>
                        </div>
                        <div class="header__column header__column--right">
                            <div class="header__section">

                                <?php if(isset($_SESSION['user'])): ?>
                                  <span class="site-menu__item">
                                      <span><?=$_SESSION['user']['name'];?></span>
                                      <a href="/user/logout" class="material-icons outlined" title="Выйти из аккаунта">logout</a>
                                  </span>
                                <?php else: ?>
                                <span class="site-menu__item">
                                    <a class="site-menu__link" href="#" data-modal="#sign-in">
                                        Вход на сайт
                                    </a>
                                </span>
                                <?php endif;?>

                                <div class="social-icons">

                                    <a class="social-icons__item" data-fake-href="https://www.instagram.com/the_xlia/" rel="nofollow" target="_blank" title="Мы в инстаграмме">
                                        <svg class="social-icons__img icon-ig">
                                            <use xlink:href="#icon-ig"></use>
                                        </svg>
                                    </a>

                                    <a class="social-icons__item" data-fake-href="#" rel="nofollow" target="_blank" title="Мы в Telegram">
                                        <svg class="social-icons__img icon-tg">
                                            <use xlink:href="#icon-tg"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header__middle">
                <div class="header__wrapper">
                    <div class="header__layout header__layout--middle">
                        <div class="header__column header__column--left header__column--side">
                            <div class="header__section header__section--search">
                                <div class="search j-search">
                                    <form method="get" action="?view=search">
                                        <button type="submit" class="search__button" disabled>
                                            <svg class="icon icon--search">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-search"></use>
                                            </svg>
                                        </button>
                                        <input class="search__input" id="f552bddb4c9a90c2f284810aeb048dc7" type="text" name="q" placeholder="поиск товаров" autocomplete="off" value="">
                                    </form>
                                </div>
                                <div class="search__results" id="f552bddb4c9a90c2f284810aeb048dc7-search-results"></div>
                            </div>
                        </div>
                        <div class="header__column header__column--center">
                            <div class="header__section">
                                <div class="header__logo header__logo--fixed">
                                    <a href="/">
                                        <img class='header-logo-img' src='/images/logo.png'>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="header__column header__column--right header__column--side">
                            <div class="header__section header__section--contacts">
                                <div class="phones phones--header phones--column phones--n1">
                                    <div class="phones__list ">
                                        <div class="phones__item">
                                            <svg class="icon icon--ks">
                                                <use xlink:href="#icon-ks"></use>
                                            </svg>
                                            <a href="tel:+380685231066" class="phones__item-link j-phone-item" data-index="1">
                                                068  523-10-66
                                            </a>
                                        </div>
                                    </div>
                                    <div class="phones__callback">
                                        <a class="phones__callback-link" href="#" data-modal="#call-me">Перезвонить вам?</a>
                                    </div>
                                </div>
                                <section id="call-me" class="popup __password" style="display: none;">
                                    <div class="popup-block login">
                                        <a onclick="Modal.close();" href="javascript:;" class="popup-close material-icons">close</a>
                                        <div class="popup-header">
                                            <div class="popup-title">Перезвонить вам?</div>
                                        </div>
                                        <div class="popup-body j-text">
                                            <div class="popup-msg j-callback-message">
                                                Укажите ваш номер телефона и имя. Мы свяжемся с вами в ближайшее время. Или звоните по номеру
                                                <a href="tel:+380685231066">
                                                    <strong>068  523-10-66</strong>
                                                </a>
                                            </div>
                                            <form method="post" action="/user/recall" id="recallForm">
                                                <dl class="form">
                                                    <dt class="form-head">Имя</dt>
                                                    <dd class="form-item">
                                                        <input type="text" class="field j-focus" name="recallName" required>
                                                    </dd>
                                                    <dt class="form-head">Телефон</dt>
                                                    <dd class="form-item">
                                                        <input placeholder="+38 (___) ___-__-__" type="text" class="field phone-checker" name="recallPhone" required>
                                                    </dd>
                                                    <dd class="form-item __submit">
                                                        <span class="btn __special">
                                                            <span class="btn-content">Отправить</span>
                                                            <input type="submit" value="Отправить" class="btn-input">
                                                        </span>
                                                    </dd>
                                                </dl>
                                            </form>

                                            <div class="col-xs-12 blockquote hide form-errors text-center"></div>

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
                            <div class="header__section">
                                <div class="basket" data-widget="mini_cart" data-skin="header" data-icon="bag" data-elements="all">
                                    <a class="basket__link" href="#" onclick="showModal('__cart')" id="cartHeader">
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
                                    </a>

                                    <input type="hidden" id="cartItemsCount" value="<?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>">
                                    <input type="hidden" id="pageController" value="<?php echo $this->controller; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="header__bottom">
                <div class="header__wrapper">
                    <div class="header__layout header__layout--bottom">
                        <div class="header__column header__column--center ">
                            <div class="header__section header__section--catalog-menu">
                                <div class="products-menu j-products-menu">
                                    <ul class="products-menu__container">

                                        <?php foreach ($categories as $category): ?>
                                        <li class="products-menu__item j-submenu-item">
                                            <div class="products-menu__title">
                                                <a class="products-menu__title-link" href="/category/<?=$category['alias']?>"><?=$category['title']?></a>
                                            </div>
                                        </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="header-mobile">

        <header class="nav-top">

            <span class="left">
                <span class="hamburger material-icons" id="ham">
                    menu
                </span>
                 <span class="material-icons" id="searchMobile">
                    search
                </span>
            </span>

            <a href="/" class="mobile-logo">
                <img class='header-logo-img' src='/images/logo.png'>
            </a>


            <span class="right">

                    <span class="material-icons" id="recallMobile"  href="#" data-modal="#call-me">
                        phone
                    </span>

                    <span class="material-icons" id="cartMobile" onclick="showModal('__cart')">shopping_basket</span>

                    <span id="cartMobileCount"><?php echo isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] : 0?></span>


             </span>

        </header>

        <nav class="nav-drill">
            <ul class="nav-items nav-level-1">
                <li class="nav-item">
                    <a class="nav-link nav-back-link nav-slogan">
                        XLiA - модная среда обитания
                        <span class="hamburger material-icons" id="closeMenu">close</span>
                    </a>
                </li>
                <li class="nav-item nav-expand">
                    <a class="nav-link nav-expand-link" href="#">
                        Каталог
                    </a>
                    <ul class="nav-items nav-expand-content">

                      <?php if($categories): foreach ($categories as $category): ?>
                          <li class="nav-item">
                              <a class="nav-link" href="/category/<?=$category['alias']?>">
                                <?=$category['title']?>
                              </a>
                          </li>
                      <?php endforeach; endif; ?>

                    </ul>
                </li>

              <?php if($pages): foreach ($pages as $page): ?>

                  <li class="nav-item">
                      <a class="nav-link" href="/<?=$page['alias']?>">
                        <?=$page['title']?>
                      </a>
                  </li>

              <?php endforeach; endif; ?>


                  <?php if(isset($_SESSION['user'])): ?>
                      <li class="nav-item account-mobile">
                          <a class="nav-link" href="#">
                              <span><?=$_SESSION['user']['name'];?></span>
                          </a>

                          <a href="/user/logout" class="material-icons outlined" title="Выйти из аккаунта" style="">logout</a>

                      </li>
                  <?php else: ?>
                      <li class="nav-item">
                          <a class="nav-link" href="#" data-modal="#sign-in">
                              Вход на сайт
                          </a>
                      </li>
                  <?php endif;?>

                <li class="nav-item">

                    <span class="mobile-contacts-li">

                         <span class="mobile-contacts-item social-icons mobile-title">
                            Обратная связь:
                        </span>

                        <span class="mobile-contacts-item">
                            <svg class="icon icon--email icon-mobile">
                                <use xlink:href="#icon-email"></use>
                            </svg>
                            <a href="mailto:xlia@gmail.com" class="footer__link">xlia@gmail.com</a>
                        </span>

                        <span class="mobile-contacts-item">
                            <svg class="icon icon--phone icon-mobile">
                                 <use xlink:href="#icon-phone"></use>
                            </svg>

                            <a href="tel:+380685231066" class="footer__contacts-item-link j-phone-item" data-index="1">
                                068  523-10-66
                            </a>
                        </span>

                        <span class="mobile-contacts-item">
                            <a class="footer__link mobile-recall" href="#" data-modal="#call-me">Перезвонить вам?</a>
                        </span>

                        <span class="mobile-contacts-item social-icons mobile-title mt-big">
                            Подписаться на XLiA:
                        </span>

                        <span class="mobile-contacts-item social-icons">



                                    <a class="social-icons__item" rel="nofollow" target="_blank" title="Мы в инстаграмме" href="https://www.instagram.com/the_xlia/">
                                        <img src="/images/instagram.jpg" alt="instagram">
                                    </a>

                                    <a class="social-icons__item" rel="nofollow" target="_blank" title="Мы в Telegram" href="#">
                                         <img src="/images/telegram.jpg" alt="telegram">
                                    </a>
                        </span>

                    </span>

                </li>

            </ul>
        </nav>

    </div>


    <div class="search-mobile">
        <form action="?view=search" method="get">

            <button class="btn-search" type="submit">
                <span class="material-icons"> search   </span>
            </button>

            <input type="text" class="search__input" placeholder="Введите имя товара" name="q"  autocomplete="off" value="">
        </form>
    </div>





    <?=$content;?>





    <footer class="footer">
        <div class="footer__container">
            <div class="footer__wrapper wrapper">
                <div class="footer__columns">
                    <div class="footer__col footer__col--double footer__col--logo">
                        <div class="footer__col-wrap">
                            <div class="footer__logo">
                                <a href="/">
                                    <img class='footer__logo-img' src='/images/logo.png'>
                                </a>
                            </div>
                            <div class="footer__copyright">
                                <span class="shopName">XLiA</span>
                                <span class="shopTitle">модная среда обитания</span>
                            </div>
                        </div>
                    </div>
                    <div class="footer__col footer__col--clients">
                        <div class="footer__col-wrap">
                            <div class="footer__block">
                                <div class="footer__heading">Клиентам</div>
                                <ul class="footer__menu">
                                    <?php if(isset($_SESSION['user'])): ?>
                                        <li class="footer__menu-item accountItem">
                                            <span><?=$_SESSION['user']['name'];?></span>
                                            <a href="/user/logout" class="material-icons outlined" title="Выйти из аккаунта">logout</a>
                                        </li>
                                    <?php else: ?>
                                    <li class="footer__menu-item "><a href="#" class="footer__link" data-modal="#sign-in">Вход в личный кабинет</a></li>
                                    <?php endif;?>
                                    <li class="footer__menu-item ">
                                        <a href="?view=category" class="footer__link">Каталог</a>
                                    </li>

                                  <?php if($pages): foreach ($pages as $page): ?>

                                      <li class="footer__menu-item ">
                                          <a href="/<?=$page['alias']?>" class="footer__link"><?=$page['title']?></a>
                                      </li>

                                  <?php endforeach; endif; ?>

                                </ul>
                            </div>
                            <div class="footer__block">
                                Мы в соцсетях
                                <div class="footer__social">
                                    <a class="footer__social-icon" data-fake-href="https://www.instagram.com/the_xlia/" rel="nofollow" target="_blank" title="Мы в инстаграмме">
                                        <svg class="icon-ig">
                                            <use xlink:href="#icon-ig"></use>
                                        </svg>
                                    </a>
                                    <a class="footer__social-icon" data-fake-href="#" rel="nofollow" target="_blank" title="Мы в Telegram">
                                        <svg class="icon-tg">
                                            <use xlink:href="#icon-tg"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer__col footer__col--catalog">
                        <div class="footer__col-wrap">
                            <div class="footer__block">
                                <div class="footer__heading">Каталог</div>
                                <ul class="footer__menu">

                                  <?php if($categories): foreach ($categories as $category): ?>
                                      <li class="footer__menu-item ">
                                          <a href="/category/<?=$category['alias']?>" class="footer__link"><?=$category['title']?> </a>
                                      </li>
                                  <?php endforeach; endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="footer__col footer__col--contacts">
                        <div class="footer__col-wrap">
                            <div class="footer__heading">Контактная информация</div>
                            <div class="footer__contacts footer__contacts--columns">
                                <div class="footer__contacts-group">
                                    <svg class="icon icon--phone">
                                        <use xlink:href="#icon-phone"></use>
                                    </svg>
                                    <div class="footer__contacts-item">
                                        <a href="tel:+380685231066" class="footer__contacts-item-link j-phone-item" data-index="1">
                                            068  523-10-66
                                        </a>
                                    </div>
                                    <a class="footer__link" href="#" data-modal="#call-me">Перезвонить вам?</a>
                                </div>
                                <div class="footer__contacts-group">
                                    <div class="footer__contacts-item">
                                        <svg class="icon icon--email">
                                            <use xlink:href="#icon-email"></use>
                                        </svg>
                                        <a href="mailto:xlia@gmail.com" class="footer__link">xlia@gmail.com</a>
                                    </div>
                                </div>
                                <div class="footer__contacts-group">
                                    <svg class="icon icon--location">
                                        <use xlink:href="#icon-location"></use>
                                    </svg>
                                    <div class="footer__address">Одесса тел: +38 (068) 523 10 66</div>
                                    <a class="footer__link" href="?view=contacts">Карта проезда</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="footer__mobile-menu hamburger">
                        Меню
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <div class="upButton" id="upButton">
        <a class="upButton-btn" href="#">
            <span class="upButton-btn__hint">Наверх</span>
        </a>
    </div>

</div><!-- .container -->

<div class="ft-bottom">
    © 2014—<?=date('Y');?> Интернет магазин женской одежды - xlia.vip
</div>




<section id="sign-in" class="popup __login" style="display: none;">

    <div class="popup-block login">

        <a onclick="Modal.close();" href="javascript:" class="popup-close material-icons">close</a>

        <div class="login-wrapp">

            <div class="login-header">
                <div class="login-tabs j-auth-tabs">
                    <a href="#j-popup-tab-auth" class="login-tabs-i __active">
                        <span class="login-tabs-txt">Вход</span>
                    </a>
                    <a href="#j-popup-tab-signup" class="login-tabs-i">
                        <span class="login-tabs-txt">Регистрация</span>
                    </a>
                </div>
            </div>
            <div class="login-body">
                <div class="login-tabs-content" id="j-popup-tab-auth">
                    <form method="post" id="userLogin" action="/user/login">
                        <div class="j-login-info-message"></div>
                        <dl class="form">
                            <dt class="form-head">Эл. почта</dt>
                            <dd class="form-item">
                                <input type="email" name="userLogin" id="userLogin" class="field j-focus" required>
                            </dd>
                            <dt class="form-head">Пароль</dt>
                            <dd class="form-item">
                                <input type="password" name="userPassword" id="userPassword" class="field" required>
                            </dd>
                            <dd class="form-item __submit">
                                    <span class="btn __special">
                                        <span class="btn-content">Войти</span>
                                        <input type="submit" value="Войти" class="btn-input" tabindex="3">
                                    </span>
                                <span class="form-passRecover">
                                        <a href="javascript:void(0);" data-modal="#password-recovery">Забыли пароль?</a>
                            </span>
                            </dd>
                        </dl>
                    </form>
                </div>
                <div class="login-tabs-content" id="j-popup-tab-signup">
                    <form method="post" id="userRegister" action=".user/signup">
                        <div class="j-signup-info-message"></div>
                        <dl class="form">
                            <dt class="form-head __name">Имя и фамилия</dt>
                            <dd class="form-item">
                                <input type="text" name="userName" class="field" value="" required>
                            </dd>
                            <dt class="form-head">Эл. почта</dt>
                            <dd class="form-item">
                                <input type="email" name="userEmail" class="field" value="" required>
                            </dd>
                            <dt class="form-head">Телефон</dt>
                            <dd class="form-item">
                                <input placeholder="+38 (___) ___-__-__" type="text" name="userPhone" class="field phone-checker" value="" required>
                            </dd>
                            <dt class="form-head">Пароль</dt>
                            <dd class="form-item">
                                <input type="password" name="userPassword" class="field" value="" required>
                            </dd>

                            <dd class="form-item __submit">
                                    <span class="btn __special">
                                        <span class="btn-content">Зарегистрироваться</span>
                                        <input type="submit" value="Зарегистрироваться" class="btn-input" tabindex="7">
                                    </span>
                            </dd>
                        </dl>
                    </form>
                </div>
            </div>

            <div class="col-xs-12 blockquote hide form-errors text-center"></div>

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
    <script type="text/javascript">
      $('#sign-in').find('.j-auth-tabs a').TMTabs({
        onChange: function(a, rel) {
          var containers = this.data('TMTabs-containers');
          containers.find('.popup-msg').empty();
          containers.find('form').reset();
          rel.find(':input').errorBox().filter(':first').focus();
        }
      });
    </script>
</section>

<section id="password-recovery" class="popup __password" style="display: none;">
    <div class="popup-block login">
        <a onclick="Modal.close();" href="javascript:" class="popup-close material-icons">close</a>
        <div class="popup-header">
            <div class="popup-title">Восстановление пароля</div>
        </div>
        <div class="popup-body">
            <div class="popup-msg j-recovery-message">Введите адрес электронной почты, который вы указывали при регистрации.
                Мы отправим письмо с информацией для восстановления пароля.                </div>
            <form id="passwordRecoveryForm" method="post" action="/user/passwordRecovery">
                <dl class="form">
                    <dt class="form-head">Эл. почта</dt>
                    <dd class="form-item">
                        <input type="email" class="field j-focus" name="emailRecovery" required>
                    </dd>
                    <dd class="form-item __submit">
                        <span class="btn __special">
                            <span class="btn-content">Восстановить</span>
                            <input type="submit" value="Восстановить" class="btn-input">
                        </span>
                    </dd>
                </dl>
            </form>

            <div class="col-xs-12 blockquote hide form-errors text-center"></div>

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


<script type='text/javascript' src='/js/libraries.js'></script>

<div id="modal-overlay" class="overlay">

    <section class="popup __cart" id="fddd8a5ee53f71d577d4ddd8ca29510f" style="display: none;">
        <div class="popup-block">
            <a class="popup-close material-icons" onclick="closeModal($(this)); return false;">close</a>
            <div class="popup-title">Корзина</div>
            <div class="cart">
                <div class="cart-content" id="modalCartContent">
                    <?php if(isset($_SESSION['cart']) && $_SESSION['cart']): ?>
                    <table class="cart-items">
                        <thead>
                        <tr>
                            <td></td>
                            <td></td>
                            <td class="cart-header">
                                <div class="cart-header-b">
                                    <span class="cart-header-content">Количество</span>
                                </div>
                            </td>
                            <td class="cart-header __cost">
                                <div class="cart-header-b">
                                    <span class="cart-header-content">Стоимость</span>
                                </div>
                            </td>
                        </tr>
                        </thead>
                        <tbody class="cart-section">
                        <?php foreach ($_SESSION['cart'] as $prodId => $item): ?>
                        <tr class="j-cart-product j-remove-container" id="prodCartModal-<?=$prodId?>">
                            <td class="cart-cell __image">
                                <div class="cart-remove">
                                    <a class="cart-remove-btn j-remove-p cart-remove-action" href="#" prod-id="<?=$prodId?>">
                                        <i class="icon-cart-remove"></i>
                                    </a>
                                </div>
                                <div class="cart-image">
                                    <a href="/product/<?=$item['alias']?>">
                                        <img width='63' height='78' alt="<?=$item['title']?>" src='<?=UPLOAD_PRODUCT_BASE.$item['img']?>' />
                                    </a>
                                </div>
                            </td>
                            <td class="cart-cell __details">
                                <div class="cart-title">
                                    <a href="/product/<?=$item['alias']?>"><?=$item['title']?> </a>
                                </div>
                                <div class="cart-price"><?=$item['price']?> грн        </div>
                            </td>
                            <td class="cart-cell __quantity">
                                <div class="cart-quantity">
                                    <div class="counter counter--large">
                                        <div class="counter__container">
                                            <button class="counter-btn __minus __disabled j-decrease-p" data-prod="<?=$prodId?>">
                                                <span class="icon-minus"></span>
                                            </button>
                                            <div class="counter-input">
                                                <input class="counter-field j-quantity-p" type="text" value="<?=$item['qty']?>" data-step="1" data-min="1" data-max="9223372036854775807" />
                                            </div>
                                            <button class="counter-btn __plus j-increase-p" data-prod="<?=$prodId?>">
                                                <span class="icon-plus"></span>
                                            </button>
                                        </div>
                                        <div class="counter__units"></div>
                                        <div class="counter-message j-quantity-reached-message">Больше нет в наличии</div>
                                    </div>
                                </div>
                            </td>
                            <td class="cart-cell __cost">
                                <div class="cart-cost j-sum-p"><?=$item['price'] * $item['qty']?> грн</div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tr class="j-cart-loader" style="display: none;">
                            <td class="cart-cell __details" colspan="4">
                                <div class="loader" style="position: relative;margin: 0 auto;"></div>
                            </td>
                        </tr>
                        <tfoot class="cart-foot">

                        <tr>
                            <td class="cart-footer" colspan="4">
                                <div class="cart-summary">
                                    <div class="cart-footer-h">Итого</div>
                                    <div class="cart-footer-b cart-cost j-total-sum"><?=$_SESSION['cart.sum']?> грн</div>
                                </div>
                                <div class="cart-buttons">
                                    <div class="cart-btnBack">
                                        <a class="a-btn" href="javascript:void(0);" onclick="closeModal(); return false;">
                                            <i class="icon-arrow-left2"></i>
                                            <span class="a-pseudo">Вернуться к покупкам</span>
                                        </a>
                                    </div>
                                    <div class="cart-btnOrder">
                                        <a class="btn __special" rel="nofollow" href="/cart/view">
                                            <span class="btn-content">Оформить заказ</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                    <?php else: ?>
                        <h3 class="empty-cart-title">Корзина пуста</h3>
                    <?php endif;?>
                </div>
                <div class="j-cart-additional"></div>
            </div>
        </div>
    </section>

    <section id="product-try-on" class="popup __productTryOn" style="display: none;">
        <div class="popup-block login">
            <a onclick="closeModal($(this));" href="javascript:" class="popup-close material-icons">close</a>
            <div class="login-header">
                <div class="popup-title">Примерить товар</div>
                <div class="popup-text">Уважаемый покупатель, если Вы из города Одессы, то Вы можете записаться на примерку товара
                    "<span id="productNameTryOn">Платье Джесика</span>".
                    Просто заполните форму ниже, указав удобный для Вас район города. Наш менеджер свяжется с Вами и согласует время и место примерки.</div>
            </div>
            <div class="try-on-body">
                <form method="post" id="try-on-form" action="/user/tryOn/">
                    <div class="j-signup-info-message"></div>
                    <dl class="form">
                        <dt class="form-head __name">Имя</dt>
                        <dd class="form-item">
                            <input type="text" name="userName" class="field" value="<?php if(isset($_SESSION['user']['name'])) echo $_SESSION['user']['name'];?>" tabindex="1">
                        </dd>
                        <dt class="form-head">Телефон</dt>
                        <dd class="form-item">
                            <input placeholder="+38 (___) ___-__-__" type="text" class="field phone-checker" name="userPhone" value="<?php if(isset($_SESSION['user']['phone'])) echo $_SESSION['user']['phone'];?>" tabindex="2">
                        </dd>
                        <dt class="form-head">Район</dt>
                        <dd class="form-item">
                            <select class="select j-ignore j-delivery-type" name="userState" id="userState">
                                <option value="Приморский" selected>Приморский</option>
                                <option value="Малиновский">Малиновский</option>
                                <option value="Суворовский">Суворовский</option>
                                <option value="Киевский">Киевский</option>
                            </select>
                        </dd>
                        <dd class="form-item __submit">
                                    <span class="btn __special btn-try-on-block">
                                        <span class="btn-content">Записаться на примерку</span>

                                        <?php if(isset($product['id'])): ?>
                                        <input type="hidden" name="productId" value="<?php  echo $product['id'];?>">
                                        <?php endif; ?>

                                        <input type="submit" value="Записаться" class="btn-input btn-try-on" tabindex="7">
                                    </span>
                        </dd>
                    </dl>
                </form>

                <div class="col-xs-12 blockquote hide form-errors text-center"></div>

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




<script type='text/javascript' src='/js/mjquery.maskedinput.min.js'></script>
<script type='text/javascript' src='/js/myscripts.js?v=11.1'></script>





</body>
</html>







