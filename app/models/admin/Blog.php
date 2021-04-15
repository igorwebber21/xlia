<?php


namespace app\models\admin;

use app\models\AppModel;
use ishop\App;
use ishop\libs\Thumbs;

class Blog extends AppModel
{

  public $attributes = [
    'name' => '',
    'title' => '',
    'text' => '',
    'alias' => ''
  ];

  public $rules = [
    'required' => [
      'name'
    ]
  ];

  public function getImages()
  {
    if(!empty($_SESSION['blog_img_preview'] )){
      $this->attributes['img_preview'] = $_SESSION['blog_img_preview'];
    }

    if(!empty($_SESSION['blog_img_full'] )){
      $this->attributes['img_full'] = $_SESSION['blog_img_full'];
    }

  }

  public function uploadImg($name, $wmax, $hmax)
  {
    $subdir = ($name == 'blog_preview') ? 'preview/' : 'full/';
    $uploaddir = WWW .'/upload/blog/'. $subdir;
    $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$name]['name'])); // расширение картинки
    $types = array("image/gif", "image/png", "image/jpeg", "image/pjpeg", "image/x-png"); // массив допустимых расширений
    if($_FILES[$name]['size'] > 2048576){
      $res = array("error" => "Ошибка! Максимальный вес файла - 2 Мб!");
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
      if($name == 'blog_preview'){
         $_SESSION['blog_img_preview'] = $new_name;
      }
      else{
         $_SESSION['blog_img_full'] = $new_name;
      }

      $thumbsObj = new Thumbs($uploadfile);
      $thumbsObj->resize($wmax, $hmax);
      $thumbsObj->save();

      $res = array("file" => $new_name);
      exit(json_encode($res));
    }
  }

}