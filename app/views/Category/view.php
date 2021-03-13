<!-- Page Content -->
<main class="page-main">
    <div class="block">
        <div class="container">
            <ul class="breadcrumbs">
               <!-- <li><a href="index.html"><i class="icon icon-home"></i></a></li>
                <li>/<span>WOMEN’S</span></li>-->
                <?=$breadcrumbs;?>
            </ul>
        </div>
    </div>
    <div class="container">
        <!-- Two columns -->
        <div class="row row-table products-wrapper">

            <!-- Left column -->
            <div class="col-md-3 filter-col aside filter-block">
                    <?php $filterObj = new \app\widgets\filter\Filter($filterData);
                          echo $filterObj->run();
                    ?>
            </div>
            <!-- /Left column -->

            <!-- Center column -->
            <div class="col-md-9 aside">
                <!-- Page Title -->
                <div class="page-title">
                    <div class="title center">
                        <h1><?=$category->title?></h1>
                        <?php //debug($products);?>
                    </div>
                </div>
                <!-- /Page Title -->


                <div class="products-block">

                    <?php if(!empty($products)): ?>

                    <!-- Filter Row -->
                    <div class="filter-row">
                        <div class="row">
                            <div class="col-xs-8 col-sm-7 col-lg-5 col-left">
                                <div class="filter-button">
                                    <a href="#" class="btn filter-col-toggle"><i class="icon icon-filter"></i><span>FILTER</span></a>
                                </div>
                                <div class="form-label">Сортировать по:</div>
                                <div class="select-wrapper-sm">
                                    <select class="form-control input-sm sort-product">
                                        <?php foreach ($productsSort as $key => $value): ?>
                                            <option <?php if($sort == $key) echo "selected"; ?> value="<?=$key?>"><?=$value?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-lg-2 hidden-xs">
                                <div class="view-mode">
                                    <a href="#" class="grid-view"><i class="icon icon-th"></i></a>
                                    <a href="#" class="list-view"><i class="icon icon-th-list"></i></a>
                                </div>
                            </div>
                            <div class="col-xs-4 col-sm-3 col-lg-5 col-right">
                                <div class="form-label">Показывать:</div>
                                <div class="select-wrapper-sm">
                                    <select class="form-control input-sm" id="productsPerPage">
                                        <?php foreach ($productsPerPage as $variant): ?>
                                            <option <?php if($variant == $perpage) echo "selected"; ?> value="<?=$variant?>"><?=$variant?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-striped"></div>
                    </div>
                    <!-- /Filter Row -->

                    <div class="products-content">

                        <!-- Pagination -->
                        <div class="flex pagination-block">
                            <?php  require APP . "/views/Category/product_pagination.php"; ?>
                        </div>
                        <!-- Pagination -->

                        <!-- Products Grid -->
                        <div class="three-in-row product-variant-5 <?=$productsMode?>">
                            <?php  require APP . "/views/Category/products.php"; ?>
                        </div>
                        <!-- Products Grid -->

                        <!-- Pagination -->
                        <div class="flex pagination-block">
                            <?php  require APP . "/views/Category/product_pagination.php"; ?>
                        </div>
                        <!-- Pagination -->

                    </div>

                    <?php else: ?>

                        <h2>По данным фильтрам товаров не найдено</h2>
                    <?php endif; ?>

                    <div class="filter-products-block">
                        <div class="filter-products-angle"></div>
                        <a href="#" class="btn btn-invert btn-lg btn-filter-products filter-products">Применить</a>
                    </div>

                </div>

                <!-- Banners
                <div class="row">
                    <div class="col-sm-6">
                        <a href="#" class="banner-wrap">
                            <div class="banner style-9 autosize-text image-hover-scale" data-fontratio="6.4">
                                <img src="images/banners/banner-category-1.jpg" alt="Banner">
                                <div class="banner-caption vertb">
                                    <div class="vert-wrapper">
                                        <div class="vert">
                                            <div class="text-1 text-hoverslide" data-hcolor="#ffffff"><span><span class="text">Brands favorite women</span><span class="hoverbg"></span></span>
                                            </div>
                                            <div class="text-2">Minus id quod maxime placeat facere possimus omnis voluptas assumenda</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <a href="#" class="banner-wrap">
                            <div class="banner style-10 autosize-text image-hover-scale" data-fontratio="6.4">
                                <img src="images/banners/banner-category-2.jpg" alt="Banner 2">
                                <div class="banner-caption vertb horc">
                                    <div class="vert-wrapper">
                                        <div class="vert">
                                            <div class="text-1">You deserve the best</div>
                                            <div class="banner-btn text-hoverslide" data-hcolor="#f82e56"><span><span class="text">Shop Now</span><span class="hoverbg"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                /Banners -->
                <!-- Categories Info -->
                <div class="info-block">
                   <?=$category->text?>
                </div>
                <!-- Categories Info -->

                <!-- Categories
                <div class="categories">
                    <div class="row">
                        <div class="col-xs-6 col-sm-3">
                            <a href="#" class="category-block">
                                <div class="category-image">
                                    <img src="images/category/category-img-01.jpg" alt="#">
                                </div>
                                <div class="category-title">
                                    Dresses
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <a href="#" class="category-block">
                                <div class="category-image">
                                    <img src="images/category/category-img-02.jpg" alt="#">
                                </div>
                                <div class="category-title">
                                    Jackets
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <a href="#" class="category-block">
                                <div class="category-image">
                                    <img src="images/category/category-img-03.jpg" alt="#">
                                </div>
                                <div class="category-title">
                                    Trousers
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <a href="#" class="category-block">
                                <div class="category-image">
                                    <img src="images/category/category-img-04.jpg" alt="#">
                                </div>
                                <div class="category-title">
                                    T-shirts
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                 /Categories -->

            </div>
            <!-- /Center column -->

            <!-- loader -->
            <div class="bg-loader hide"></div>
            <div class="hide spinningSquaresLoader">
                <div id="spinningSquaresG_1" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_2" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_3" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_4" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_5" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_6" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_7" class="spinningSquaresG"></div>
                <div id="spinningSquaresG_8" class="spinningSquaresG"></div>
            </div>
            <!-- loader -->

        </div>
        <div class="ymax"></div>
        <!-- /Two columns -->
    </div>
</main>
<!-- /Page Content -->