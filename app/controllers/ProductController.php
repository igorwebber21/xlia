<?php


    namespace app\controllers;


    use app\models\Breadcrumbs;
    use app\models\Product;
    use ishop\App;
    use RedBeanPHP\R;

    class ProductController extends AppController
    {
        public function viewAction()
        {
            //current currency
            $curr = App::$app->getProperty('currency');

            $alias = $this->route['alias'];
            $product = R::findOne('product', "alias = ? AND status ='visible'", [$alias]);
           // debug($product);

            $category = R::findOne('category', "id = ?", [$product['category_id']]);

            if(!$product){
                throw new \Exception('Страница не найдена', 404);
            }

            // breadcrumbs
            $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

            // related products
            $related = R::getAll("SELECT related_product.*, product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img
                                       FROM related_product 
                                       LEFT JOIN product ON product.id = related_product.related_id 
                                       LEFT JOIN product_base_img ON product_base_img.product_id = product.id
                                       WHERE related_product.product_id = ?  GROUP BY product.id", [$product->id]);

            //unset($_COOKIE['recentlyViewed']);

            // add to cookie selected product
            $p_model = new Product();
            $p_model->setRecentlyViewed($product->id);

            // viewed products
            $r_viewed = $p_model->getRecentlyViewed($product->id);
            //debug($r_viewed);
            $recentlyViewed = null;
            if($r_viewed){

              //$recentlyViewed = R::find('product', ' id IN (' . R::genSlots($r_viewed). ') LIMIT 3', $r_viewed);
              $recentlyIds = implode(',', $r_viewed);
              $recentlyViewed = R::getAll("SELECT product.*, GROUP_CONCAT(product_base_img.img SEPARATOR ',') AS base_img
                                       FROM product 
                                       LEFT JOIN product_base_img ON product_base_img.product_id = product.id
                                       WHERE product.id IN(".$recentlyIds.") GROUP BY product.id");

                $recentlyViewed = object_to_array($recentlyViewed);
                $recentlyViewed = $p_model->sortRecentlyViewed($r_viewed, $recentlyViewed);
            }

            // gallery
            $gallery = R::findAll("gallery", 'product_id = ? ', [$product->id]);

           // debug($related);

            // modifications
            $modes = R::findAll('modification', 'product_id = ?', [$product->id]);
            //debug(object_to_array($modes));

            $this->setMeta($product->title, $product->description, $product->keywords);
            $this->set(compact('category', 'product', 'curr', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs', 'modes'));
        }
    }