<?php


namespace app\models\admin;

use app\models\AppModel;
use ishop\App;

class Category extends AppModel
{

    public $attributes = [
        'title' => '',
        'parent_id' => '',
        'keywords' => '',
        'description' => '',
        'text' => '',
        'alias' => ''
    ];

    public $rules = [
        'required' => [
            'title'
        ]
    ];

    public function getIds($id)
    {
        $cats = App::$app->getProperty('cats');
        // debug($cats);
        $ids = null;

        foreach ($cats as $k => $v)
        {
            if($v['parent_id'] == $id)
            {
                $ids .= $k . ',';
                $ids .= $this->getIds($k);
            }
        }

        return $ids;
    }

    public function getImg()
    {
        if(!empty($_SESSION['categoryImage'])){
            $this->attributes['img'] = $_SESSION['categoryImage'];
            unset($_SESSION['categoryImage']);
        }
    }

    public function uploadImg($name, $wmax, $hmax)
    {
        $uploaddir = WWW .'/upload/categories/';
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
            if($name == 'categoryImage'){
                $_SESSION['categoryImage'] = $new_name;
            }
           // self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            $res = array("file" => $new_name);
            exit(json_encode($res));
        }
    }


}