<?php  //debug($tree, 1); ?>
<?php foreach ($tree as $key => $category): ?>
    <?php if($key != 3): ?>
    <li class="mega-dropdown">
        <a href="category/<?=$category['alias'];?>"><?=$category['title'];?></a>
        <div class="sub-menu">
            <div class="container">
                <div class="megamenu-left width-25">
                    <a href="#bannerLink" class="banner-wrap">
                        <div class="banner style-13 autosize-text image-hover-scale" data-fontratio="4">
                            <img src="<?=CATEGORYIMG.$category['img']?>" alt="Banner">
                            <div class="banner-caption horc vertb" style="bottom: 3%;">
                                <div class="vert-wrapper">
                                    <div class="vert">
                                        <div class="text-1">NEW STYLE</div>
                                        <div class="text-2">New Collection</div>
                                        <div class="banner-btn text-hoverslide" data-hcolor="#f82e56"><span><span class="text">SHOP NOW</span><span class="hoverbg"></span></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="megamenu-categories column-3">
                    <?php if(isset($category['childs'])):
                            foreach ($category['childs'] as $subcat): ?>
                    <!-- megamenu column 1 -->
                    <div class="col">
                        <a class="category-image light" href="category/<?=$subcat['alias']?>"><img src="<?=CATEGORYIMG.$subcat['img']?>" alt /></a>
                        <div class="category-title title-border"><a href="category/<?=$subcat['alias']?>"><?=$subcat['title']?></a></div>
                        <ul class="category-links">
                            <?php if(isset($subcat['childs'])):
                                    foreach ($subcat['childs'] as $item): ?>
                            <li><a href="category/<?=$item['alias']?>"><?php echo $item['title']?></a></li>
                            <?php
                                    endforeach;
                                   endif;
                            ?>
                        </ul>
                    </div>
                    <?php
                            endforeach;
                            endif;
                    ?>
                </div>
            </div>
        </div>
    </li>
    <?php else:?>
    <li class="mega-dropdown">
            <a href="category.html"><?php echo $category['title']?></a>
            <div class="sub-menu">
                <div class="container">

                    <div class="megamenu-categories column-2">
                <?php if(isset($category['childs'])):
                    foreach ($category['childs'] as $subcat): ?>
                        <!-- megamenu column 1 -->
                        <div class="col">
                            <a class="category-image" href="#"><img src="<?=CATEGORYIMG.$subcat['img']?>" alt /></a>
                            <div class="category-title title-border"><a href="#"><?=$subcat['title']?><span class="menu-label">HOT</span></a></div>

                            <div class="flex top end">
                                <?php if(isset($subcat['childs'])):
                                    foreach ($subcat['childs'] as $item): ?>
                                <div class="megamenu-categories-flex-3">
                                    <a href="#" class="subcategory-title"><?php echo $item['title']?></a>
                                    <ul class="category-links">
                                        <?php if(isset($item['childs'])):
                                            foreach ($item['childs'] as $subitem): ?>
                                            <li><a href="#"><?=$subitem['title']?></a></li>
                                        <?php endforeach; endif; ?>
                                    </ul>
                                </div>
                                    <?php endforeach;  endif; ?>
                            </div>

                        </div>
                        <!-- /megamenu column 1 -->
                    <?php endforeach; endif;
                     ?>
                </div>
            </div>
    </li>
    <?php endif;?>
<?php endforeach; ?>