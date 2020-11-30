<?php


namespace app\models;


use ishop\App;
use RedBeanPHP\R;

class Order extends AppModel
{

    public static function saveOrder($data)
    {
        $order = R::dispense('orders');

        $order->user_id = $data['user_id'];
        $order->note = $data['note'];
        $order->currency = $_SESSION['cart.currency']['code'];

        $order_id = R::store($order);
        self::saveOrderProduct($order_id);

        return $order_id;
    }

    public static function saveOrderProduct($order_id)
    {
        $sql_part = '';

        foreach ($_SESSION['cart'] as $product_id => $product)
        {
            $product_id = (int)$product_id;
            $sql_part .= "($order_id, $product_id, {$product['qty']}, '{$product['title']}', {$product['price']}),";
        }

        $sql_part = rtrim($sql_part, ',');
        R::exec("INSERT INTO order_product (order_id, product_id, qty, title, price) VALUES $sql_part");
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
        $result = $mailer->send($messageAdmin);
        //============================= send email by SwiftMailer =======================================//


        unset($_SESSION['cart']);
        unset($_SESSION['cart.sum']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.currency']);

        $_SESSION['success'] = "Спасибо за ваш заказ. В ближайшее время с Вами свяжется менеджер";

    }

}