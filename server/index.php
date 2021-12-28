<?php 
require __DIR__.'/vendor/autoload.php';
use \App\Model\News;

define('PAGE_TITLE','Página Inicial');
$news = News::getNews();
exit;


include __DIR__.'/Resource/pages/header.php';
include __DIR__.'/Resource/pages/home.php';
include __DIR__.'/Resource/pages/footer.php';