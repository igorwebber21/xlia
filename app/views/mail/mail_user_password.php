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
                <h1 style="text-align: center;  background: #f82e56;  color: #fff; padding: 25px 10px; margin: 0;">Ваши данные для входа в интернет магазин MegaShop!</h1>
            </td>
        </tr>

        <tr>
            <td style="background: #F7F7F7;">
                <div style="max-width: 450px; margin: 0 auto; padding: 35px 25px;">
                    <p><?=$userData['fname']?> <?=$userData['lname']?>, используйте следующие данные для входа на сайт:  </p>

                    <ul>
                        <li>
                            Ваш логин: <strong><?=$userData['email']?></strong>
                        </li>
                        <li>
                            Ваш пароль: <strong><?=$userPassword?></strong>
                        </li>
                    </ul>
                </div>
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

