<?php

    namespace app\models;

    class Product extends AppModel {

        //установить просмотренный товар
        public function setRecentlyViewed($id){
            $recentlyViewed = $this->getAllRecentlyViewed();

            //debug($recentlyViewed);
            //если нет просмотренных товаров
            if(!$recentlyViewed){
                setcookie('recentlyViewed', $id, time() + 3600*24, '/');
            }else{

                $recentlyViewed = explode('.', $recentlyViewed);
               // debug($recentlyViewed);
                if(!in_array($id, $recentlyViewed)){
                    $recentlyViewed[] = $id;
                    $recentlyViewed = implode('.', $recentlyViewed);
                    setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, '/');
                }
                else{ // если продукт уже в просмотренных - поместить на последнее место в массиве
                    unset($recentlyViewed[array_search($id, $recentlyViewed)]);
                    $recentlyViewed[] = $id;
                    $recentlyViewed = implode('.', $recentlyViewed);
                    setcookie('recentlyViewed', $recentlyViewed, time() + 3600*24, '/');
                    //echo $recentlyViewed;
                }
            }
        }

        // взять все просмотренные кроме текущего товара
        public function getRecentlyViewed($product_id = false){

            if(!empty($_COOKIE['recentlyViewed'])){

                $recentlyViewed = $_COOKIE['recentlyViewed'];
                $recentlyViewed = explode('.', $recentlyViewed);

                if($product_id){
                    unset($recentlyViewed[array_search($product_id, $recentlyViewed)]);
                }

                return array_reverse($recentlyViewed);
            }
            return false;
        }

        // все просмотренные товары
        public function getAllRecentlyViewed(){
            if(!empty($_COOKIE['recentlyViewed'])){
                return $_COOKIE['recentlyViewed'];
            }
            return false;
        }


        // сортировка просмотренных товаров начиная с последнего просмотренного
        public function sortRecentlyViewed($r_viewed, $recentlyViewed)
        {
            $recentlyViewedSorted = array();
            foreach ($r_viewed as $item) {
                foreach ($recentlyViewed as $item2) {
                    if ($item == $item2['id']) {
                        $recentlyViewedSorted[] = $item2;
                    }
                }
            }

            return $recentlyViewedSorted;
        }

        public function deleteRecentlyViewed()
        {

            $recentlyViewed = $this->getAllRecentlyViewed();
            if($recentlyViewed){
                setcookie('recentlyViewed', '', time() + 3600*24, '/');
            }
        }

    }