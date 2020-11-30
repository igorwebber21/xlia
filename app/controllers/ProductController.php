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

            //current cats
            $cats = App::$app->getProperty('cats');

            $alias = $this->route['alias'];
            $product = R::findOne('product', "alias = ? AND status ='visible'", [$alias]);
           // debug($product);

            if(!$product){
                throw new \Exception('Страница не найдена', 404);
            }

            // breadcrumbs
            $breadcrumbs = Breadcrumbs::getBreadcrumbs($product->category_id, $product->title);

            // related products
            $related = R::getAll("SELECT * FROM related_product JOIN product 
                                       ON product.id = related_product.related_id 
                                       WHERE related_product.product_id = ?", [$product->id]);
            //debug($related);

            // add to cookie selected product
            $p_model = new Product();
            $p_model->setRecentlyViewed($product->id);

            // viewed products
            $r_viewed = $p_model->getRecentlyViewed($product->id);
            //debug($r_viewed);
            $recentlyViewed = null;
            if($r_viewed){
                $recentlyViewed = R::find('product', ' id IN (' . R::genSlots($r_viewed). ') LIMIT 3', $r_viewed);
                $recentlyViewed = object_to_array($recentlyViewed);
                $recentlyViewed = $p_model->sortRecentlyViewed($r_viewed, $recentlyViewed);
            }
            //$p_model->deleteRecentlyViewed();
            //debug($recentlyViewed);

            // gallery
            $gallery = R::findAll("gallery", 'product_id = ? ', [$product->id]);
            //debug($gallery);

            // modifications
            $modes = R::findAll('modification', 'product_id = ?', [$product->id]);
            //debug(object_to_array($modes));

            $this->setMeta($product->title, $product->description, $product->keywords);
            $this->set(compact('product', 'curr', 'cats', 'related', 'gallery', 'recentlyViewed', 'breadcrumbs', 'modes'));
        }
    }