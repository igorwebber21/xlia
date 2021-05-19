<?php

    namespace app\controllers;

    use app\models\AppModel;
    use app\widgets\currency\Currency;
    use ishop\App;
    use ishop\base\Controller;
    use ishop\Cache;
    use RedBeanPHP\R;

    class AppController extends Controller
    {
        public $responseData = [
            'status' => 0,
            'message' => ''
        ];

        public function __construct($route)
        {
            parent::__construct($route);
            new AppModel();
            App::$app->setProperty('currencies', Currency::getCurrencies());

            App::$app->setProperty('currency', Currency::getCurrency(App::$app->getProperty('currencies')));

            App::$app->setProperty('cats', self::cacheCategory());

//            $cats = R::getAssoc("SELECT * FROM category");
//            debug($cats);


            //debug( App::$app->getProperties());
        }

        public static function cacheCategory(){
            $cache = Cache::instance();
            $cats =  $cache->get('cats');

            if(!$cats){
                $cats = R::getAssoc("SELECT * FROM category");
                $cache->set('cats', $cats);
            }

            return $cats;
        }

        public static function sendResponse($data)
        {
            echo json_encode($data);
            exit;
        }

        public static function productSortDB()
        {
          $productSortDB = 'product.date_add DESC';

          if(!empty($_GET['sort']))
          {
            $sort = trim($_GET['sort']);

            switch ($sort){
              case 'date_desc':
                $productSortDB = 'product.date_add DESC';
                break;
              case 'price_desc':
                $productSortDB = 'product.price DESC';
                break;
              case 'price_asc':
                $productSortDB = 'product.price ASC';
                break;
            }
          }

          return $productSortDB;
        }

        public static function productSort()
        {
          $sort = 'date_desc';

          if(!empty($_GET['sort']))
          {
            $sort = trim($_GET['sort']);

            switch ($sort){
              case 'price_desc':
                $sort = 'price_desc';
                break;
              case 'price_asc':
                $sort = 'price_asc';
                break;
            }
          }

          return $sort;
        }

        public static function getProductPerpage()
        {
          $perpage = isset($_COOKIE['productsPerPage']) ? $_COOKIE['productsPerPage'] : App::$app->getProperty('pagination');

          if(isset($_GET['productsPerPage'])) // per page filter
          {
            if(in_array($_GET['productsPerPage'], App::$app->getProperty('productsPerPage')))
            {
              setcookie('productsPerPage', $_GET['productsPerPage'], time() + 3600*24, '/');
              $perpage = $_GET['productsPerPage'];
            }
          }

          return $perpage;
        }

        public static function getProductMode()
        {
          $productsMode = isset($_COOKIE['productsMode']) ? $_COOKIE['productsMode'] : 'products-grid';

          if(isset($_GET['productsMode'])) // products mode (grid or list)
          {
            if(in_array($_GET['productsMode'], App::$app->getProperty('productsMode')))
            {
              setcookie('productsMode', $_GET['productsMode'], time() + 3600*24, '/');
            }
            die;
          }

          return $productsMode;
        }




    }