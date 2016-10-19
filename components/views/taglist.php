<?php foreach ($tags as $tag):?>
    <li><a href="/tags/<?= $tag->url ?>"><?= $tag->name ?></a></li>
<?php endforeach;?>