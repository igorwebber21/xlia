<?php


namespace app\models;


use app\controllers\CartController;
use ishop\App;
use RedBeanPHP\R;

class Order extends AppModel
{
    public static $QUICK_ORDER_USER_ID = 0;

    public static function saveOrder($data)
    {
        $order = R::dispense('orders');

        $order->user_id = isset($data['user_id']) ? $data['user_id'] : self::$QUICK_ORDER_USER_ID;
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];
        $order->sum = round($_SESSION['cart.sum']);

        $order_id = R::store($order);
        self::saveOrderProduct($order_id);

        self::saveOrderDelivery($order_id, $data);

        return $order_id;
    }

    public static function saveOrderProduct($order_id)
    {
        $sql_part = '';

        foreach ($_SESSION['cart'] as $product_id => $product)
        {
            $product_id = (int)$product_id;
            $product_price = round($product['price']);
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product_price}),";
        }

        $sql_part = rtrim($sql_part, ',');
        R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
    }

    public static function saveOrderDelivery($order_id, $data)
    {
        $sql_part = "($order_id, '{$data['deliveryMethod']}', '{$data['paymentMethod']}', '{$data['deliveryCity']}', '{$data['deliveryBranch']}')";
        R::exec("INSERT INTO user_delivery (order_id, delivery_method, payment_method, delivery_city, delivery_branch) VALUES $sql_part");
    }

    public static function mailOrder($order_id, $user_email)
    {
        // https://mail.ukr.net/

        // Create a message
        ob_start();
        require APP. '/views/mail/mail_order.php';
        $body = ob_get_clean();

        //============================= send email by SwiftMailer =======================================//
        $transport = (new \Swift_SmtpTransport(App::$app->getProperty('smtp_host'),
            App::$app->getProperty('smtp_port'), App::$app->getProperty('smtp_protocol')))
            ->setUsername(App::$app->getProperty('smtp_login'))
            ->setPassword(App::$app->getProperty('smtp_password'));

        $mailer = new \Swift_Mailer($transport);

        $messageClient = (new \Swift_Message("Заказ №_{$order_id}"))
            ->setFrom([App::$app->getProperty('smtp_login') => App::$app->getProperty('shop_name')])
            ->setTo($user_email)
            ->setBody($body, 'text/html');

        $messageAdmin = (new \Swift_Message("Заказ №_{$order_id}"))
            ->setFrom([App::$app->getProperty('smtp_login') => App::$app->getProperty('shop_name')])
            ->setTo(App::$app->getProperty('admin_email'))
            ->setBody($body, 'text/html');

        // Send a message
        $result = $mailer->send($messageClient);
        $result2 = $mailer->send($messageAdmin);
        //============================= send email by SwiftMailer =======================================//

        return ($result == 1 && $result2 == 1) ? 1 : 0;

    }

}