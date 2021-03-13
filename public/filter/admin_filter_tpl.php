<?php

//debug($this->attrs);
//debug($this->groups, 1);
?>

<div class="nav-tabs-custom form-section-bmt" id="product-filters-tabs">
    <h3>Фильтры товара</h3>
    <ul class="nav nav-tabs">
        <?php $i = 1; foreach($this->groups as $group_id => $group_item): ?>
            <li<?php if($i == 1) echo ' class="active"' ?>>
                <a href="#tab_<?= $group_id ?>" data-toggle="tab" aria-expanded="true"><?= $group_item ?></a>
            </li>
            <?php $i++; endforeach; ?>

            <li class="pull-right">
                <a href="#" id="reset-filter" class="btn btn-danger">
                    Сброс
                </a>
            </li>
    </ul>
    <div class="tab-content">
        <?php if(!empty($this->attrs[$group_id])): ?>
            <?php $i = 1; foreach($this->groups as $group_id => $group_item): ?>
                <div class="tab-pane<?php if($i == 1) echo ' active' ?>" id="tab_<?= $group_id ?>">
                    <?php foreach($this->attrs[$group_id] as $attr_id => $value): ?>
                        <?php
                        if(!empty($this->filter) && in_array($attr_id, $this->filter)){
                            $checked = ' checked';
                        }else{
                            $checked = null;
                        }
                        ?>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="attrs[<?= $group_id ?>][]" class="minimal" value="<?= $attr_id ?>"<?= $checked ?>>
                                <span><?= $value ?></span>
                            </label>
                        </div>
                        <?php $i++; endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>