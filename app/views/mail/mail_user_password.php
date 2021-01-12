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

    <h1>Спасибо, за регистрацию в интернет магазине MegaShop!</h1>

    <p><?=$userData['fname']?> <?=$userData['lname']?>, используйте следующие данные для входа на сайт:  </p>

    <ul>
        <li>
            Ваш логин: <?=$userData['email']?> (или <?=$userData['phone']?>)
        </li>
        <li>
            Ваш пароль: <?=$userPassword?>
        </li>
    </ul>

</body>
</html>
