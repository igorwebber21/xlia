<?php

namespace app\controllers\admin;

use app\models\admin\Currency;
use RedBeanPHP\R;

class CurrencyController extends AppController
{

    public function indexAction()
    {
        $currencies = R::findAll('currency');
        $this->setMeta('Валюты магазина');
        $this->set(compact('currencies'));
    }

    public function addAction()
    {
        if(!empty($_POST))
        {
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? 'yes' : 'no';

            if(!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if($currency->save('currency')){
                $_SESSION['success'] = 'Валюта добавлена';
                redirect();
            }
        }
        $this->setMeta('Новая валюта');
    }

    public function editAction()
    {
        if(!empty($_POST))
        {
            $id = $this->getRequestID(false);
            $currency = new Currency();
            $data = $_POST;
            $currency->load($data);
            $currency->attributes['base'] = $currency->attributes['base'] ? 'yes' : 'no';
            if(!$currency->validate($data)){
                $currency->getErrors();
                redirect();
            }
            if($currency->update('currency', $id)){
                $_SESSION['success'] = "Изменения сохранены";
                redirect();
            }
        }

        $id = $this->getRequestID();
        $currency = R::load('currency', $id);
        $this->setMeta("Редактирование валюты {$currency->title}");
        $this->set(compact('currency'));
    }

    public function deleteAction()
    {
        $id = $this->getRequestID();

        R::exec('DELETE FROM currency WHERE id = ?', [$id]);
        $_SESSION['success'] = 'Валюта удалена';
        redirect();
    }

}