<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div style="width: 100%">


    <table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px; width: 100%; margin: 0 auto; padding: 0; font-family: Tahoma;">

        <tr>
            <td style="text-align: center; background: #F7F7F7; padding: 25px 0 0 0;">
                <img src="http://100c.info/img/ms-logo-1.png" alt="ms-logo" style="width: 250px;">
            </td>
        </tr>

        <tr>
            <td style="text-align: center; background: #F7F7F7; padding: 5px 0 25px 0;">
                <table style="list-style: none; border-bottom: 1px solid #ccc; border-top: 1px solid #ccc; padding: 25px 10px;  margin: 0; width: 100%;">
                    <tr>
                        <td>
                            <a style="text-decoration: none; color: #191919;" href="#">Женщинам</a>
                        </td>
                        <td>
                            <a style="text-decoration: none; color: #191919;" href="#">Мужчинам</a>
                        </td>
                        <td>
                            <a style="text-decoration: none; color: #191919;" href="#">Детям</a>
                        </td>
                        <td>
                            <a style="text-decoration: none; color: #191919;" href="#">Sale</a>
                        </td>
                        <td>
                            <a style="text-decoration: none; color: #191919;" href="#">Новинки</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="text-align: center;">
                <h1 style="text-align: center;  background: #f82e56;  color: #fff; padding: 25px 10px; margin: 0;">Спасибо за Ваш заказ!</h1>
            </td>
        </tr>

        <tr>
            <td style="background: #F7F7F7;">


                <table style="border: 1px solid #ddd; border-collapse: collapse; width: 100%; margin: 50px 0;">
                    <thead>
                    <tr style="background: #f9f9f9;">
                        <th style="padding: 8px; border: 1px solid #ddd;">Наименование</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Кол-во</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Цена</th>
                        <th style="padding: 8px; border: 1px solid #ddd;">Сумма</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($_SESSION['cart'] as $item): ?>
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?=$item['title'] ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?=$item['qty'] ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?=$item['price'] ?></td>
                            <td style="padding: 8px; border: 1px solid #ddd;"><?=$item['price'] * $item['qty'] ?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="3" style="padding: 8px; border: 1px solid #ddd;">Итого:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?=$_SESSION['cart.qty'] ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="padding: 8px; border: 1px solid #ddd;">На сумму:</td>
                        <td style="padding: 8px; border: 1px solid #ddd;"><?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . " {$_SESSION['cart.currency']['symbol_right']}" ?></td>
                    </tr>
                    </tbody>
                </table>


            </td>
        </tr>

        <tr>
            <td>
                <table style="background: #F7F7F7; margin: 0; width: 100%; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc; padding: 25px;">
                    <tr>
                        <td><a style="text-decoration: none; color: #191919;" href="#">Оплата и доставка</a></td>
                        <td><a style="text-decoration: none; color: #191919;" href="#">Вопросы и ответы</a></td>
                        <td><a style="text-decoration: none; color: #191919;" href="#">Личный кабинет</a></td>
                        <td><a style="text-decoration: none; color: #191919;" href="#">Возврат / обмен</a></td>
                        <td><a style="text-decoration: none; color: #191919;" href="#">Блог</a></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td style="text-align: center; background: #F7F7F7; color: #aaa;">
                <p>Вы получили это сообщение потому, что подписаны на рассылку интернет-магазина MegaShop</p>
            </td>
        </tr>

    </table>


</div>



</body>
</html>

