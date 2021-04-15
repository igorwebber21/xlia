<!-- Page Content -->
<main class="page-main">
  <div class="container">
    <!-- Two columns -->
    <div class="row">
      <!-- Center column -->
      <div class="col-md-12">
        <div class="blog-post">
          <div class="blog-photo">
            <!--<img src="images/blog/blog-single-post.jpg" alt="Blog Single"> -->
          </div>
          <div class="blog-content">
            <h2 class="blog-title"><?=$article['name'];?></h2>
              <div class="blog-meta">
                  <div class="pull-left">
                      <span class="last">Опубликовано: <?=date_point_format($article['date_add'])?></span>
                  </div>
                  <div class="pull-right">
                      <div class="share-button toRight">
                          <span class="toggle">Поделиться</span>
                          <ul class="social-list">
                              <li>
                                  <a class="icon icon-vk fa-vk share-btn-vk" style="background-color: #509FF5; border-color: #509FF5;"
                                     href="https://vk.com/share.php?url=<?=PATH?>/blog/<?=$article['alias']?>" target="_blank" onclick="return Share.me(this);"></a>
                              </li>
                              <li>
                                  <a class="icon icon-linkedin linkedin share-btn-in" href="https://www.linkedin.com/cws/share?url=<?=PATH?>/blog/<?=$article['alias']?>" target="_blank" onclick="return Share.me(this);">
                                  </a>
                              </li>
                              <li>
                                  <a href="https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Ffiddle.jshell.net%2F_display%2F&text=[TITLE]&url=<?=PATH?>/blog/<?=$article['alias']?>"
                                     class="icon icon-twitter-logo twitter"  target="_blank" onclick="return Share.me(this)">
                                  </a>
                              </li>
                              <li>
                                  <a class="icon icon-facebook-logo facebook share-btn-fb"
                                     href="http://www.facebook.com/sharer/sharer.php?s=100&p%5Btitle%5D=[TITLE]&p%5Bsummary%5D=[TEXT]&p%5Burl%5D=<?=PATH?>/blog/<?=$article['alias']?>&p%5Bimages%5D%5B0%5D=[IMAGE]"
                                     target="_blank" onclick="return Share.me(this);"></a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
            <div class="blog-text">

                <?php if($article['img_full']): ?>
                <div class="blog-mini-photo">
                    <img src="<?=UPLOAD_BLOG_FULL.$article['img_full'];?>" alt="<?=$article['name'];?>">
                </div>
                <?php endif; ?>

                <div><?=$article['text'];?></div>

            </div>
          </div>
        </div>
      </div>
      <!-- /Center column -->

      <?php if($lastArticles): ?>
          <div class="col-md-12">
            <!-- Blog Carousel -->
            <div class="title">
              <h2>Последние статьи</h2>
              <div class="carousel-arrows"></div>
            </div>
            <!-- Blog Carousel Item -->
            <div class="blog-carousel blog-carousel-another">
                <?php foreach ($lastArticles as $lastArticle): ?>
                 <div class="blog-item">
                    <a href="/blog/<?=$lastArticle['alias'];?>" class="blog-item-photo"> <img class="product-image-photo" src="<?=UPLOAD_BLOG_PREVIEW.$lastArticle['img_preview'];?>" alt="<?=$lastArticle['name'];?>"> </a>
                    <div class="blog-item-info">
                      <a href="/blog/<?=$lastArticle['alias'];?>" class="blog-item-title"><?=$lastArticle['name'];?></a>
                      <div class="blog-item-teaser"><?=$lastArticle['title']?></div>
                      <div class="blog-item-links">
                          <span class="pull-left">
                              <span>
                                  <a href="/blog/<?=$lastArticle['alias'];?>" class="readmore">Подробнее</a>
                              </span>
                          </span>
                          <span class="pull-right">
                              <span><?=date_point_format($article['date_add'])?></span>
                          </span>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>

              <!-- /Blog Carousel Item -->
            </div>
            <!-- /Blog Carousel -->
          </div>
      <?php endif;?>
    </div>
    <!-- /Two columns -->
  </div>
</main>
<!-- /Page Content -->