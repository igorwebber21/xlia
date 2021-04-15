
<?php if($total != 0): ?>
<div class="items-products-count"><?=$productRangeCount?> тов. из <?=$total?></div>
<?php endif; ?>

<?php if($pagination->countPages > 1): ?>
    <?=$pagination;?>
<?php endif; ?>

<?php if($total != 0): ?>
<div class="items-total"><?=$pagination->currentPage?> стр. из <?=$pagination->countPages;?></div>
<?php endif; ?>