<?php


namespace app\controllers;


use ishop\libs\Pagination;
use RedBeanPHP\R;

class BlogController extends  AppController
{
  public function indexAction()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perpage = 6;
    $count = R::count('articles');
    $pagination = new Pagination($page, $perpage, $count);
    $start = $pagination->getStart();

    $articles = R::getAll("SELECT * FROM articles
                                        WHERE status = 'visible' ORDER BY date_add DESC LIMIT $start, $perpage");

    $this->setMeta('Блог');
    $this->set(compact('articles', 'pagination', 'count'));
  }

  public function viewAction()
  {
    $alias = $this->route['alias'];
    $article = R::findOne('articles', "alias = ?", [$alias]);

    $lastArticles = R::getAll("SELECT * FROM articles
                                        WHERE status = 'visible' AND id != ".$article['id']." ORDER BY date_add DESC LIMIT 4");

    //debug($article);
    $this->setMeta('Блог');

    $this->set(compact('article', 'lastArticles'));

  }

}