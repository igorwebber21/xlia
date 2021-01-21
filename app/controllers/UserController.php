<?php


    namespace app\controllers;


    use app\models\User;
    use RedBeanPHP\R;

    class UserController extends AppController
    {
        // Регистрация
        public function signupAction()
        {

            if(!empty($_POST))
            {
                $user = new User();
                $user->rules['required'][] = ['password'];
                $user->attributes['password'] = $_POST['userPassword'] ? $_POST['userPassword'] : '';
                $generatedPassword = $user->attributes['password'];

                if(!$user->attributes['password'] || $user->attributes['password'] != $_POST['userPasswordRepeat'])
                {
                    $this->responseData["message"] = '<p>Ошибка! Введенные Вами пароли не совпадают</p>';
                    self::sendResponse($this->responseData);
                }

                $user->attributes['email'] = $_POST['userEmail'];
                $user->attributes['phone'] = $_POST['userPhone'];
                $user->attributes['fname'] = $_POST['userName'];
                $user->attributes['lname'] = $_POST['userLastName'];
                $user->attributes['address'] = $_POST['userCity'];

               if(!$user->validate($user->attributes) || !$user->checkUnique())
               {
                   $this->responseData['message'] = $user->getErrors();
               }
               else
               {
                   $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                   $user->attributes['ip_address'] = getUserIP();
                   $user->attributes['ip_location'] = getUserLocation($user->attributes['ip_address']);

                   if ($user->save('user'))
                   {
                       //если зарегистрировали - отправляем Email с данными для входа
                       $user::sendEmailPassword($generatedPassword, $user->attributes);
                       $this->responseData['status'] = 1;
                       $this->responseData['message'] = '<p>Вы успешно зарегистрированы</p>';
                   }
                   else
                   {
                       $this->responseData['message'] = '<p>Ошибка, не удалось зарегистрироваться. Попробуйте ещё раз</p>';
                   }
               }

                self::sendResponse($this->responseData);
            }

            $this->setMeta('Регистрация');
        }

        // Авторизация
        public function loginAction()
        {
            if($_POST['userLogin'] && $_POST['userPassword'])
            {
                $user = new User();
                $userData['login'] = $_POST['userLogin'];
                $userData['password'] =  $_POST['userPassword'];

                if($user->login($userData))
                {
                    $this->responseData['status'] = 1;
                    $this->responseData['message'] = 'Вы успешно авторизованы';
                }
                else
                {
                    $this->responseData['message'] = 'Логин/пароль введены неверно';
                }

                self::sendResponse($this->responseData);
            }

            $this->setMeta('Вход');
        }

        // Выход с аккаунта
        public function logoutAction()
        {
            if(isset($_SESSION['user'])) unset($_SESSION['user']);
            redirect(PATH);
        }

        // Страница Личного Кабинета
        public function cabinetAction()
        {
            if(!User::checkAuth()) redirect();

            $this->setMeta('Личный кабинет');

            $ordersArr = R::getAll("SELECT `orders`.`note`, `orders`.`sum` AS orderSum, `orders`.`date` AS orderDate, 
                                                `orders`.`status`, `orders`.`id` AS orderId, 
                                                 IF(`currency`.`symbol_left`, `currency`.`symbol_left`, `currency`.`symbol_right`) AS currency,
                                                `order_product`.`title`, `order_product`.`price`, `order_product`.`qty`,
                                                `product`.`alias`, `product`.`img`,
                                                `user_delivery`.`delivery_city` AS deliveryCity, `user_delivery`.`delivery_branch` AS deliveryBranch,
                                                `delivery_methods`.`title` AS deliveryMethod, `delivery_methods`.`price` AS deliveryPrice,
                                                 `payment_methods`.`title` AS paymentMethod
                                        FROM `orders`
                                        LEFT JOIN `order_product` ON `order_product`.`order_id` = `orders`.`id`
                                        LEFT JOIN `product` ON `order_product`.`product_id` = `product`.`id`
                                        LEFT JOIN `user_delivery` ON `user_delivery`.`order_id` = `orders`.`id`
                                        LEFT JOIN `delivery_methods` ON `delivery_methods`.`id` = `user_delivery`.`delivery_method`
                                        LEFT JOIN `payment_methods` ON `payment_methods`.`id` = `user_delivery`.`payment_method`
                                        LEFT JOIN `currency` ON `currency`.`code` = `orders`.`currency`
                                        WHERE `orders`.`user_id` = ? ORDER BY `orders`.`id` DESC", [$_SESSION['user']['id']]);

            $orders = [];

            if($ordersArr)
            {
                foreach ($ordersArr as $order)
                {
                    $orders[$order['orderId']][] = $order;
                }
            }

            $this->set(compact('orders'));
        }

        //========== user cabinet  ==========//
        public function editAction()
        {
            if(!User::checkAuth())
            {
                $this->responseData['message'] = 'Пожалуйста, авторизуйтесь на сайте';
                self::sendResponse($this->responseData);
            }

            if(!empty($_POST))
            {

                $user = new \app\models\admin\User();
                $user->attributes['fname'] = $_POST['userName'];
                $user->attributes['lname'] = $_POST['userLastName'];
                $user->attributes['birthday'] = $_POST['userBirthday'];
                $user->attributes['address'] = $_POST['userCity'];
                $user->attributes['phone'] = $_POST['userPhone'];
                $user->attributes['email'] = $_POST['userEmail'];
                $user->attributes['id'] = $_SESSION['user']['id'];
                $user->attributes['role'] = $_SESSION['user']['role'];

                if(!$user->attributes['password']){
                    unset($user->attributes['password']);
                }else{
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                }

                if(!$user->validate($user->attributes) || !$user->checkUnique())
                {
                    $this->responseData['message'] = $user->getErrors();
                    self::sendResponse($this->responseData);
                }

                // обновляем данные о пользователе
                if($user->update('user', $_SESSION['user']['id']))
                {
                    foreach($user->attributes as $k => $v)
                    {
                        if($k != 'password') $_SESSION['user'][$k] = $v;
                    }

                    $this->responseData['status'] = 1;
                    $this->responseData['message'] = 'Изменения сохранены';
                }
                else{
                    $this->responseData['message'] = 'Не удалось сохранить. Попробуйте ещё раз';
                }

                self::sendResponse($this->responseData);

            }

            $this->setMeta('Изменение личных данных');
        }

        // смена пароля
        public function changePasswordAction()
        {
            if(!User::checkAuth())
            {
                $this->responseData['message'] = 'Пожалуйста, авторизуйтесь на сайте';
                self::sendResponse($this->responseData);
            }

            if(!empty($_POST) && isset($_POST['userCurrentPassword']))
            {
              //  debug($_POST,1 );

                $userNewPassword = h($_POST['userNewPassword']);
                $userRepeatPassword = h($_POST['userRepeatPassword']);
                $userCurrentPassword = h($_POST['userCurrentPassword']);

                if($userNewPassword != $userRepeatPassword)
                {
                    $this->responseData['message'] = 'Новые пароли не совпадают';
                    self::sendResponse($this->responseData);
                }

                if($userNewPassword == $userCurrentPassword)
                {
                    $this->responseData['message'] = 'Новый пароль должен быть отличен от старого';
                    self::sendResponse($this->responseData);
                }

                $user = new \app\models\admin\User();
                $user->attributes['id'] = $_SESSION['user']['id'];
                $user->attributes['password'] = $userCurrentPassword;

                if(!$user->checkUserAuth())
                {
                    $this->responseData['message'] = 'Старый пароль введён не верно';
                    self::sendResponse($this->responseData);
                }

                $user->attributes['password'] = password_hash($userNewPassword, PASSWORD_DEFAULT);

                if($user->updateUserPassword()){
                    $this->responseData['message'] = 'Пароль успешно изменён';
                    $this->responseData['status'] = 1;
                    self::sendResponse($this->responseData);
                }

            }

        }

        // восстановление пароля
        public function passwordRecoveryAction()
        {
            if(!empty($_POST) && isset($_POST['emailRecovery']))
            {
                 $email = h($_POST['emailRecovery']);
                 $user = new \app\models\admin\User();

                 if($userData = $user->getUserData($email))
                 {
                     $generatedPassword = $user::generatePassword();

                     $user->attributes['password'] = password_hash($generatedPassword, PASSWORD_DEFAULT);
                     $user->attributes['id'] = $userData['id'];

                     if($user->updateUserPassword())
                     {
                         $user::sendEmailPassword($generatedPassword, $userData);

                         $this->responseData['status'] = 1;
                         $this->responseData['message'] = '<p>Письмо с инструкцией по восстановлению пароля отправлено на почту <strong>'.$email.'</strong></p>';
                         self::sendResponse($this->responseData);
                     }
                     else
                     {
                         $this->responseData['message'] = 'Ошибка, попробуйте позже';
                     }
                 }
                 else{
                     $this->responseData['message'] = 'Аккаунт с почтой '.$email.' не авторизирован на сайте';
                     self::sendResponse($this->responseData);
                 }
            }
        }

        //========== user cabinet  ==========//

    }