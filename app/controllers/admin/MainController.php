<?php


namespace app\controllers\admin;


use RedBeanPHP\R;

class MainController extends AppController
{
    public function indexAction()
    {
        $countNewOrders = R::count('orders', "status = 'new'");
        $countUsers = R::count('user');
        $countProducts = R::count('product');
        $countCategories = R::count('category');

        $this->set(compact('countNewOrders', 'countUsers', 'countProducts', 'countCategories'));

        $this->setMeta('Админ панель');
    }
}