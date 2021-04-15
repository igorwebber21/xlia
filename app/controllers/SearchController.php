<?php

namespace app\controllers;

use ishop\App;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class SearchController extends AppController{

    public function typeaheadAction()
    {
        if($this->isAjax()){
            $query = !empty(trim($_GET['query'])) ? trim($_GET['query']) : null;
            if($query){
                $products = R::getAll("SELECT id, title FROM product WHERE status = 'visible' AND title LIKE ? LIMIT 11", ["%{$query}%"]);
                echo json_encode($products);
            }
        }
        die;
    }

    public function indexAction()
    {
        $query = !empty(trim($_GET['s'])) ? trim($_GET['s']) : null;

        $this->setMeta('Поиск по: ' . h($query));

        // get product sort parameters
        $productsSort = App::$app->getProperty('productsSort');
        $sort = self::productSort();
        $productSortDB = self::productSortDB();
        $productsPerPage = App::$app->getProperty('productsPerPage');
        $perpage = self::getProductPerpage();
        $productsMode = self::getProductMode();

        // get pagination parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $total = R::count('product', "status = 'visible' AND title LIKE ?", ["%{$query}%"]);
        $pagination = new Pagination($page, $perpage, $total);
        $start =  $pagination->getStart();

        if($query){
          $products = R::getAll("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img FROM product 
                                          LEFT JOIN product_base_img   ON product_base_img.product_id = product.id
                                          WHERE product.status = 'visible' AND title LIKE ?
                                          GROUP BY product.id ORDER BY $productSortDB LIMIT $start, $perpage", ["%{$query}%"]);
        }

        $productRangeCount = ($perpage*($pagination->currentPage-1)+1) ." - ". ($perpage*($pagination->currentPage-1) + count($products));

        if($this->isAjax())
        {
          $categoryViews['products'] = $this->loadViews('products', compact('products'));
          $categoryViews['productPagination'] = $this->loadViews('product_pagination', compact( 'pagination', 'total', 'productRangeCount'));

          echo json_encode($categoryViews, true);
          die;
        }

        $this->set(compact('products', 'query', 'pagination', 'total', 'perpage', 'productsPerPage',
          'productsSort', 'sort', 'productRangeCount', 'productsMode'));
    }

}