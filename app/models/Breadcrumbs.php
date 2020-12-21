<?php

    namespace app\models;

    use ishop\App;

    class Breadcrumbs{

        public static function getBreadcrumbs($category_id, $product_name = ''){
            $cats = App::$app->getProperty('cats');
            $breadcrumbs_array = self::getParts($cats, $category_id);
           // debug($cats);
            //debug($breadcrumbs_array);
            $breadcrumbs = "<li><a href='" . PATH . "'><i class=\"icon icon-home\"></i></a></li>";
            if($breadcrumbs_array){ $counter = 1;
                foreach($breadcrumbs_array as $alias => $title)
                {
                    $breadcrumbs .= ($counter == count($breadcrumbs_array) && !$product_name)
                        ? "<span> / </span><li>{$title}</li>"
                        : "<span> / </span><li><a href='" . PATH . "/category/{$alias}'>{$title}</a></li>";

                    $counter++;
                }
            }
            if($product_name){
                $breadcrumbs .= "<span> / </span> <li>$product_name</li>";
            }
            return $breadcrumbs;
        }

        public static function getParts($cats, $id){
            if(!$id) return false;
            $breadcrumbs = [];
            // формируем дерево категории товара и подкатегорий
            foreach($cats as $k => $v){
                if(isset($cats[$id])){
                    $breadcrumbs[$cats[$id]['alias']] = $cats[$id]['title'];
                    $id = $cats[$id]['parent_id'];
                }else break;
            }
            return array_reverse($breadcrumbs, true);
        }

    }