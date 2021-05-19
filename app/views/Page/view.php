<main id="main" class="main">
  <div class="wrapper">
    <div class="layout">
      <div class="layout-main">
        <div class="layout-main-inner">
          <section class="page">
            <nav class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">
              <div class="breadcrumbs-i" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a itemprop="item" href="https://lior-boutique.com/">
                  <span itemprop="name">Главная</span>
                </a>
                <meta itemprop="position" content="1">
                <span class="breadcrumbs-arrow">
                                    <i class="icon-breadcrumbs-arrow"></i>
                                </span>
              </div>
              <div class="breadcrumbs-i" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <span itemprop="item" content="https://lior-boutique.com/oplata-i-dostavka/">
                                    <span itemprop="name">Оплата и доставка</span>
                                </span>
                <meta itemprop="position" content="2">
              </div>
            </nav>
            <h1 class="main-h"><?=$currPage['title']?></h1>
            <div class="page-content">
              <div class="article-text  text">
                <?=$currPage['text']?>
              </div>
            </div>
          </section>
        </div>
      </div>

      <aside class="layout-aside">
        <div class="layout-aside-inner">
          <nav class="sideMenu ">
            <ul class="sideMenu-list">
              <li class="sideMenu-i">
                <div class="sideMenu-t">
                  <a class="sideMenu-a" href="?view=category">Каталог</a>
                </div>
              </li>
              <?php foreach ($pages as $page): ?>
              <?php if($page['id'] == $currPage['id']) : ?>
                  <li class="sideMenu-i">
                    <div class="sideMenu-t __active">
                      <a class="sideMenu-a"><?=$page['title']?></a>
                    </div>
                  </li>
                <?php else: ?>
                    <li class="sideMenu-i">
                      <div class="sideMenu-t">
                        <a class="sideMenu-a" href="/<?=$page['alias']?>"><?=$page['title']?></a>
                      </div>
                    </li>
                <?php endif;?>
              <?php endforeach; ?>
            </ul>
          </nav>
        </div>
      </aside>

    </div>
  </div>
</main>