<?php


    namespace app\controllers;


    use app\models\Breadcrumbs;
    use app\models\Category;
    use app\widgets\filter\Filter;
    use ishop\App;
    use RedBeanPHP\R;
    use ishop\libs\Pagination;

    class CategoryController extends  AppController
    {
        public function viewAction()
        {
            // 1. alias and category name
            $alias = $this->route['alias'];
            $category = R::findOne('category', 'alias = ?', [$alias]);

            if(!$category){
                throw new \Exception('Страница не найдена', 404);
            }

            // 2. breadcrumbs & ids for all children categories
            $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);
            $cat_model = new Category();
            $ids = $cat_model->getIds($category->id);
            $ids = $ids ? ($ids . $category->id) : $category->id;
            $filterData['categoryIds'] = $ids;

            // 3. set products count per page & set products mode (grid or list)
            $perpage = isset($_COOKIE['productsPerPage']) ? $_COOKIE['productsPerPage'] : App::$app->getProperty('pagination');
            $productsMode = isset($_COOKIE['productsMode']) ? $_COOKIE['productsMode'] : 'products-grid';
            $productsPerPage = App::$app->getProperty('productsPerPage');

            if(isset($_GET['productsPerPage'])) // per page filter
            {
                if(in_array($_GET['productsPerPage'], App::$app->getProperty('productsPerPage')))
                {
                    setcookie('productsPerPage', $_GET['productsPerPage'], time() + 3600*24, '/');
                    $perpage = $_GET['productsPerPage'];
                }
            }

            if(isset($_GET['productsMode'])) // products mode (grid or list)
            {
                if(in_array($_GET['productsMode'], App::$app->getProperty('productsMode')))
                {
                    setcookie('productsMode', $_GET['productsMode'], time() + 3600*24, '/');
                }
                die;
            }

            // 4. filters for products
            $filter = null; $sql_part = '';
            if(!empty($_GET['filter']))
            {
                $filter = Filter::getFilter();

                if($filter){
                    $countGroups = Filter::countGroups($filter);
                    $sql_part = "AND id IN (
                    SELECT attribute_product.product_id
                    FROM attribute_product 
                    LEFT JOIN attribute_value ON attribute_value.id = attribute_product.attr_id
                    LEFT JOIN attribute_group ON attribute_group.id = attribute_value.attr_group_id
                    WHERE attribute_product.attr_id IN ({$filter})
                    GROUP BY  attribute_product.product_id
                    HAVING COUNT(DISTINCT attribute_value.attr_group_id) = {$countGroups}
                    )";
                }

                $filter = explode(',', $filter);

                /*
                 SELECT `product`.*  FROM `product`  WHERE category_id IN (4,6,7,19,5,8,9,10,1) AND
                 id IN (SELECT product_id FROM attribute_product WHERE attr_id IN (4,7))
                 GROUP BY product_id HAVING COUNT(product_id) = 2
                 */
            }

            $filterPrice = null;
            if(!empty($_GET['minPrice']) && $_GET['maxPrice'])
            {
              $sql_part .= " AND price >= {$_GET['minPrice']} AND price <= {$_GET['maxPrice']} ";
            }

            // 5. find total (with filters) & get pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $total = R::count('product', "category_id IN ($ids) AND status = 'visible' $sql_part");
            $pagination = new Pagination($page, $perpage, $total);
            $start =  $pagination->getStart();

            // 6. sort product by price, date and others
            $productSortDB = 'date_add DESC';
            $productsSort = App::$app->getProperty('productsSort');

            $sort = 'date_desc';
            if(!empty($_GET['sort']))
            {
                $sort = trim($_GET['sort']);

                switch ($sort){
                    case 'date_desc':
                        $productSortDB = 'date_add DESC';
                    break;
                    case 'price_desc':
                        $productSortDB = 'price DESC';
                    break;
                    case 'price_asc':
                        $productSortDB = 'price ASC';
                   break;
                }
            }
             $products = R::getAll("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img FROM product 
                                        LEFT JOIN product_base_img   ON product_base_img.product_id = product.id
                                        WHERE product.category_id IN ($ids) AND product.status = 'visible' $sql_part
                                        GROUP BY product.id ORDER BY $productSortDB LIMIT $start, $perpage");


             $productRangeCount = ($perpage*($pagination->currentPage-1)+1) ." - ". ($perpage*($pagination->currentPage-1) + count($products));

           // debug($products, 1);
           /* $logs = R::getDatabaseAdapter()
                ->getDatabase()
                ->getLogger();
            debug($logs);*/

            $filterPrice = R::getRow("SELECT MIN(price) AS minPrice, MAX(price) AS maxPrice
                  FROM `product` 
                  WHERE category_id IN($ids) AND status = 'visible'");

            $filterData['minPrice'] = $filterPrice['minPrice'];
            $filterData['maxPrice'] = $filterPrice['maxPrice'];


            if($this->isAjax())
            {
                $categoryViews['products'] = $this->loadViews('products', compact('products'));
                $categoryViews['productPagination'] = $this->loadViews('product_pagination', compact( 'pagination', 'total', 'productRangeCount'));
                $filterObj = new \app\widgets\filter\Filter($filterData);
                $categoryViews['productFilter'] = $filterObj->run();

                echo json_encode($categoryViews, true);
                die;
            }


            $this->setMeta($category->title, $category->description, $category->keywords);
            $this->set(compact('breadcrumbs', 'category', 'products',
                                        'pagination', 'total', 'perpage', 'productsPerPage',
                                        'productsSort', 'sort', 'productRangeCount', 'productsMode', 'filterData'));

        }

    }