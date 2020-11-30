<?php

namespace ishop;

class App{

    public static $app;

    public function __construct(){

        //  $query = http://ishop2-dev/category/elektronnye => category/elektronnye
        $query = trim($_SERVER['QUERY_STRING'], '/');
        session_start();

        // property $app is a singletone template object, that has project properties (like shop_name, admin_email, pagination)
        self::$app = Registry::instance();
        $this->getParams();
        new ErrorHandler();
        Router::dispatch($query);
    }

    protected function getParams(){
        $params = require_once CONF . '/params.php';
        if(!empty($params)){
            foreach($params as $k => $v){
                self::$app->setProperty($k, $v);
            }
        }
    }

}