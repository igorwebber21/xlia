<?php


namespace app\controllers\admin;


use app\models\User;
use ishop\libs\Pagination;
use RedBeanPHP\R;

class UserController extends AppController
{

    public function indexAction()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage = 10;
        $count = R::count('user');
        $pagination = new Pagination($page, $perpage, $count);
        $start = $pagination->getStart();
        $users = R::findAll('user', "LIMIT $start, $perpage");

        $this->setMeta('Список пользователей');
        $this->set(compact('users', 'pagination', 'count'));
    }

    public function addAction()
    {
        $this->setMeta('Новый пользователь');
    }

    public function editAction()
    {
        if(!empty($_POST))
        {
            $id = $this->getRequestID(false);
            $user = new \app\models\admin\User();
            $data = $_POST;
            $user->load($data);
            if(!$user->attributes['password']){
                unset($user->attributes['password']);
            }else{
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            }
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();
                redirect();
            }
            if($user->update('user', $id)){
                $_SESSION['success'] = 'Изменения сохранены';
            }
            redirect();
        }

        $user_id = $this->getRequestID();
        $user = R::load('user', $user_id);

        $orders = R::getAll("SELECT `orders`.`id`, `orders`.`user_id`, `orders`.`status`, `orders`.`date`, `orders`.`update_at`, `orders`.`currency`, 
                                            ROUND(SUM(`order_product`.`price`), 2) AS `sum` 
                                   FROM `orders`
                                   JOIN `order_product` ON `orders`.`id` = `order_product`.`order_id`
                                   WHERE user_id = {$user_id} GROUP BY `orders`.`id` 
                                   ORDER BY `orders`.`status`, `orders`.`id`");

        $this->setMeta('Редактирование профиля пользователя');
        $this->set(compact('user', 'orders'));
    }

    public function loginAdminAction(){

        if(!empty($_POST))
        {
            $user = new User();
            if(!$user->login($_POST, true)){
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }

            if(User::isAdmin()){
                redirect(ADMIN);
            }else{
                redirect();
            }
        }
        $this->layout = 'login';
        $this->setMeta('Вход в админ панель');
    }

    public function deleteAction()
    {
        $user_id = $this->getRequestID();
        $user = R::load('user', $user_id);
        R::trash($user);
        $_SESSION['success'] = 'Пользователь удален';
        redirect(ADMIN . '/user');
    }
}