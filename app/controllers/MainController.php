<?php

    namespace app\controllers;

    use ishop\App;
    use RedBeanPHP\R as R;
    use ishop\Cache;

    class MainController extends AppController {

//    public $layout = 'test';

        public function indexAction(){
//        $this->layout = 'test';
//        echo __METHOD__;

        //    $brands = R::find('brand', 'LIMIT 3');

            $hits = R::getAll("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img FROM product 
                                        LEFT JOIN product_base_img ON product_base_img.product_id = product.id
                                        WHERE hit = 'yes' AND status = 'visible'
                                        GROUP BY product.id ORDER BY RAND() LIMIT 8");

            $novelty = R::getAll("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img FROM product 
                                        LEFT JOIN product_base_img ON product_base_img.product_id = product.id
                                        WHERE novelty = 'yes' AND status = 'visible'
                                        GROUP BY product.id ORDER BY RAND() LIMIT 8");

            //current currency
            $curr = App::$app->getProperty('currency');

            $canonical = PATH;

            //debug($hits);
            $this->set(compact( 'hits', 'novelty', 'curr', 'canonical'));

           // $this->setMeta(App::$app->getProperty("shop_name"), "Описание", "Ключевики");

          /*  $names = array('Mike', 'john');
            $name = 'Andrey';
            $age = 33;

            $cache = Cache::instance();
           // $cache->set('test', $names);
            $data = $cache->get('test');
           // debug($data);
*/
            //$this->set(compact('name','age', 'names'));
        }

    }