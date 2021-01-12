<!-- Page Content -->
<main class="page-main">
    <div class="block">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="<?=PATH?>"><i class="icon icon-home"></i></a></li>
                <li> <span> / </span> </li>
                <li> <span>Регистрация</span> </li>
            </ul>
        </div>
    </div>
    <div class="block">
        <div class="container">
            <div class="form-card" id="registrationWrapp">

                <h3>Регистрация</h3>

                <div class="blockquote hide form-errors"></div>

                <form id="registrationForm" class="account-create" action="#" autocomplete="off">

                    <div class="row">

                        <div class="col-xs-6">

                            <h2>Личные данные</h2>

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

                        </div>

                        <div class="col-xs-6">
                            <h2>Данные авторизации</h2>

                            <div class="form-group has-feedback">
                                <label for="userEmail">Email <span class="required">*</span></label>
                                <input type="email" class="form-control" id="userEmail" name="userEmail" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="userPassword">Пароль <span class="required">*</span></label>
                                <input type="password" class="form-control" id="userPassword" name="userPassword" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                            <div class="form-group has-feedback">
                                <label for="userPasswordRepeat">Повторите пароль <span class="required">*</span></label>
                                <input type="password" class="form-control" id="userPasswordRepeat" name="userPasswordRepeat" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>

                        </div>

                    </div>

                    <button type="submit" class="btn btn-lg">Создать аккаунт</button>
                    <span class="required-text">* Обязательные поля</span>

                </form>

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

            </div>
        </div>
    </div>
</main>
<!-- /Page Content -->