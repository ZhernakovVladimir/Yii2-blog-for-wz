<?php foreach ($categories as $category):?>
    <li><a href="/<?= $category->url ?>"><?= $category->name ?></a></li>
<?php endforeach;?>