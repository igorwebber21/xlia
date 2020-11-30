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
        public function viewAction(){

            $alias = $this->route['alias'];
            $category = R::findOne('category', 'alias = ?', [$alias]);
           // debug($category);

            if(!$category){
                throw new \Exception('Страница не найдена', 404);

            }

            // breadcrumbs
            $breadcrumbs = Breadcrumbs::getBreadcrumbs($category->id);
            $cat_model = new Category();
            $ids = $cat_model->getIds($category->id);
            $ids = $ids ? ($ids . $category->id) : $category->id;

            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $perpage = App::$app->getProperty('pagination');

            // filters
            $filter = null; $sql_part = '';
            if(!empty($_GET['filter'])){
                $filter = Filter::getFilter();

                if($filter){
                    $countGroups = Filter::countGroups($filter);
                    $sql_part = "AND id IN (
                    SELECT product_id FROM attribute_product WHERE attr_id IN ($filter)
                    GROUP BY product_id HAVING COUNT(product_id) = $countGroups
                    )";
                }

                /*
                 SELECT `product`.*  FROM `product`  WHERE category_id IN (4,6,7,19,5,8,9,10,1) AND
                 id IN (SELECT product_id FROM attribute_product WHERE attr_id IN (4,7))
                 GROUP BY product_id HAVING COUNT(product_id) = 2
                 */
            }

            $total = R::count('product', "category_id IN ($ids) AND status = 'visible' $sql_part");
            $pagination = new Pagination($page, $perpage, $total);
            $start =  $pagination->getStart();

            $products = R::find('product', "category_id IN ($ids) AND status = 'visible' $sql_part LIMIT $start, $perpage");

           /* $logs = R::getDatabaseAdapter()
                ->getDatabase()
                ->getLogger();
            debug($logs);*/

            if($this->isAjax())
            {
                $this->loadView('filter', compact('products', 'pagination', 'total'));
            }

            $this->setMeta($category->title, $category->description, $category->keywords);
            $this->set(compact('products', 'breadcrumbs', 'pagination', 'total'));
           //die();

        }
    }