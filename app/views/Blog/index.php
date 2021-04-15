<!-- Page Content -->
<main class="page-main">
  <div class="container">
    <!-- Page Title -->
    <div class="page-title">
      <div class="title center">
        <h1>Блог</h1>
      </div>
      <div class="text-wrapper">
        <p class="text-center">
            Одежда — это ещё один способ для самовыражения.<br/>
            Создавая образ, мы сообщаем миру о себе и о том, что, где и когда у нас происходит.<br/>
            Когда мы покупаем или надеваем одежду, то сознательно или подсознательно учитываем свой возраст, размеры, образ жизни и культуру, к которой принадлежим.
        </p>
      </div>
    </div>

    <div class="text-center">
        <?php if($pagination->countPages > 1): ?>
          <?=$pagination;?>
        <?php endif; ?>
    </div>

    <!-- /Page Title -->
    <!-- Blog grid -->
    <div class="blog-grid-3">
      <?php if($articles):
            foreach ($articles as $article): ?>
      <div class="blog-post">
        <div class="blog-photo">
          <a href="/blog/<?=$article['alias']?>"><img src="<?=BLOGPREVIEWIMG.$article['img_preview']?>" alt="Blog Single"></a>
        </div>
        <div class="blog-content">
          <h2 class="blog-title"><a href="/blog/<?=$article['alias']?>"><?=$article['name']?></a></h2>
          <div class="blog-meta">
            <div class="pull-left">
              <span class="last">Опубликовано: <?=date_point_format($article['date_add'])?></span>
            </div>
            <div class="pull-right">
              <!--<div class="share-button toRight">
                <span class="toggle">Share</span>
                <ul class="social-list">
                  <li>
                    <a href="#" class="icon icon-google google"></a>
                  </li>
                  <li>
                    <a href="#" class="icon icon-fancy fancy"></a>
                  </li>
                  <li>
                    <a href="#" class="icon icon-pinterest pinterest"></a>
                  </li>
                  <li>
                    <a href="#" class="icon icon-twitter-logo twitter"></a>
                  </li>
                  <li>
                    <a href="#" class="icon icon-facebook-logo facebook"></a>
                  </li>
                </ul>
              </div>-->
            </div>
          </div>
          <div class="blog-text">
            <?=$article['title']?>
          </div>
          <a href="/blog/<?=$article['alias']?>" class="btn">Подробнее</a>
        </div>
      </div>
        <?php
            endforeach;
        endif; ?>
    </div>
    <!-- /Blog grid -->
      <div class="text-center">
        <?php if($pagination->countPages > 1): ?>
          <?=$pagination;?>
        <?php endif; ?>
      </div>

  </div>
</main>
<!-- /Page Content -->