<?php

namespace ishop;

class Registry {

    use TSingletone;

    protected static $properties = [];

    // set project property (like shop_name, admin_email, pagination)
    public function setProperty($name, $value){
        self::$properties[$name] = $value;
    }

    public function getProperty($name){
        if(isset(self::$properties[$name])){
            return self::$properties[$name];
        }
        return null;
    }

    public function getProperties(){
        return self::$properties;
    }

}