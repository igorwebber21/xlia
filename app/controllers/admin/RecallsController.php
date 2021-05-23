<?php


namespace app\controllers\admin;


use ishop\libs\Pagination;
use RedBeanPHP\R;

class RecallsController extends AppController
{

  public function indexAction()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perpage = 15;
    $count = R::count('recalls');
    $pagination = new Pagination($page, $perpage, $count);
    $start = $pagination->getStart();
    $recalls = R::getAll("SELECT * FROM recalls ORDER BY recalls.id DESC  LIMIT $start, $perpage");

    $this->setMeta('Заявки "Перезвоните мне"');
    $this->set(compact('recalls', 'pagination', 'count'));

  }

  public function deleteAction()
  {
    $recall_id = $this->getRequestID();
    $recall= R::load('recalls', $recall_id);
    R::trash($recall);

    $_SESSION['success'] = 'Заявка удалена';
    redirect(ADMIN . '/recalls');
  }

  public function changeAction()
  {
    $recall_id = $this->getRequestID();
    $status = !empty($_GET['status'])  && $_GET['status'] == 1 ? 'completed' : 'new';
    $recall = R::load('recalls', $recall_id);
    if(!$recall){
      throw new \Exception('Страница не найдена', 404);
    }

    R::exec( "UPDATE recalls SET status='{$status}' WHERE id = {$recall_id}");

    $_SESSION['success'] = 'Изменения сохранены';
    redirect();
  }

}