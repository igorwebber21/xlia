<?php


namespace app\widgets\filter;

use app\models\Category;
use ishop\Router;
use RedBeanPHP\R;

class FilterAdmin
{
  public $groups;
  public $attrs;
  public $tpl;

  public function __construct($filter = null, $tpl = '')
  {
    $this->filter = $filter;
    $this->tpl = $tpl ? $tpl : WWW. '/filter/admin_filter_tpl.php';
    $this->run();
  }

  protected function run()
  {
    $this->groups = $this->getGroups();
    $this->attrs = self::getAttrs();

    $filters = $this->getHtml();
    echo $filters;
  }

  public function getHtml()
  {
    ob_start();

    $filter = Filter::getFilter();
    if ($filter) {
      $filter = explode(',', $filter);
    }

    require $this->tpl;
    return ob_get_clean();
  }

  protected function getGroups()
  {
    return R::getAssoc('SELECT id, title FROM attribute_group');
  }

  protected static function getAttrs()
  {
    $data = R::getAssoc('SELECT * FROM attribute_value');

    $attrs = [];
    foreach ($data as $key => $value) {
      $attrs[$value['attr_group_id']][$key] = $value['value'];
    }

    return $attrs;
  }

  public static function getFilter()
  {
    $filter = null;
    if (isset($_GET['filter'])) {
      $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
      $filter = trim($filter, ',');
      return $filter;
    }
  }

  public static function countGroups($filter)
  {
    $filters = explode(',', $filter);
    $filter_attrs = self::getAttrs();

    $data = [];
    foreach ($filter_attrs as $group_id => $item) {
      foreach ($item as $attr_id => $value) {
        if (in_array($attr_id, $filters)) {
          $data[] = $group_id;
          break;
        }
      }
    }

    return count($data);
  }

}