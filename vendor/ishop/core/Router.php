<?php

    namespace ishop;
    use mysql_xdevapi\Exception;

    class Router
    {
        protected static $routes = [];
        protected static $route = [];

        // add routes from config
        public static function add($regexp, $route = []){
            self::$routes[$regexp] = $route;
        }

        public static function getRoutes(){
            return self::$routes;
        }

        public static function getRoute(){
            return self::$route;
        }

        // if routing url mathes class controller and class method exists, create controller object and call class method
        public static function dispatch($url){

            $url = self::removeQueryString($url);

            if(self::matchRoute($url)){
                $controller = 'app\controllers\\'. self::$route['prefix'] . self::$route['controller']. 'Controller';
                //echo $controller;

                if(class_exists($controller)){
                    $controllerObject = new $controller(self::$route);
                    $action = self::lowerCamelCase(self::$route['action']). 'Action';
                    //var_dump($controllerObject);
                   // echo " - ".$action;
                    if(method_exists($controllerObject, $action)){
                        $controllerObject->$action();
                        $controllerObject->getView();
                    }
                    else{
                        throw new \Exception("Метод $controller::$action не найден", 404);
                    }
                }
                else{
                    throw new \Exception("Контроллер $controller не найден", 404);
                }
            }
            else{
                throw new \Exception("Страница не найдена", 404);
            }
        }

        // method checkes, if current url matches user patterns (in config/routers.php)
        public static function matchRoute($url){

            foreach(self::$routes as $pattern => $route) {

                if(preg_match("#{$pattern}#i", $url, $matches)){
                    // debug($matches);

                    foreach ($matches as $k => $v){
                            if(is_string($k)){
                                $route[$k] = $v;
                            }
                    }
                    if(empty($route['action'])){
                        $route['action'] = 'index';
                    }

                    if(!isset($route['prefix'])){
                        $route['prefix'] = '';
                    }
                    else{
                        $route['prefix'] .= '\\';
                    }

                    $route['controller'] = self::upperCamelCase($route['controller']);
                    self::$route = $route;

                   // debug($route);

                    return true;
                }
            }
            return false;
        }

        //CamelCase
        protected static function upperCamelCase($name){

            $name = str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
            return $name;
        }

        //camelCase
        protected static function lowerCamelCase($name){
            return  lcfirst(self::upperCamelCase($name));
        }

        protected static function removeQueryString($url){

            if($url){
                // max 2 parameters in $_GET query
                $params = explode('&', $url, 2);
               // debug($params);

                if(false === strpos($params[0], '=')){
                    return rtrim($params[0], '/');
                }
                else{
                    return '';
                }
            }
        }


    }