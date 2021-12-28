<?php 
require __DIR__.'/vendor/autoload.php';
use \App\Model\News;

define('PAGE_TITLE','Adicionar Notícias');

if(isset($_POST['title'],$_POST['content'])){
    $news = new News($_POST['title'],$_POST['content']);
    try {
        $news->addNews();
        header('location: index.php?status=success');
        exit;
    } catch (Exception $e) {
        echo 'Erro: ',  $e->getMessage(), "\n";
    }
}




include __DIR__.'/Resource/pages/header.php';
include __DIR__.'/Resource/pages/addNewsForm.php';
include __DIR__.'/Resource/pages/footer.php';