<?php
$this->addLocalCss('webeditor/css/webeditor.css');
?>
<div id="webeditor">

    <div id='mainMenu'>
        <ul id='mainMenuList'>
            <li>Файл
                <ul class="SubMenu">
                    <li><a href="/create/">Создать</a>
                        <ul id="FileSubSubList">
                            <li><a href="/createFile/">Файл</a>
                                <ul id="FileTypeList">
                                    <li><a href="/createHtmlFile/">HTML</a></li>
                                    <li><a href="/createCssFile/">CSS</a></li>
                                    <li><a href="/createPhpFile/">PHP</a></li>
                                    <li><a href="/createJsFile/">JS</a></li>
                                </ul>
                            </li>
                            <li><a href="/createFolder/">Папку</a></li>
                        </ul>
                    </li>
                    <li><a href="">Переименовать</a></li>
                    <li><a href="">Удалить</a></li>
                </ul>
            </li>

            <li>Синтаксис
                <ul class="SubMenu">
                    <li>PHP</li>
                    <li>JS</li>
                    <li>XML</li>
                    <li>HTML</li>
                </ul>
            </li>
            <li>Справка</li>
        </ul>
    </div>
    <div id='workPanel'>
        <aside>
            <?php if (isset($files)): ?>
                <ul id='filesList'>
                    <?php foreach ($files as $file): ?>
                        <li><?= $file; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </aside>

        <textarea cols="90" rows="35" id='codeScreen'>
            <?php if (isset($response)): ?>
                <?php print_r($response); ?>
            <?php endif; ?>
        </textarea>

    </div>
    <div id='statusBar'></div>

</div>
<?php
$this->addLocalJs([
    'experiments/js/games.js',
    'experiments/js/kn/kn.js',
    'experiments/js/snake/AI_snake.js',
    'experiments/js/snake/classFood.js',
    'experiments/js/snake/classSnake.js',
    'experiments/js/snake/classSnakeBody.js',
    'experiments/js/snake/functions.js',
    'experiments/js/snake/snake.js',
    'expreriments/webeditor/webeditor.js'
]);
?>