<?php


    namespace app\controllers;


    use app\models\User;
    use RedBeanPHP\R;

    class UserController extends AppController
    {

        public function signupAction()
        {

            if(!empty($_POST))
            {

                $user = new User();
                $user->rules['required'][] = ['password'];
                $user->attributes['password'] = $_POST['userPassword'] ? $_POST['userPassword'] : '';

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


        public function loginAction()
        {
            if(!empty($_POST))
            {
                $user = new User();

                if($user->login())
                {
                    $_SESSION['success'] = 'Вы успешно авторизованы';
                    redirect('/user/cabinet');
                }
                else
                {
                    $_SESSION['error'] = 'Логин/пароль введены неверно';
                }

                redirect();
            }

            $this->setMeta('Вход');
        }

        public function logoutAction()
        {
            if(isset($_SESSION['user'])) unset($_SESSION['user']);
            redirect();
        }

        public function cabinetAction()
        {
            if(!User::checkAuth()) redirect();
            $this->setMeta('Личный кабинет');
        }


        //========== user cabinet  ==========//
        public function editAction()
        {
            if(!User::checkAuth()) redirect('/user/login');

            if(!empty($_POST))
            {
                $user = new \app\models\admin\User();
                $data = $_POST;
                $data['id'] = $_SESSION['user']['id'];
                $data['role'] = $_SESSION['user']['role'];
                $user->load($data);
                if(!$user->attributes['password']){
                    unset($user->attributes['password']);
                }else{
                    $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                }
                if(!$user->validate($data) || !$user->checkUnique()){
                    $user->getErrors();
                    redirect();
                }
                if($user->update('user', $_SESSION['user']['id'])){
                    foreach($user->attributes as $k => $v){
                        if($k != 'password') $_SESSION['user'][$k] = $v;
                    }
                    $_SESSION['success'] = 'Изменения сохранены';
                }
                redirect();
            }

            $this->setMeta('Изменение личных данных');
        }

        public function ordersAction()
        {
            if(!User::checkAuth()) redirect('/user/login');
            $orders = R::findAll('orders', 'user_id = ?', [$_SESSION['user']['id']]);
            $this->setMeta('История заказов');
            $this->set(compact('orders'));
        }
        //========== user cabinet  ==========//

    }