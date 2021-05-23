<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Заявки "Перезвоните мне"
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
    <li class="active">Заявки "Перезвоните мне"</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-body">
          <div class="table-responsive">
            <?php if($recalls): ?>
              <table class="table table-bordered table-hover text-center">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>Имя клиента</th>
                  <th>Номер клиента</th>
                  <th>Дата заявки</th>
                  <th>Статус</th>
                  <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($recalls as $recall): ?>
                  <?php $class = ($recall['status'] == 'new') ? '' : 'success'; ?>
                  <tr class="<?=$class;?>">
                    <td><?=$recall['id'];?></td>
                    <td><?=$recall['user_name'];?></td>
                    <td><?=$recall['user_phone']?></td>
                    <td><?=date_point_format($recall['date']);?></td>
                    <td>
                      <?php if($recall['status'] == 'new'): ?>
                        <a href="<?=ADMIN;?>/recalls/change?id=<?=$recall['id'];?>&amp;status=1" class="btn order-action-btn btn-success btn-xs">Одобрить</a>
                      <?php else: ?>
                         <a href="<?=ADMIN;?>/recalls/change?id=<?=$recall['id'];?>&status=0" class="btn order-action-btn btn-default btn-xs">Вернуть на доработку</a>
                      <?php endif; ?>


                    </td>
                    <td>
                      <a href="<?=ADMIN;?>/recalls/delete?id=<?=$recall['id'];?>" class="delete"><i class="fa fa-fw fa-close text-danger"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php else: ?>

              <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning"></i> Список заявок</h4>
                Здесь будет список заявок, отправленных с модального окна "Перезвоните мне". На данный момент ни одной заявки ещё не отправлено
              </div>

            <?php endif;?>
          </div>

          <?php if($recalls): ?>
            <div class="text-center">
              <p>(<?=count($recalls);?> заявки из <?=$count;?>)</p>
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