<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список товаров
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Список товаров</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-centered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Фото</th>
                                <th>Категория</th>
                                <th>Наименование</th>
                                <th>Цена</th>
                                <th>Статус</th>
                                <th>Добавлен</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($products as $product):?>
                                <tr <?php if($product['status'] == 'hidden') echo 'class="product-hidden"';?>>
                                    <td><?=$product['id'];?></td>
                                    <td>
                                        <a href="<?=ADMIN;?>/product/edit?id=<?=$product['id'];?>">
                                            <?php if($product['img']): ?>
                                            <img width="50" src="<?=PRODUCTIMG.$product['img'];?>" alt="<?=$product['title'];?>" />
                                            <?php else: ?>
                                            <img width="50" src="<?=PRODUCTIMG?>no_image.jpg" alt="">
                                            <?php endif; ?>
                                        </a>
                                    </td>
                                    <td><?=$product['cat'];?></td>
                                    <td><a href="<?=ADMIN;?>/product/edit?id=<?=$product['id'];?>"><?=$product['title'];?></a></td>
                                    <td><?=$product['price'];?> грн.</td>
                                    <td><?=$product['status'] == 'visible' ? 'Активный' : 'Скрытый';?></td>
                                    <td><?=date_point_format($product['date_add']);?></td>
                                    <td>
                                        <a href="<?=ADMIN;?>/product/edit?id=<?=$product['id'];?>">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <a class="delete" href="<?=ADMIN;?>/product/delete?id=<?=$product['id'];?>">
                                            <i class="fa fa-fw fa-close text-danger"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                        <p>(<?=count($products);?> товаров из <?=$count;?>)</p>
                        <?php if($pagination->countPages > 1): ?>
                            <?=$pagination;?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->