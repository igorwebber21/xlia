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
            $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
            $mod = null;
            if($id){
                $product =  R::findOne('product', 'id = ?', [$id]);

                if(!$product){
                    return false;
                }
                if($mod_id){
                    $mod = R::findOne('modification', 'id = ? AND product_id = ?', [$mod_id, $id]);
                }

            }

            $cart = new Cart();
            $cart->addToCart($product, $qty, $mod);

            $this->isAjax() ? $this->showAction() : redirect();
        }

        public function changeAction()
        {
            $id = !empty($_GET['id']) ? (int)$_GET['id'] : null;
            $operation = !empty($_GET['operation']) ? $_GET['operation'] : null;

            $mod_id = !empty($_GET['mod']) ? (int)$_GET['mod'] : null;
            $mod = null;
            if($id){
                $product =  R::findOne('product', 'id = ?', [$id]);

                if(!$product){
                    return false;
                }
                if($mod_id){
                    $mod = R::findOne('modification', 'id = ? AND product_id = ?', [$mod_id, $id]);
                }

            }

            $cart = new Cart();
            $cart->changeCart($product, $operation, $mod);

            $this->isAjax() ? $this->showAction() : redirect();

        }

        public function showAction()
        {
            $cartViews['cartFooter'] = $this->loadViews('cart_footer');
            $cartViews['cartHeader'] = $this->loadViews('cart_header');
            $cartViews['cartContent'] = $this->loadViews('cart_content');
            $cartViews['cartIsEmpty'] = isset($_SESSION['cart']) && $_SESSION['cart'] ? false : true;
            $cartViews['cartTotalQty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] : 0;
            $cartViews['cartTotalSum'] = isset($_SESSION['cart.sum']) ? round($_SESSION['cart.sum']) : 0;
            echo json_encode($cartViews, true);
            die;
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
            unset($_SESSION['cart']);
            unset($_SESSION['cart.qty']);
            unset($_SESSION['cart.currency']);
            unset($_SESSION['cart.sum']);

            $this->isAjax() ? $this->showAction() : redirect();
        }

        public function viewAction()
        {
            $this->setMeta('Корзина');
        }

        public function checkoutAction()
        {
            if($_POST)
            {

                debug($_POST, 1);
                if(!User::checkAuth())
                {
                    // register user
                    $user = new User();
                    $data = $_POST;
                    $user->load($data);

                    if(!$user->validate($data) || !$user->checkUnique())
                    {
                        $user->getErrors();
                        $_SESSION['form_data'] = $data;
                        redirect();
                    }
                    else
                    {
                        $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                        $user_id = $user->save('user');

                        if (!$user_id)
                        {
                            $_SESSION['error'] = 'Ошибка';
                            redirect();
                        }
                    }
                }

                // save order
                $data['user_id'] = isset($user_id) ? $user_id : $_SESSION['user']['id'];
                $data['note'] = $_POST['note'] ? $_POST['note'] : '';

                // send email to user
                $user_email = isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : $_POST['email'];
                $order_id = Order::saveOrder($data);
                Order::mailOrder($order_id, $user_email);

                redirect();
            }
        }

    }