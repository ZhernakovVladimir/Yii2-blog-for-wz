
    <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Категории <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?= $categorylist;?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Теги <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?= $taglist;?>
                    </ul>
                </li>
                <li><a href="/anonce">Анонс</a></li>
                <li><a href="/about">О нас</a></li>

                <li><a href="/contact">Контакты</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>