<!DOCTYPE html>
<html>
<head>
    <title><?= $this->title; ?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->putGlobalCss(); ?>
</head>

<body>
<div id="mainblock">
    <div id="mainContainer">
        <fieldset id="mainfield">
            <legend>Alexandr Moroz</legend>
            <div id="clocks"></div>
            <div id="container">

                <div style="clear:both;"></div>
            </div>

            <div>
                <?=$content;?>
            </div>



            <ul id="menu">
                <li><a href="/mainpage/" >Информация</a></li>
                <li><a href="/skills/">Навыки</a></li>
                <li><a href="/experiments/" >Эксперименты</a></li>
                <li><a href="/feedback/" >Отзывы</a></li>
            </ul>
        </fieldset>
    </div>
</div>
<?php $this->putGlobalJs(); ?>
</body>
</html>
