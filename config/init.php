<?php

define("DEBUG", 1);
define("ROOT", dirname(__DIR__));
define("WWW", ROOT . '/public');
define("APP", ROOT . '/app');
define("CORE", ROOT . '/vendor/ishop/core');
define("LIBS", ROOT . '/vendor/ishop/core/libs');
define("CACHE", ROOT . '/tmp/cache');
define("CONF", ROOT . '/config');
define("LAYOUT", 'xlia');

// http://ishop2.loc/public/index.php
$app_path = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}";
// http://ishop2.loc/public/
$app_path = preg_replace("#[^/]+$#", '', $app_path);
// http://ishop2.loc
$app_path = str_replace('/public/', '', $app_path);\

define("PATH", $app_path);
define("ADMIN", PATH . '/admin');

define('UPLOAD_PRODUCT_BASE', '/upload/products/base/');
define('UPLOAD_PRODUCT_GALLERY', '/upload/products/gallery/');
define('UPLOAD_PRODUCT_THUMBS', '/upload/products/thumbs/');
define('UPLOAD_CATEGORY_IMAGE', '/upload/categories/');


define("PRODUCTIMG", PATH . UPLOAD_PRODUCT_BASE);
define("GALLERYIMG", PATH . UPLOAD_PRODUCT_GALLERY);
define("THUMBSIMG", PATH . UPLOAD_PRODUCT_THUMBS);
define('CATEGORYIMG', PATH . UPLOAD_CATEGORY_IMAGE);

require_once ROOT . '/vendor/autoload.php';