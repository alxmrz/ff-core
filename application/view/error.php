<!DOCTYPE html>
<html>
    <header>
        <title>Ошибка!</title>
        <meta charset="utf-8">
    </header>
    <body>
        <h1>Упс! Что-то пошло не так:(</h1>
        <p><?= $additionInfo;?></p>
        <?php if($errorMessage): ?>
            <p><?= $errorMessage; ?></p>
        <?php endif;?>
        <p>
            <a href="http://i98535xh.bget.ru">Вернуться на главную страницу</a>
        </p>
    </body>
</html>

