<?php


namespace app\controllers\admin;


use ishop\libs\Pagination;
use RedBeanPHP\R;


class TryonController extends AppController
{

  public function indexAction()
  {
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $perpage = 15;
    $count = R::count('tryon');

    $pagination = new Pagination($page, $perpage, $count);
    $start = $pagination->getStart();
    $tryon = R::getAll("SELECT tryon.*, product.title AS productTitle, GROUP_CONCAT(product_base_img.img) AS imgs
                            FROM tryon 
                            LEFT JOIN product ON product.id = tryon.product_id
                            LEFT JOIN product_base_img ON product_base_img.product_id = product.id 
                            GROUP BY product.id ORDER BY tryon.id DESC LIMIT $start, $perpage");

    $this->setMeta('Заявки на примерку товара');
    $this->set(compact('tryon', 'pagination', 'count'));

  }

  public function deleteAction()
  {
    $tryon_id = $this->getRequestID();
    $tryon = R::load('tryon', $tryon_id);
    R::trash($tryon);

    $_SESSION['success'] = 'Заявка удалена';
    redirect(ADMIN . '/tryon');
  }

  public function changeAction()
  {
    $tryon_id = $this->getRequestID();
    $status = !empty($_GET['status']) && $_GET['status'] == 1 ? 'completed' : 'new';
    $tryon = R::load('tryon', $tryon_id);
    if (!$tryon) {
      throw new \Exception('Страница не найдена', 404);
    }

    R::exec("UPDATE tryon SET status='{$status}' WHERE id = {$tryon_id}");

    $_SESSION['success'] = 'Изменения сохранены';
    redirect();
  }

}