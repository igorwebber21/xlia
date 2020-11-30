<?php $parent_id = \ishop\App::$app->getProperty('parent_id');  debug(\ishop\App::$app->getProperties());
 ?>
<option value="<?=$id;?>" <?php if($id == $parent_id) echo 'selected';?>
    <?php if(isset($_GET['id']) && $_GET['id'] == $id) echo 'disabled'; ?>>
    <?=$tab . $category['title'];?>
</option>
<?php if(isset($category['childs'])): ?>
    <?= $this->getMenuHtml($category['childs'], '&nbsp;' . $tab. '-') ?>
<?php endif; ?>
