<?php

namespace ishop;

require_once dirname(__DIR__) . '/config/init.php';
require_once LIBS . '/functions.php';
require_once CONF . '/routes.php';

$app = new App();
$router = new Router();

//$app::$app->setProperty('property_id', 1);

//debug($router::getRoutes());
//debug($router::getRoute());
//debug($app::$app->getProperties());
//$router = new Router();
//echo $app::$app->getProperty('pagination');
//debug($_SESSION);
// debug($app::$app->getProperties());
// throw new Exception("Не найдена 66", 404);
// debug($router::getRoutes());
