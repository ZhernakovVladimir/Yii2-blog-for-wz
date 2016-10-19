<?php
    $this->title =$category->name ;
    $this->params['breadcrumbs'][] =[
        'label' => $category->name,
        //'url' => '/' . $category->url,
    ];

?>
<?php foreach ($category->articles as $article):?>
    <a href=" /<?= $category->url ?>/<?= $article->url ?> "><?= $article->name ?></a> <br>
<?php endforeach;?>

