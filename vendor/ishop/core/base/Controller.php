<?php

    namespace ishop\base;

    abstract class Controller
    {
        public $route;
        public $controller;
        public $view;
        public $model;
        public $prefix;
        public $layout;
        public $data = [];
        public $meta = ['title' => '', 'description' => '', 'keywords' => ''];

        public function __construct($route)
        {
            $this->route = $route;
            $this->controller = $route['controller'];
            $this->model = $route['controller'];
            $this->view = $route['action'];
            $this->prefix =  $route['prefix'];
        }

        public function getView(){
            $viewObject = new View($this->route, $this->layout, $this->view, $this->meta);
            $viewObject->render($this->data);
        }

        public function set($data){
            $this->data = $data;
        }

        public function setMeta($title = '', $description = '', $keywords = ''){
            $this->meta['title'] = h($title);
            $this->meta['description'] = h($description);
            $this->meta['keywords'] = h($keywords);
        }


        public function isAjax() {
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
        }

        public function loadView($view, $vars = []){
            extract($vars);
            require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
            // session_destroy();
           // debug($_SESSION);
            die;
        }

        public function loadViews($view, $vars = [])
        {
            extract($vars);

            ob_start();
            require APP . "/views/{$this->prefix}{$this->controller}/{$view}.php";
            $content = ob_get_clean();

            return $content;
        }


    }