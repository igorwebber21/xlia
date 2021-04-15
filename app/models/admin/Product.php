<?php

namespace app\models\admin;

use app\models\AppModel;
use RedBeanPHP\R;

class Product extends AppModel {

    public $attributes = [
      'title' => '',
      'category_id' => '',
      'keywords' => '',
      'description' => '',
      'price' => '',
      'old_price' => '',
      'content' => '',
      'status' => '',
      'hit' => '',
      'alias' => ''
    ];

    public $rules = [
      'required' => [
          ['title'],
          ['category_id'],
          ['price']
      ],
      'integer' => [
          ['category_id']
      ]
    ];

    public function editRelatedProduct($id, $data)
    {
        $related_product = R::getCol('SELECT related_id FROM related_product WHERE product_id = ?', [$id]);

        // если менеджер убрал связанные товары - удаляем их
        if(empty($data['related']) && !empty($related_product))
        {
            R::exec("DELETE FROM related_product WHERE product_id = ?", [$id]);
            return;
        }
        // если добавляются связанные товары
        if(empty($related_product) && !empty($data['related']))
        {
            $sql_part = '';
            foreach($data['related'] as $v){
                $v = (int)$v;
                $sql_part .= "($id, $v),";
            }
            $sql_part = rtrim($sql_part, ',');
            R::exec("INSERT INTO related_product (product_id, related_id) VALUES $sql_part");
            return;
        }
        // если изменились связанные товары - удалим и запишем новые
        if(!empty($data['related']))
        {
            $result = array_diff($related_product, $data['related']);
            if(!empty($result) || count($related_product) != count($data['related']))
            {
                R::exec("DELETE FROM related_product WHERE product_id = ?", [$id]);
                $sql_part = '';
                foreach($data['related'] as $v)
                {
                    $v = (int)$v;
                    $sql_part .= "($id, $v),";
                }
                $sql_part = rtrim($sql_part, ',');
                R::exec("INSERT INTO related_product (product_id, related_id) VALUES $sql_part");
            }
        }
    }

    public function editFilter($id, $data)
    {
        $filter = R::getCol('SELECT attr_id FROM attribute_product WHERE product_id = ?', [$id]);

        if($filter){
            R::exec('DELETE FROM attribute_product WHERE product_id = ?', [$id]);
        }

        if(!empty($data['attrs']))
        {
            $sql_part = '';
            foreach ($data['attrs'] as $group)
            {
                foreach ($group as $attr)
                {
                    $sql_part .= "($attr, $id),";
                }
            }

            $sql_part = rtrim($sql_part, ',');
            R::exec("INSERT INTO attribute_product (attr_id, product_id) VALUES {$sql_part}");
            return;
        }


        // 1. if there are no filters in form
//        if(empty($data['attrs']) && !empty($filter))
//        {
//            R::exec('DELETE FROM attribute_product WHERE product_id = ?', [$id]);
//            return;
//        }
//
//        // 2. if added new filters
//        if(empty($filter) && !empty($data['attrs']))
//        {
//            $sql_part = '';
//            foreach ($data['attrs'] as $attr)
//            {
//                $sql_part .= "($attr, $id),";
//            }
//
//            $sql_part = rtrim($sql_part, ',');
//            R::exec("INSERT INTO attribute_product (attr_id, product_id) VALUES {$sql_part}");
//            return;
//        }
//
//        // 3. if filters changed in form
//        if(!empty($data['attrs']))
//        {
//            $result = array_diff($filter, $data['attrs']);
//
//            if($result || count($filter) != count($data['attrs']))
//            {
//                R::exec('DELETE FROM attribute_product WHERE product_id = ?', [$id]);
//                $sql_part = '';
//                foreach ($data['attrs'] as $attr)
//                {
//                    $sql_part .= "($attr, $id),";
//                }
//
//                $sql_part = rtrim($sql_part, ',');
//                R::exec("INSERT INTO attribute_product (attr_id, product_id) VALUES {$sql_part}");
//                return;
//            }
//        }

    }

    public function getImg()
    {
      if(!empty($_SESSION['baseImg'] )){
        $this->attributes['img'] = $_SESSION['baseImg'];
      }
    }

    public function saveBaseImg($id)
    {
      if(!empty($_SESSION['single']))
      {
        $sql_part = '';
        foreach($_SESSION['single'] as $v){
          $sql_part .= "('$v', $id),";
        }
        $sql_part = rtrim($sql_part, ',');
        R::exec("INSERT INTO product_base_img (img, product_id) VALUES $sql_part");
        unset($_SESSION['single']);
      }
    }

    public function saveGallery($id)
    {
        if(!empty($_SESSION['multi']))
        {
            $sql_part = '';
            foreach($_SESSION['multi'] as $v){
                $sql_part .= "('$v', $id),";
            }
            $sql_part = rtrim($sql_part, ',');
            R::exec("INSERT INTO gallery (img, product_id) VALUES $sql_part");
            unset($_SESSION['multi']);
        }
    }

    public function uploadImg($name, $wmax, $hmax, $baseImg = false)
    {
        $subdir = ($name == 'single') ? 'base/' : 'gallery/';
        $uploaddir = WWW .'/upload/products/'. $subdir;
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name'])); // расширение картинки
        $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений
        if($_FILES[$name]['size'] > 1048576){
            $res = array("error" => "Ошибка! Максимальный вес файла - 1 Мб!");
            exit(json_encode($res));
        }
        if($_FILES[$name]['error']){
            $res = array("error" => "Ошибка! Возможно, файл слишком большой.");
            exit(json_encode($res));
        }
        if(!in_array($_FILES[$name]['type'], $types)){
            $res = array("error" => "Допустимые расширения - .gif, .jpg, .png");
            exit(json_encode($res));
        }
        $new_name = md5(time()).".$ext";
        $uploadfile = $uploaddir.$new_name;
        if(@move_uploaded_file($_FILES[$name]['tmp_name'], $uploadfile))
        {
            if($name == 'single'){
                $_SESSION['single'][] = $new_name;
                if($baseImg == true){
                  $_SESSION['baseImg'] = $new_name;
                }
            }else{
                $_SESSION['multi'][] = $new_name;
            }
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = array("file" => $new_name);
            exit(json_encode($res));
        }
    }
}