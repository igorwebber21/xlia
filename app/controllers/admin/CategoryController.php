<?php


namespace app\controllers\admin;


use app\models\admin\Product;
use app\models\AppModel;
use app\models\Category;
use ishop\App;
use ishop\Cache;
use RedBeanPHP\R;
use RedBeanPHP\RedException\SQL;

class CategoryController extends AppController
{
    public function indexAction()
    {
        $this->setMeta('Список категорий');
    }

    public function deleteAction()
    {
        $id = $this->getRequestID();
        $children = R::count('category', 'parent_id = ?', [$id]);
        $errors = '';
        if($children){
            $errors .= '<li>Удаление невозможно, в категории есть вложенные категории</li>';
        }
        $products = R::count('product', 'category_id = ?', [$id]);
        if($products){
            $errors .= '<li>Удаление невозможно, в категории есть товары</li>';
        }
        if($errors){
            $_SESSION['error'] = "<ul>$errors</ul>";
            redirect();
        }
        $category = R::load('category', $id);
        R::trash($category);
        $cache = Cache::instance();
        $cache->delete('cats');
        $cache->delete('ishop_menu');
        $_SESSION['success'] = 'Категория удалена';
        redirect();
    }

    public function addAction()
    {
        if(!empty($_GET['parent_id']))
        {
            App::$app->setProperty('parent_id', $_GET['parent_id']);
        }
        if(!empty($_POST))
        {
            $category = new \app\models\admin\Category();
            $data = $_POST;
            $category->load($data);
            $category->getImg();

            if(!$category->validate($data))
            {
                $category->getErrors();
            }
            if($id = $category->save('category'))
            {
                $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                $cat = R::load('category', $id);
                $cat->alias = $alias;

                try {
                    R::store($cat);
                } catch (SQL $e) {}

                $cache = Cache::instance();
                $cache->delete('cats');
                $cache->delete('ishop_menu');

                $_SESSION['success'] = 'Категория добавлена';
            }

            redirect(ADMIN.'/category/add?parent_id='.$_POST['parent_id']);
        }
        $this->setMeta('Новая категория');
    }

    public function addImageAction()
    {
        if(isset($_GET['upload']))
        {
            if($_POST['name'] == 'categoryImage')
            {
                $vmax = App::$app->getProperty('category_width');
                $hmax = App::$app->getProperty('category_height');
            }

            $name = $_POST['name'];
            $product = new \app\models\admin\Category();
            $product->uploadImg($name, $vmax, $hmax);
        }
    }

    public function editAction()
    {
        if(!empty($_POST))
        {
            $id = $this->getRequestID(false);
            $category = new \app\models\admin\Category();
            $data = $_POST;
            $category->load($data);
            $category->getImg();

            if(!$category->validate($data))
            {
                $category->getErrors();
                redirect();
            }
            if($category->update('category', $id))
            {
                $alias = AppModel::createAlias('category', 'alias', $data['title'], $id);
                $category = R::load('category', $id);
                $category->alias = $alias;
                R::store($category);

                $cache = Cache::instance();
                $cache->delete('cats');
                $cache->delete('ishop_menu');

                $_SESSION['success'] = 'Изменения сохранены';
            }
            redirect();
        }
        $id = $this->getRequestID();
        $category = R::load('category', $id);
        App::$app->setProperty('parent_id', $category->parent_id);
        $this->setMeta("Редактирование категории {$category->title}");
        $this->set(compact('category'));
    }

}