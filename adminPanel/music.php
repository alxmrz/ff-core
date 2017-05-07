<?php var_dump($audios); ?>
<!DOCTYPE html>
<html>
    <head>
        <title>
            Music
        </title>
    </head>
    <body>
        <a href="controller.php?exit=true">Exit</a>
        <a href="panel.php">Panel</a>
        <form action="controller.php" enctype="multipart/form-data" method="post">
            <input type='file' name='file' />
            <input type='submit' name='addmusic' value='Добавить музыку' />
        </form>
        <h3>Music</h3>
        <?php foreach ($audios as $audio): ?>
            <div class="audio">
                <strong><?php echo $audio['name']; ?></strong><br />
                <form action="controller.php" method="post">
                    <input type="hidden" value="<?php echo $audio['name']; ?>" name="audioName" />
                    <input type="submit" value="Удалить запись" name="deleteAudio" />
                </form>
                <audio src="../music/mp3/<?php echo $audio['name']; ?>" controls>
                    Audio is not supported on your computer!
                </audio>
            </div>
        <?php endforeach; ?>
    </body>
</html>

