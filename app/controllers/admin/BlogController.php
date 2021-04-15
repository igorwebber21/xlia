<?php


namespace app\controllers\admin;


use app\models\admin\Blog;
use app\models\AppModel;
use ishop\App;
use ishop\Cache;
use ishop\libs\Pagination;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class BlogController extends AppController
{

  public function indexAction()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perpage = 15;
    $count = R::count('articles');
    $pagination = new Pagination($page, $perpage, $count);
    $start = $pagination->getStart();
    $articles = R::getAll("SELECT * FROM articles
                                     ORDER BY date_add DESC LIMIT $start, $perpage");

    $this->setMeta('Список статей');
    $this->set(compact('articles', 'pagination', 'count'));

  }

  public function addAction()
  {
    if(!empty($_POST))
    {
      $blog = new Blog();
      $data = $_POST;
      $blog->load($data);
      $blog->attributes['date_add'] = date('Y-m-d H:i');
      $blog->getImages();

      if(!$blog->validate($data))
      {
        $blog->getErrors();
      }
      if($id = $blog->save('articles'))
      {
        $alias = AppModel::createAlias('articles', 'alias', $data['name'], $id);
        $loadedArticle = R::load('articles', $id);
        $loadedArticle->alias = $alias;
        R::store($loadedArticle);

        $_SESSION['success'] = 'Статья добавлена';
      }

      redirect(ADMIN.'/blog/add');
    }
    $this->setMeta('Новая статья');
  }

  public function editAction()
  {

    if(!empty($_POST))
    {
      $id = $this->getRequestID(false);
      $blog = new Blog();
      $data = $_POST;
      $blog->load($data);
      $blog->getImages();

      if(!$blog->validate($data)){
        $blog->getErrors();
        redirect();
      }

      if($blog->update('articles', $id))
      {
        $alias = AppModel::createAlias('articles', 'alias', $data['name'], $id);
        $loadedArticle = R::load('articles', $id);
        $loadedArticle->alias = $alias;
        R::store($loadedArticle);

        $_SESSION['success'] = 'Изменения сохранены';
        redirect();
      }
    }

    unset($_SESSION['blog_img_preview']);
    unset($_SESSION['blog_img_full']);

    $id = $this->getRequestID();
    $article = R::load('articles', $id);
    $this->setMeta("Редактирование статьи {$article->name}");
    $this->set(compact('article'));
  }

  public function deleteAction()
  {
    $article_id = $this->getRequestID();
    $article = R::load('articles', $article_id);
    R::trash($article);

    $_SESSION['success'] = 'Статья удалена';
    redirect(ADMIN . '/blog');
  }

  public function addPreviewImgAction()
  {
    if(isset($_GET['upload']))
    {
      if($_POST['name'] == 'blog_preview')
      {
        $vmax = App::$app->getProperty('blog_img_width');
        $hmax = App::$app->getProperty('blog_img_height');
      }

      $name = $_POST['name'];
      $blog = new Blog();
      $blog->uploadImg($name, $vmax, $hmax);
    }
  }

  public function addFullImgAction()
  {
    if(isset($_GET['upload']))
    {
      if($_POST['name'] == 'blog_full')
      {
        $vmax = App::$app->getProperty('blog_full_img_width');
        $hmax = App::$app->getProperty('blog_full_img_height');
      }

      $name = $_POST['name'];
      $blog = new Blog();
      $blog->uploadImg($name, $vmax, $hmax);
    }
  }

}