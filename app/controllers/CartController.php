<?php


    namespace app\controllers;
    use app\models\Cart;
    use app\models\Order;
    use app\models\User;
    use RedBeanPHP\R;

    class CartController extends AppController {

        // добавить в корзину
        public function addAction()
        {
            //debug($_GET, 1);
            $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
            $qty = !empty($_GET['qty']) ? (int)$_GET['qty'] : null;
            $mod = !empty($_GET['mod']) ? $_GET['mod'] : null;

            if($id){

              $product =  R::getRow("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img
                                       FROM product 
                                       LEFT JOIN product_base_img ON product_base_img.product_id = product.id
                                       WHERE product.id = ".$id);

                if(!$product){
                    return false;
                }

            }

            $cart = new Cart();
            $cart->addToCart($product, $qty, $mod);

            $this->isAjax() ? $this->showAction() : redirect();
        }

        public function changeAction()
        {
            $prodData = !empty($_GET['prodData']) ? $_GET['prodData'] : null;
            $operation = !empty($_GET['operation']) ? $_GET['operation'] : null;

            $id = explode('-', $prodData)[0];

            if($id){
                $product =  R::findOne('product', 'id = ?', [$id]);

                if(!$product){
                    return false;
                }
            }

            $cart = new Cart();
            $cart->changeCart($product, $operation, $prodData);

            $this->isAjax() ? $this->showAction() : redirect();

        }

        public function showAction()
        {
            $cartViews = $this->getCartViews();
            echo json_encode($cartViews, true);
            die;
        }

        public function getCartViews()
        {
            $cartViews['cartHeader'] = $this->loadViews('cart_header');
            $cartViews['cartContent'] = $this->loadViews('cart_content');
            $cartViews['cartCheckout'] = $this->loadViews('cart_checkout');
            $cartViews['cartIsEmpty'] = isset($_SESSION['cart']) && $_SESSION['cart'] ? false : true;
            $cartViews['cartItemsCount'] = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            $cartViews['cartTotalQty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] : 0;
            $cartViews['cartTotalSum'] = isset($_SESSION['cart.sum']) ? round($_SESSION['cart.sum']) : 0;

            return $cartViews;
        }


        public function deleteAction()
        {
            $id = !empty($_GET['id']) ? $_GET['id'] : null;
            if(isset($_SESSION['cart'][$id])){
                $cart = new Cart();
                $cart->deleteItem($id);
            }

            $this->isAjax() ? $this->showAction() : redirect();
        }

        public function clearAction()
        {
            self::clearCart();
            $this->isAjax() ? $this->showAction() : redirect();
        }

        public static function clearCart()
        {
            unset($_SESSION['cart']);
            unset($_SESSION['cart.qty']);
            unset($_SESSION['cart.currency']);
            unset($_SESSION['cart.sum']);
        }

        public function viewAction()
        {
            if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])){
              redirect();
            }

            $this->setMeta('Корзина');
            $delivery_methods =  R::getAll('SELECT * FROM delivery_methods');
            $payment_methods =  R::getAll('SELECT * FROM payment_methods');
            $this->set(compact('delivery_methods', 'payment_methods'));
        }

        public function checkoutQuickAction()
        {
            if(isset($_POST['userPhoneQuick']) && !empty($_POST['userPhoneQuick']))
            {
                $user = new User();
                $user->attributes['phone'] = $_POST['userPhoneQuick'];

                // check, if user phone exists in DB
                if(!$user->checkPhoneNumber())
                {
                    $errors = $user->getErrors();
                    $this->responseData['message'] = $errors;
                    self::sendResponse($this->responseData);
                }

                // save order
                $userPhoneQuick = isset($_POST['userPhoneQuick'])
                                  ? "Быстрый заказ с номера ". $_POST['userPhoneQuick'] .": "
                                  : '';

                $orderData['note'] = isset($_POST['orderCommentQuick']) ? $userPhoneQuick.$_POST['orderCommentQuick'] : '';
                $order_id = Order::saveOrder($orderData);

                // check if order is success
                if($order_id)
                {
                    CartController::clearCart();
                    $this->responseData['cart'] = $this->getCartViews();
                    $this->responseData['status'] = 1;
                    $this->responseData['message'] = '<p>Спасибо, за Ваш заказ. В ближайшее время с Вами свяжеться менеджер</p>';
                }
                else{
                    $this->responseData['message'] = '<p>Ошибка, заказ не сохранён. Попробуйте ещё раз</p>';
                }

                self::sendResponse($this->responseData);
            }
        }

        public function checkoutAction()
        {
            if($_POST)
            {
                if(!User::checkAuth())
                {
                    // register user
                    $user = new User();
                    $data = $_POST;

                   // debug($data, 1);

                    $user->attributes['email'] = $data['userEmail'];
                    $user->attributes['phone'] = $data['userPhone'];
                    $user->attributes['name'] = $data['userName'];
                    $user->attributes['address'] = $data['userCity'];

                    // checkUnique - проверяем есть ли в БД user с таким телефоном или email
                    if(!$user->validate($user->attributes) || !$user->checkUnique())
                    {
                        $errors = $user->getErrors();
                        $this->responseData['message'] = $errors;
                        self::sendResponse($this->responseData);
                    }
                    else
                    {
                        $generatedPassword = $user::generatePassword();
                        $user->attributes['password'] = password_hash($generatedPassword, PASSWORD_DEFAULT);
                        $user->attributes['ip_address'] = getUserIP();
                        $user->attributes['ip_location'] = getUserLocation($user->attributes['ip_address']);

                        $user_id = $user->save('user');

                        if($user_id)
                        {
                            //если зарегистрировали - отправляем Email с данными для входа
                            //$user::sendEmailPassword($generatedPassword, $user->attributes);
                        }
                        else{
                            $this->responseData['message'] = '<p>Ошибка, пользователь не сохранён. Попробуйте ещё раз</p>';
                            self::sendResponse($this->responseData);
                        }
                    }
                }

                // save order
                $orderData['user_id'] = isset($user_id) ? $user_id : $_SESSION['user']['id'];
                $orderData['note'] = isset($_POST['orderComment']) ? $_POST['orderComment'] : '';
                $orderData['deliveryMethod'] = isset($_POST['deliveryMethod']) ? $_POST['deliveryMethod'] : '';
                $orderData['deliveryCity'] = isset($_POST['userCity']) ? $_POST['userCity'] : '';
                $orderData['paymentMethod'] = isset($_POST['paymentMethod']) ? $_POST['paymentMethod'] : '';

                // send email to user
                $user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_POST['userEmail'];
                $user_name = isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : $_POST['userName'];
                $order_id = Order::saveOrder($orderData);
                //Order::mailOrder($order_id, $user_email);

                // check if order is success
                if($order_id)
                {
                    CartController::clearCart();
                    $this->responseData['cart'] = $this->getCartViews();
                    $this->responseData['status'] = 1;
                    $this->responseData['message'] = '<p class="success-order-title">'.$user_name.', спасибо за Ваш заказ! В ближайшее время с Вами свяжеться менеджер.</p>
                                   <h2>Номер Вашего заказа №'.$order_id.'</h2>
                                   <span class="material-icons">favorite</span>
                                   <div><a href="/"><button style="
                                                                color: #fff;
                                                                border: 0;
                                                                background: #ff680d;
                                                                box-shadow: none;
                                                                height: 35px;
                                                                width: 190px;
                                                                margin: 25px auto 0 auto;
                                                            ">
                                                                Вернуться в магазин</button></a>
                                                                </div>';
                }
                else{
                    $this->responseData['message'] = '<p>Ошибка, заказ не сохранён. Попробуйте ещё раз</p>';
                }

                self::sendResponse($this->responseData);

            }
        }

    }