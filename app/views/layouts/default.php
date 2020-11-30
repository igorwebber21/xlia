<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?=$this->getMeta();?>
</head>
<body>

        <h1>Шаблон Default</h1>
        <p>Передача массива: <?php   debug($names); ?></p>
        <p>Передача переменной: <br><?=$name?></p>
<?php echo $content; ?>


<?php

    //use RedBeanPHP\R as R;
    $logs = RedBeanPHP\R::getDatabaseAdapter()
        ->getDatabase()
        ->getLogger();

    debug( $logs->grep( 'SELECT' ) );
?>
</body>
</html>
