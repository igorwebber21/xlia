<?php
$parent = isset($category['childs']);
if(!$parent){
    $count = 0;
    $arrow = '';
    $delete = '<a href="' . ADMIN . '/category/delete?id=' . $id . '" class="delete"><i class="fa fa-fw fa-close text-danger"></i></a>';
}else{
    $count = count($category['childs']);
    $class = 'cat-strong';
    $arrow = '-';
    $delete = '<a href="' . ADMIN . '/category/delete?id=' . $id . '" class="delete"><i class="fa fa-fw fa-close text-black"></i></a>';
}
?>
<p class="item-p <?=$class?>">
    <a class="list-group-item" href="<?=ADMIN;?>/category/edit?id=<?=$id;?>">
        <?=$arrow?> <?=$category['title'];?>
        <?php echo $count ? "[" .$count. "]" : '';?>
    </a>
    <span><?=$delete;?></span>
</p>
<?php if($parent): ?>
    <div class="list-group">
        <?= $this->getMenuHtml($category['childs']); ?>
    </div>
<?php endif; ?>
