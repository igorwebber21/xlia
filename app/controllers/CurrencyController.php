<?php


    namespace app\controllers;


    use app\models\Cart;
    use RedBeanPHP\R;

    class CurrencyController extends AppController
    {

        // method changes active currency on the site
        public function changeAction(){

            $currency = $_GET['curr'] ? $_GET['curr'] : null;
            if($currency){
                $curr = R::findOne('currency', 'code = ?', [$currency]);

                if(!empty($curr)){
                    setcookie('currency', $currency, time() + 3600*  24 * 7, '/');
                    Cart::recalc($curr);
                }

            }

            redirect();
        }

    }