<?php foreach($this->groups as $group_id => $group_item): ?>
    <?php if(isset($this->attrs[$group_id])): ?>
    <section  class="sky-form">
        <h4><?=$group_item;?></h4>
        <div class="row1 scroll-pane">
            <div class="col col-4">

                    <?php foreach($this->attrs[$group_id] as $attr_id => $value): ?>
                        <?php if($filter && in_array($attr_id, $filter)){
                                $checked = ' checked';
                              }
                              else{
                                  $checked = null;
                              }?>
                        <label class="checkbox">
                            <input type="checkbox" <?=$checked?> name="checkbox" value="<?=$attr_id;?>"><i></i><?=$value;?>
                        </label>
                  <?php endforeach; ?>

            </div>
        </div>
    </section>
    <?php endif;?>
<?php endforeach; ?>