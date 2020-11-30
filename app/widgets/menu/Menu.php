<?php


    namespace app\widgets\menu;


    use ishop\App;
    use ishop\Cache;
    use RedBeanPHP\R;

    class Menu
    {
        protected $data;
        protected $tree;
        protected $menuHtml;
        protected $tpl;
        protected $default = true;
        protected $container = 'ul';
        protected $class = 'menu';
        protected $table = 'category';
        protected $cache = 3600;
        protected $cacheKey = 'ishop_menu';
        protected $attrs = [];
        protected $prepend = '';

        public function __construct($options = [], $admin = false)
        {
            $this->tpl = __DIR__ . '/menu_tpl/menu.php';
            $this->getOptions($options);
            //debug($this->table);
            $this->run();
        }

        protected function getOptions($options){

            foreach ($options as $k => $v){
                if(property_exists($this, $k)){
                    $this->$k = $v;
                }
            }
        }

        protected function run(){
            $cache = Cache::instance();
            $this->menuHtml = $cache->get($this->cacheKey);
            // if np cache
            if(!$this->menuHtml){
                $this->data = App::$app->getProperty('cats');
                if(!$this->data){
                    $this->data = R::getAssoc("SELECT * FROM {$this->table}");
                }

                $this->tree = $this->getTree();
                $this->menuHtml = $this->getMenuHtml($this->tree);
                // debug($this->tree);
                if($this->cache){
                    $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
                }
            }
            $this->output();

        }

        protected function output(){
            $attrs = '';

            if(!empty($this->attrs)){
                foreach($this->attrs as $k => $v) {
                    $attrs .= " $k='$v' ";
                }
            }

            if($this->default){
                echo "<{$this->container} class='{$this->class}' $attrs>";
            }
            echo $this->prepend;
            echo $this->menuHtml;
            if($this->default){
                echo "</{$this->container}>";
            }
        }

        protected function getTree(){
            $tree = [];
            $data = $this->data;
            foreach ($data as $id=>&$node) {
                if (!$node['parent_id']){
                    $tree[$id] = &$node;
                }else{
                    $data[$node['parent_id']]['childs'][$id] = &$node;
                }
            }
            return $tree;
        }

        protected function getMenuHtml($tree, $tab = ''){
            $str = '';

            if($this->default)
            {

                foreach($tree as $id => $category){
                    $str .= $this->catDefaultTemplate($category, $tab, $id);
                }
            }
            else
            {
                $str .= $this->catOwnTemplate($tree);
            }

            return $str;
        }

        protected function catOwnTemplate($tree){
            ob_start();
            require $this->tpl;
            return ob_get_clean();
        }

        protected function catDefaultTemplate($category, $tab, $id)
        {
            ob_start();
            require $this->tpl;
            return ob_get_clean();
        }


    }