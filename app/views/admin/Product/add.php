<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Новый товар
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=ADMIN;?>/product">Список товаров</a></li>
        <li class="active">Новый товар</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=ADMIN;?>/product/add" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование товара</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Наименование товара"
                               value="<?php isset($_SESSION['form_data']['title']) ? h($_SESSION['form_data']['title']) : null; ?>" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                        </div>

                        <div class="form-group">
                            <label for="category_id">Родительская категория</label>
                            <?php new \app\widgets\menu\Menu([
                                'tpl' => WWW . '/menu/select.php',
                                'container' => 'select',
                                'cache' => 0,
                                'cacheKey' => 'admin_select',
                                'class' => 'form-control',
                                'attrs' => [
                                    'name' => 'category_id',
                                    'id' => 'category_id',
                                    'required' => 'required'
                                ],
                                'prepend' => '<option value="">Выберите категорию</option>',
                            ]) ?>
                        </div>

                        <div class="form-group">
                            <label for="keywords">Ключевые слова</label>
                            <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Ключевые слова" value="<?php isset($_SESSION['form_data']['keywords']) ? h($_SESSION['form_data']['keywords']) : null; ?>">
                        </div>

                        <div class="form-group">
                            <label for="description">Описание</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Описание" value="<?php isset($_SESSION['form_data']['description']) ? h($_SESSION['form_data']['description']) : null; ?>">
                        </div>

                        <div class="form-group has-feedback">
                            <label for="price">Цена</label>
                            <input type="text" name="price" class="form-control" id="price" placeholder="Цена" pattern="^[0-9.]{1,}$" value="<?php isset($_SESSION['form_data']['price']) ? h($_SESSION['form_data']['price']) : null; ?>" required data-error="Допускаются цифры и десятичная точка">
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="old_price">Старая цена</label>
                            <input type="text" name="old_price" class="form-control" id="old_price" placeholder="Старая цена" pattern="^[0-9.]{1,}$" value="<?php isset($_SESSION['form_data']['old_price']) ? h($_SESSION['form_data']['old_price']) : null; ?>" data-error="Допускаются цифры и десятичная точка">
                            <div class="help-block with-errors"></div>
                        </div>

                        <div class="form-group upload-product-image">
                            <div class="container-wrap">
                                <div class="product-image-base">
                                    <div class="box box-danger box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Базовое фото (в списке категории)</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="single" class="btn btn-success" data-url="product/add-image" data-name="single">
                                                Выбрать фото
                                            </div>
                                            <p>
                                            <span>
                                                <small>Рекомендуемые размеры:
                                                    <?=\ishop\App::$app->getProperty('img_width')?> x
                                                    <?=\ishop\App::$app->getProperty('img_height')?>
                                                </small>
                                            </span>
                                            </p>
                                            <div class="single"></div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-image-gallery">
                                    <div class="box box-primary box-solid file-upload">
                                        <div class="box-header">
                                            <h3 class="box-title">Фото галереи (в карточке товара)</h3>
                                        </div>
                                        <div class="box-body">
                                            <div id="multi" class="btn btn-success" data-url="product/add-image/" data-name="multi">
                                                Выбрать фото
                                            </div>
                                            <p>
                                            <span>
                                                <small>Рекомендуемые размеры:
                                                    <?=\ishop\App::$app->getProperty('gallery_width')?> x
                                                    <?=\ishop\App::$app->getProperty('gallery_height')?>
                                                </small>
                                            </span>
                                            </p>
                                            <div class="multi"></div>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label for="content">Контент</label>
                            <textarea name="content" id="editorProduct" cols="80" rows="10"><?php isset($_SESSION['form_data']['old_price']) ? $_SESSION['form_data']['old_price'] : null; ?></textarea>
                        </div>

                        <div class="form-group form-section-checkboxes form-section-bmt">

                            <label class="section-checkbox">
                                <label class="switch">
                                    <input type="checkbox" name="status" checked>
                                    <span class="slider round"></span>
                                </label>
                                <span class="checkbox-text">Показывать</span>
                            </label>

                            <div class="checkbox-delimiter"></div>
                            <label class="section-checkbox">
                                <label class="switch">
                                    <input type="checkbox" name="hit" checked>
                                    <span class="slider round"></span>
                                </label>
                                <span class="checkbox-text">Хит</span>
                            </label>

                        </div>


                        <div class="form-group form-section-bmt">
                            <label for="related">Связанные товары</label>
                            <select name="related[]" id="related" class="form-control select2 related-products" multiple>
                            </select>
                        </div>


                      <?php new \app\widgets\filter\FilterAdmin();?>

                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </div>
                </form>
                <?php if(isset($_SESSION['form_data'])) unset($_SESSION['form_data']); ?>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->