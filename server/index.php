<?php 
require __DIR__.'/vendor/autoload.php';
use \App\Model\News;


$news = new News();
$news->addNews();


include __DIR__.'/Resource/pages/header.php';
include __DIR__.'/Resource/pages/news.php';
include __DIR__.'/Resource/pages/footer.php';