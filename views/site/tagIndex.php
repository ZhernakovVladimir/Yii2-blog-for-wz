<?php
    $this->title =$tag->name ;
    $this->params['breadcrumbs'][] =[
        'label' => $tag->name,
        //'url' => '/' . $category->url,
    ];

?>

<? foreach($tag->articles as $article) :?>
    <a href="/<?=  $article->category->url . '/' . $article->url ?>"><?= $article->name ?></a> <br>
<? endforeach; ?>
