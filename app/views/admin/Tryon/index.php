<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Заявки на примерку товаров
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li class="active">Заявки на примерку товаров </li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-body">
          <div class="table-responsive">
            <?php if($tryon): ?>
              <table class="table table-bordered table-hover table-centered">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Товар</th>
                  <th>Товар</th>
                  <th>Имя клиента</th>
                  <th>Номер клиента</th>
                  <th>Район</th>
                  <th>Дата заявки</th>
                  <th>Статус</th>
                  <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($tryon as $item): ?>
                  <?php $class = ($item['status'] == 'new') ? '' : 'success'; ?>
                  <tr class="<?=$class;?>">
                    <td><?=$item['id'];?></td>
                    <td>
                      <img width="50" src="<?=UPLOAD_PRODUCT_BASE.explode(',',  $item['imgs'])[0]?>" alt="">
                    </td>
                    <td>
                        <div>
                            <a href="<?=ADMIN;?>/product/edit?id=<?=$item['product_id'];?>"><?=$item['productTitle'];?></a>
                        </div>

                    </td>
                    <td><?=$item['user_name'];?></td>
                    <td><?=$item['user_phone']?></td>
                    <td><?=$item['state']?></td>
                    <td><?=date_point_format($item['date']);?></td>
                    <td>
                      <?php if($item['status'] == 'new'): ?>
                        <a href="<?=ADMIN;?>/tryon/change?id=<?=$item['id'];?>&amp;status=1" class="btn order-action-btn btn-success btn-xs">Одобрить</a>
                      <?php else: ?>
                        <a href="<?=ADMIN;?>/tryon/change?id=<?=$item['id'];?>&status=0" class="btn order-action-btn btn-default btn-xs">Вернуть на доработку</a>
                      <?php endif; ?>


                    </td>
                    <td>
                      <a href="<?=ADMIN;?>/tryon/delete?id=<?=$item['id'];?>" class="delete"><i class="fa fa-fw fa-close text-danger"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>

              <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Список заявок</h4>
                Здесь будет список заявок, отправленных с модального окна "Примерить товар". На данный момент ни одной заявки ещё не отправлено
              </div>

            <?php endif;?>
          </div>

          <?php if($tryon): ?>
            <div class="text-center">
              <p>(<?=count($tryon);?> заявки из <?=$count;?>)</p>
              <?php if($pagination->countPages > 1): ?>
                <?=$pagination;?>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

</section>
<!-- /.content -->