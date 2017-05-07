<?php

function crowdCount()
{
    global $pdo;
    $sql = 'UPDATE crowdcount SET count=count+1 WHERE id=1';
    $s = $pdo->query($sql);
    if (isset($_GET['link']))
        $link = $_GET['link'];
    if (!isset($link))
        $link = "info";
}
