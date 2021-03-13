<div class="fixed-wrapper">

    <div class="fixed-scroll">

        <div class="filter-col-header">
            <div class="title">Фильтровать по:</div>
            <a href="#" class="filter-col-toggle"></a>
        </div>
        <div class="filter-col-content">

            <?php if($selectedFilter):?>
            <div class="sidebar-block-top">
                    <h2>Фильтровать по:</h2>
                    <ul class="selected-filters">
                        <?php foreach ($selectedFilter as $filterId => $filterItem): ?>
                        <li>
                            <a href="#" data-selected="<?=$filterId?>">
                                <span><?=$filterItem['value']?></span>
                                <span class="remove"><i class="icon icon-close"></i></span>
                            </a>
                            <div class="bg-striped"></div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
            </div>
            <?php endif; ?>

            <div class="sidebar-block collapsed open">
                <div class="block-title">
                    <span>Цена</span>
                    <div class="toggle-arrow"></div>
                </div>
                <div class="block-content">
                    <div class="price-slider-wrapper">
                        <div class="price-values">
                            <div class="pull-left"><?=$curr['symbol_left'];?><span id="priceMin"><?=$minPrice?></span><?=$curr['symbol_right'];?></div>
                            <div class="pull-right"><?=$curr['symbol_left'];?><span id="priceMax"><?=$maxPrice?></span><?=$curr['symbol_right'];?></div>
                        </div>
                        <div id="priceSlider" class="price-slider"></div>
                    </div>
                    <div class="bg-striped"></div>
                </div>
            </div>

<?php //debug($this->groups); debug($this->attrs);
    foreach($this->groups as $group_id => $group_item): ?>
    <?php if(isset($this->attrs[$group_id])): ?>

        <div class="sidebar-block collapsed open">
            <div class="block-title">
                <span><?=$group_item;?></span>
                <div class="toggle-arrow"></div>
            </div>
            <div class="block-content">
                <ul class="category-list">

                    <?php  foreach($this->attrs[$group_id] as $attr_id => $item): ?>
                        <?php if($filter && in_array($attr_id, $filter)){
                            $checked = ' class="active"';
                        }
                        else{
                            $checked = null;
                        }?>
                        <li<?=$checked?>><a href="#" class="value" data-attr-id="<?=$attr_id;?>"><?=$item['value'];?> (<?=$item['count']?>)</a>
                            <a href="#" class="clear"></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="bg-striped"></div>
            </div>
        </div>

    <?php endif;?>
<?php endforeach; ?>

            <div class="sidebar-block-filter">
                <div class="block-content">
                    <a href="#" class="btn btn-invert btn-lg filter-products">Применить фильтры</a>
                </div>
            </div>

        </div>
    </div>
</div>



















<!--
<div class="fixed-wrapper">
    <div class="fixed-scroll">
        <div class="filter-col-header">
            <div class="title">Filters</div>
            <a href="#" class="filter-col-toggle"></a>
        </div>
        <div class="filter-col-content">
            <div class="sidebar-block-top">
                <h2>Shoping By</h2>
                <ul class="selected-filters">
                    <li><a href="#"><span>Trousers</span><span class="remove"><i class="icon icon-close"></i></span></a>
                        <div class="bg-striped"></div>
                    </li>
                    <li><a href="#"><span>Orange <img src="images/colorswatch/color-orange.png" alt=""></span><span class="remove"><i class="icon icon-close"></i></span></a>
                        <div class="bg-striped"></div>
                    </li>
                    <li><a href="#"><span>Cavalli</span><span class="remove"><i class="icon icon-close"></i></span></a>
                        <div class="bg-striped"></div>
                    </li>
                    <li><a href="#"><span>$10-30$</span><span class="remove"><i class="icon icon-close"></i></span></a>
                        <div class="bg-striped"></div>
                    </li>
                    <li><a href="#"><span>Size 36</span><span class="remove"><i class="icon icon-close"></i></span></a>
                        <div class="bg-striped"></div>
                    </li>
                </ul>
            </div>
            <div class="sidebar-block collapsed open">
                <div class="block-title">
                    <span>Цена</span>
                    <div class="toggle-arrow"></div>
                </div>
                <div class="block-content">
                    <div class="price-slider-wrapper">
                        <div class="price-values">
                            <div class="pull-left">$<span id="priceMin"></span></div>
                            <div class="pull-right">$<span id="priceMax"></span></div>
                        </div>
                        <div id="priceSlider" class="price-slider"></div>
                    </div>
                    <div class="bg-striped"></div>
                </div>
            </div>
            <div class="sidebar-block collapsed open">
                <div class="block-title">
                    <span>Размер</span>
                    <div class="toggle-arrow"></div>
                </div>
                <div class="block-content">
                    <ul class="size-list">
                        <li class="active"><a href="#"><span class="clear"></span><span class="value">38</span></a></li>
                        <li><a href="#"><span class="clear"></span><span class="value">38</span></a></li>
                        <li><a href="#"><span class="clear"></span><span class="value">40</span></a></li>
                        <li><a href="#"><span class="clear"></span><span class="value">42</span></a></li>
                    </ul>
                    <div class="bg-striped"></div>
                </div>
            </div>
            <div class="sidebar-block collapsed open">
                <div class="block-title">
                    <span>Цвет</span>
                    <div class="toggle-arrow"></div>
                </div>
                <div class="block-content">
                    <ul class="color-list">
                        <li class="active"><a href="#" data-tooltip="Very long some color name" title="Very long some color name"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-red.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Pink" title="Pink"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-pink.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Violet" title="Violet"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-violet.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Blue" title="Blue"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-blue.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Marine" title="Marine"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-marine.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Orange" title="Orange"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-orange.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Yellow" title="Yellow"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-yellow.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Dark Yellow" title="Dark Yellow"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-darkyellow.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="Very long some color name" title="Very long some color name"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-black.png" alt=""></span></a></li>
                        <li><a href="#" data-tooltip="White" title="White"><span class="clear"></span><span class="value"><img src="images/colorswatch/color-white.png" alt=""></span></a></li>
                    </ul>
                    <div class="bg-striped"></div>
                </div>
            </div>
            <div class="sidebar-block collapsed open">
                <div class="block-title">
                    <span>Бренд</span>
                    <div class="toggle-arrow"></div>
                </div>
                <div class="block-content">
                    <ul class="category-list">
                        <li><a href="#" class="value">Dresses</a>
                            <a href="#" class="clear"></a>
                        </li>
                        <li><a href="#">Jackets</a>
                            <a href="#" class="clear"></a>
                        </li>
                        <li class="active"><a href="#">Trousers</a>
                            <a href="#" class="clear"></a>
                        </li>
                        <li><a href="#">Jeans</a>
                            <a href="#" class="clear"></a>
                        </li>
                    </ul>
                    <div class="bg-striped"></div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="fend"></div>


-->