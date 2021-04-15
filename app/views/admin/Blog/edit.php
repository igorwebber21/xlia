<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Добавить статью
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li><a href="<?=ADMIN;?>/blog">Список статей</a></li>
    <li class="active">Новая статья</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <form class="articleForm" action="<?=ADMIN;?>/blog/edit" method="post" data-toggle="validator">
          <div class="box-body">
            <div class="form-group has-feedback">
              <label for="title">Наименование статьи</label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Наименование категории" value="<?=$article['name']?>" required>
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>

            <div class="form-group">
              <label for="keywords">Описание статьи</label>
              <input type="text" name="title" class="form-control" id="title" value="<?=$article['title']?>" placeholder="Краткое описание">
              <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>

            <div class="form-group upload-product-image">
              <div class="container-wrap">
                <div class="product-image-base">
                  <div class="box box-danger box-solid file-upload">
                    <div class="box-header">
                      <h3 class="box-title">Базовое фото (в списке статей)</h3>
                    </div>
                    <div class="box-body">
                      <div id="blog_preview" class="btn btn-success" data-url="blog/add-previewImg" data-name="blog_preview">
                        Выбрать фото
                      </div>
                      <p>
                                            <span>
                                                <small>Рекомендуемые размеры:
                                                    <?=\ishop\App::$app->getProperty('blog_img_width')?> x
                                                    <?=\ishop\App::$app->getProperty('blog_img_height')?>
                                                </small>
                                            </span>
                      </p>
                      <div class="blog_preview">
                          <img src="<?=BLOGPREVIEWIMG.$article['img_preview'];?>" alt="" style="max-height: 150px;">
                      </div>
                    </div>
                    <div class="overlay">
                      <i class="fa fa-refresh fa-spin"></i>
                    </div>
                  </div>
                </div>
                <div class="product-image-gallery">
                  <div class="box box-primary box-solid file-upload">
                    <div class="box-header">
                      <h3 class="box-title">Полное фото (на странице статьи)</h3>
                    </div>
                    <div class="box-body">
                      <div id="blog_full" class="btn btn-success" data-url="blog/add-fullImg/" data-name="blog_full">
                        Выбрать фото
                      </div>
                      <p>
                                            <span>
                                                <small>Рекомендуемые размеры:
                                                    <?=\ishop\App::$app->getProperty('blog_full_img_width')?> x
                                                    <?=\ishop\App::$app->getProperty('blog_full_img_height')?>
                                                </small>
                                            </span>
                      </p>
                      <div class="blog_full">
                          <img src="<?=UPLOADBLOGFULL.$article['img_full'];?>" alt="" style="max-height: 150px;">
                      </div>
                    </div>
                    <div class="overlay">
                      <i class="fa fa-refresh fa-spin"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="form-group has-feedback">
              <label for="content">Текст статьи</label>
              <textarea id="text" name="text" cols="80" rows="10"><?=$article['text']?></textarea>
            </div>
          </div>
          <div class="box-footer">
              <input type="hidden" name="id" value="<?=$article['id'];?>">
            <button type="submit" class="btn btn-success">Сохранить</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</section>
<!-- /.content -->
