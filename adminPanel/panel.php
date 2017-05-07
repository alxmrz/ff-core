<!DOCTYPE html>
<html>
    <head>
        <title>Admin Panel</title>
    </head>
    <body>
        <ul>
            <?php
            session_start();
            echo $_SESSION['fullname'];
            ?>
            <li><a href="controller.php?link=music">Music</a></li>
            <li><a href="controller.php?link=recalls">Recalls</a></li>
            <li><a href="../index.php">Site</a></li>
        </ul>
    </body>
</html>

