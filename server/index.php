<?php 
require __DIR__.'/vendor/autoload.php';

use \App\Model\News;

$news = new News();

$news->addNews();

include __DIR__.'/includes/header.php';
include __DIR__.'/includes/news.php';
include __DIR__.'/includes/footer.php';