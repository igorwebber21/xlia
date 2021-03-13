<?php


namespace app\widgets\filter;

use app\models\Category;
use ishop\Cache;
use ishop\Router;
use RedBeanPHP\R;

class Filter
{
    public $groups;
    public $attrs;
    public $tpl;
    public static $filterData = [];

    public function __construct($filterData, $filter = null, $tpl = '')
    {
        self::$filterData = $filterData;
        $this->filter = $filter;
        $this->tpl = $tpl ? $tpl : __DIR__. '/filter_tpl/filter.php';
    }

    public function run()
    {
        $cache = Cache::instance();

        $this->groups = $cache->get('filter_group');
        if(!$this->groups)
        {
            $this->groups = $this->getGroups();
            $cache->set('filter_group', $this->groups, 3600);
        }

        $this->attrs = $cache->get('filter_attrs');
        if(!$this->attrs)
        {
            $this->attrs = self::getAttrs();
            $cache->set('filter_attrs', $this->attrs, 3600);
        }

        $filters = $this->getHtml();
        return $filters;
    }

    public function getHtml()
    {
        ob_start();
        $selectedFilter = '';
        $filter = Filter::getFilter();

        $minPrice = isset(self::$filterData['minPrice']) ? self::$filterData['minPrice'] : 0;
        $maxPrice = isset(self::$filterData['maxPrice']) ? self::$filterData['maxPrice'] : 0;
        $curr = \ishop\App::$app->getProperty('currency');

        if($filter){
            $selectedFilter = self::getSelectedAttrs($filter);
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
        $data = R::getAssoc("SELECT `attribute_product`.`attr_id`, COUNT(`product`.`id`) AS 'productsCount', `attribute_value`.`value`, 
                                        `attribute_value`.`attr_group_id`
                                    FROM `product`
                                    LEFT JOIN `attribute_product` 
                                    ON `attribute_product`.`product_id` = `product`.`id`
                                    LEFT JOIN `attribute_value`
                                    ON `attribute_product`.`attr_id` = `attribute_value`.`id`
                                    WHERE `product`.`category_id` IN('".self::$filterData['categoryIds']."')
                                    GROUP BY `attribute_product`.`attr_id`");

        $attrs = [];
        foreach ($data as $key => $value)
        {
            if(!empty($value['value']))
            {
                $attrs[$value['attr_group_id']][$key] = [
                                                         'value' => $value['value'],
                                                         'count' => $value['productsCount']
                ];
            }
        }
        return $attrs;
    }

    protected static function getSelectedAttrs($filter)
    {
      $data = R::getAssoc("SELECT * FROM `attribute_value`
                                    WHERE `attribute_value`.`id` IN(".$filter.")");
      return $data;
    }

    public static function getFilter()
    {
        $filter = null;

        if(isset($_GET['filter']) && !empty($_GET['filter'])){
            $filter = preg_replace("#[^\d,]+#", '', $_GET['filter']);
            $filter = trim($filter, ',');
        }

        return $filter;
    }

    public static function countGroups($filter)
    {
        $filters = explode(',', $filter);
        $cache = Cache::instance();
        $filter_attrs = $cache->get('filter_attrs');

        if(!$filter_attrs){
            $filter_attrs = self::getAttrs();
        }

        $data = [];
        foreach ($filter_attrs as $group_id => $item){
            foreach ($item as $attr_id => $value){
                if(in_array($attr_id, $filters)){
                    $data[] = $group_id;
                    break;
                }
            }
        }

        return count($data);
    }

}