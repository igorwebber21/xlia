<?php


    namespace app\models;


    use ishop\App;
    use RedBeanPHP\R;

    class User extends AppModel
    {
        public const PASSWORD_PERMISSION_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        public const PASSWORD_LENGTH = 8;

        public $attributes = [
            'password' => '',
            'login' => '',
            'fname' => '',
            'lname' => '',
            'birthday' => '',
            'email' => '',
            'phone' => '',
            'address' => '',
            'ip_address' => '',
            'ip_location' => '',
            'role' => 'user',
        ];

        public $rules = [
            'required' => [
                ['fname'],
                ['lname'],
                ['email'],
                ['phone'],
            ],
            'email' => [
                ['email'],
            ],
            'lengthMin' => [
                ['password', 6],
            ]
        ];


        public function checkUnique(){
            $user = R::findOne('user', 'phone = ? OR email = ?', [$this->attributes['phone'], $this->attributes['email']]);

            if($user){
                if($user->phone == $this->attributes['phone']){
                    $this->errors['unique'][] = 'Этот телефон уже занят';
                }
                if($user->email == $this->attributes['email']){
                    $this->errors['unique'][] = 'Этот Email уже занят';
                }
                return false;
            }

            return true;
        }

        public function checkPhoneNumber(){
            $user = R::findOne('user', 'phone = ?', [ $this->attributes['phone'] ]);

            if($user){
                if($user->phone == $this->attributes['phone']){
                    $this->errors['unique'][] = 'Аккаунт с таким номером телефона уже зарегистрирован на сайте.';
                    $this->errors['unique'][] = 'Войдите на сайт с помощью формы авторизации и оформите заказ.';
                }
                return false;
            }

            return true;
        }

        public function login($userData, $isAdmin = false)
        {
            $login = !empty(trim($userData['login'])) ? trim($userData['login']) : null;
            $password = !empty(trim($userData['password'])) ? trim($userData['password']) : null;

            if($login && $password)
            {
                if($isAdmin){
                    $user = R::findOne('user', "login = ? AND role = 'admin'", [$login]);
                }else{
                    $user = R::findOne('user', "email = ?", [$login]);
                }

                if($user){
                    if(password_verify($password, $user->password)){
                        foreach($user as $k => $v){
                            if($k != 'password') $_SESSION['user'][$k] = $v;
                        }
                        return true;
                    }
                }
            }
            return false;
        }

        public static function checkAuth()
        {
            return isset($_SESSION['user']);
        }

        public static function isAdmin()
        {
            return (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'admin');
        }

        public static function generatePassword()
        {
            return generate_string(self::PASSWORD_PERMISSION_CHARS, self::PASSWORD_LENGTH);
        }

        public static function sendEmailPassword($userPassword, $userData)
        {
            // Create a message
            ob_start();
            require APP. '/views/mail/mail_user_password.php';
            $body = ob_get_clean();

            //============================= send email by SwiftMailer =======================================//
            $transport = (new \Swift_SmtpTransport(App::$app->getProperty('smtp_host'),
                App::$app->getProperty('smtp_port'), App::$app->getProperty('smtp_protocol')))
                ->setUsername(App::$app->getProperty('smtp_login'))
                ->setPassword(App::$app->getProperty('smtp_password'));

            $mailer = new \Swift_Mailer($transport);

            $messageClient = (new \Swift_Message("MegaShop - Ваши данные для входа на сайт"))
                ->setFrom([App::$app->getProperty('smtp_login') => App::$app->getProperty('shop_name')])
                ->setTo($userData['email'])
                ->setBody($body, 'text/html');

            // Send a message
            $result = $mailer->send($messageClient);
            return $result;
            //============================= send email by SwiftMailer =======================================//
        }

    }