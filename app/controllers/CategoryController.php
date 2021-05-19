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

            // 3. get product sort parameters
            $productsSort = App::$app->getProperty('productsSort');
            $sort = self::productSort();
            $productSortDB = self::productSortDB();
            $productsPerPage = App::$app->getProperty('productsPerPage');
            $perpage = self::getProductPerpage();
            $productsMode = self::getProductMode();

            // 4. filters for products
            $filter = null; $sql_part = '';
            if(!empty($_GET['filter']))
            {
                $filter = Filter::getFilter();

                if($filter){
                    $countGroups = Filter::countGroups($filter);
                    $sql_part = "AND product.id IN (
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
            }

            $filterPrice = null;
            if(!empty($_GET['minPrice']) && $_GET['maxPrice'])
            {
              $sql_part .= " AND product.price >= {$_GET['minPrice']} AND product.price <= {$_GET['maxPrice']} ";
            }

            // 5. find total (with filters) & get pagination
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $total = R::count('product', "category_id IN ($ids) AND status = 'visible' $sql_part");
            $pagination = new Pagination($page, $perpage, $total);
            $start =  $pagination->getStart();

            $products = R::getAll("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img FROM product 
                                        LEFT JOIN product_base_img ON product_base_img.product_id = product.id
                                        WHERE product.category_id IN ($ids) AND product.status = 'visible' $sql_part
                                        GROUP BY product.id ORDER BY $productSortDB LIMIT $start, $perpage");

            $productRangeCount = ($perpage*($pagination->currentPage-1)+1) ." - ". ($perpage*($pagination->currentPage-1) + count($products));

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