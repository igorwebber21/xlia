<?php


    namespace ishop;
    use \RedBeanPHP\R as R;

    class DB
    {
        use TSingletone;

        protected function __construct()
        {
            $db = require_once CONF.'/config_db.php';
            //class_alias('\RedBeanPHP\R', '\R');
            R::setup($db['dsn'], $db['user'], $db['pass']);

            if(!R::testConnection()){
                throw new \Exception('Нет соединения с БД', 500);
            }
            else{
                // echo "Соединение с БД установлено";
            }

            R::freeze( TRUE );

            if(DEBUG){
                R::debug(true, 1);
            }

            R::ext('xdispanese', function($type){
                return R::getRedBean()->dispense($type);
            });
        }
    }