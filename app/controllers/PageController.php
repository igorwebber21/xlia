<?php

namespace app\controllers;


use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;

class PageController extends AppController
{

  public function viewAction()
  {

    $currPage = R::findOne('pages', 'alias = ?', [$this->route['alias']]);
    $currPage = object_to_array($currPage);
    if($currPage){

    }
    else{
      throw new \Exception("Страница не найдена", 404);
    }

    /*$existPage = in_array($this->route['alias'], $pages);

    if($existPage)
    {
      echo $this->route['alias'];

      $this->setMeta(App::$app->getProperty("shop_name"), "Описание", "Ключевики");

      $name = 'Андрей';
      $title = 'Тестовый шаблон';

      if(isset($this->route['lang']) && $this->route['lang'])
      {
        if($this->route['lang'] == 'ru'){
          $name = 'Привет, Андрей';
          $title = 'Тестовый шаблон';
        }
        elseif($this->route['lang'] == 'ua'){
          $name = 'Привiт, Андрiю';
          $title = 'Шаблон для тестiв';
        }
        elseif($this->route['lang'] == 'en'){
          $name = 'Hello, Andrey';
          $title = 'Test template';
        }

      }
      $cache = Cache::instance();
      // $cache->set('test', $names);
      $data = $cache->get('test');
      debug($data);

      $this->set(compact('name','title'));

    }
    else{
      throw new \Exception("Страница не найдена", 404);
    }*/

    $this->set(compact('currPage'));

  }

}

?>
