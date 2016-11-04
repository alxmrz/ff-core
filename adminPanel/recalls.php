<?php var_dump($recalls); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Recalls
        </title>
    </head>
    <body>
        <a href="controller.php?exit=true">Exit</a>
        <a href="panel.php">Panel</a>
        Recalls:
        <?php foreach($recalls as $recall): ?>
        <p>Name: <?php echo $recall['name']; ?></p>
        <p>Comment: <?php echo $recall['content']; ?></p>
        <form action='controller.php' method='post'>
            <input type='hidden' value="<?php echo $recall['content']; ?>" name="comCon" />
            <input type="submit" value="Удалить комментарий" name="deleteComment" />
        </form>
        <?php endforeach; ?>
    </body>
</html>

