<?php

    namespace app\models;

    use ishop\App;

    class Cart extends AppModel {

        public function addToCart($product, $qty = 1, $mod = null){
            //session_unset();

            // при первом добавлении в корзину, фиксируем валюту как базовую
            // дальнейшие добавления в корзину будут пересчитываться в этой валюте
            if(!isset($_SESSION['cart.currency'])){
                $_SESSION['cart.currency'] = App::$app->getProperty('currency');
            }

            // если есть модификатор (цвет, размер и т.д.)
            if($mod){
                $ID = "{$product['id']}-{$mod}";
                $title = "{$product['title']} (Размер {$mod})";
                $price = $product['price'];
            }else{
                $ID = $product['id'];
                $title = $product['title'];
                $price = $product['price'];
            }

            // если товар уже добавлен в козину, добавить количество +qty
            if(isset($_SESSION['cart'][$ID])){
                $_SESSION['cart'][$ID]['qty'] += $qty;
            }
            else{   // если товара еще нет в корзине
                $_SESSION['cart'][$ID] = [
                    'qty' => $qty,
                    'title' => $title,
                    'alias' => $product['alias'],
                    'price' => $price * $_SESSION['cart.currency']['value'],
                    'old_price' => $product['old_price'] * $_SESSION['cart.currency']['value'],
                    'img' => explode(',', $product['base_img'])[0]
                ];
            }
            // суммарное количество и сумма
            $_SESSION['cart.qty'] = isset($_SESSION['cart.qty']) ? $_SESSION['cart.qty'] + $qty : $qty;
            $_SESSION['cart.sum'] = isset($_SESSION['cart.sum']) ? $_SESSION['cart.sum'] + $qty * ($price * $_SESSION['cart.currency']['value']) : $qty * ($price * $_SESSION['cart.currency']['value']);
           // debug($_SESSION);
        }

        public function changeCart($product, $operation, $prodData = null)
        {
            if(isset($_SESSION['cart'][$prodData]))
            {
                if($operation == 'minus')
                {
                    if($_SESSION['cart'][$prodData]['qty'] > 1)
                    {
                        $_SESSION['cart'][$prodData]['qty']--;
                        $_SESSION['cart.qty']--;
                        $_SESSION['cart.sum'] -= $product->price*$_SESSION['cart.currency']['value'];
                    }
                }
                elseif ($operation == 'plus')
                {
                    $_SESSION['cart'][$prodData]['qty']++;
                    $_SESSION['cart.qty']++;
                    $_SESSION['cart.sum'] += $product->price*$_SESSION['cart.currency']['value'];
                }
            }
        }


        public function deleteItem($id){
            $qtyMinus = $_SESSION['cart'][$id]['qty'];
            $sumMinus = round($_SESSION['cart'][$id]['qty'] * $_SESSION['cart'][$id]['price']);
            $_SESSION['cart.qty'] -= $qtyMinus;
            $_SESSION['cart.sum'] -= $sumMinus;
            unset($_SESSION['cart'][$id]);

            if($_SESSION['cart.qty'] == 0)
            {
                unset($_SESSION['cart']);
                unset($_SESSION['cart.qty']);
                unset($_SESSION['cart.currency']);
                unset($_SESSION['cart.sum']);
            }
        }


        public static function recalc($curr){

            if(isset($_SESSION['cart.currency'])){
                if($_SESSION['cart.currency']['base'] == 'yes'){
                    $_SESSION['cart.sum'] *= $curr->value;
                }else{
                    $_SESSION['cart.sum'] = $_SESSION['cart.sum'] / $_SESSION['cart.currency']['value'] * $curr->value;
                }
                foreach($_SESSION['cart'] as $k => $v){
                    if($_SESSION['cart.currency']['base'] == 'yes'){
                        $_SESSION['cart'][$k]['price'] *= $curr->value;
                    }else{
                        $_SESSION['cart'][$k]['price'] = $_SESSION['cart'][$k]['price'] / $_SESSION['cart.currency']['value'] * $curr->value;
                    }
                }
                foreach($curr as $k => $v){
                    $_SESSION['cart.currency'][$k] = $v;
                }
            }
        }


    }



    /*

    [Cart.currency] => Array
        (
            [title] => доллар
            [symbol_left] => $
            [symbol_right] =>
            [value] => 1.00
            [base] => 1
            [code] => USD
        )

    [Cart] => Array
        (
            [3] => Array
                (
                    [qty] => 3
                    [title] => Casio GA-1000-1AER
                    [alias] => casio-ga-1000-1aer
                    [price] => 400
                    [img] => p-3.png
                )

            [2-6] => Array
                (
                    [qty] => 1
                    [title] => Casio MQ-24-7BUL (Red)
                    [alias] => casio-mq-24-7bul
                    [price] => 70
                    [img] => p-2.png
                )

        )

    [Cart.qty] => 4
    [Cart.sum] => 1270
    */
