<?php

include 'db.php';
include 'functions.php';

if (isset($_POST['subadmin']) && $_POST['username'] !== "" && $_POST['password'] !== '') {
    $name = $_POST['username'];
    echo "here!";
    $password = $_POST['password'];
    echo $name . ' ' . $password;
    $pass = md5($password . 'soul');
    $sql = "SELECT name,password FROM admins WHERE name=:name AND password=:password";
    $result = $pdo->prepare($sql);
    $result->bindValue(':name', $name);
    $result->bindValue(':password', $pass);
    $result->execute();
    $s = $result->fetchAll();
    if (count($s) > 0) {
        if (session_start()) {
            $_SESSION['fullname'] = $name;
            echo $_SESSION['fullname'];
            header('Location: panel.php');
            exit();
        } else {
            $output = "Sesstion did'n start";
            include 'error.php';
            exit();
        }
    }
}

if (isset($_GET['link']) && $_GET['link'] === 'recalls') {
    $sql = 'SELECT * FROM recalls';
    $s = $pdo->query($sql);
    $result = $s->fetchAll();
    foreach ($result as $res) {
        $recalls[] = array(
            'name' => $res['name'],
            'content' => $res['content'],
            'time' => $res['time']
        );
    }
    include 'recalls.php';
    exit();
}
if (isset($_POST['deleteComment'])) {
    $sql = 'DELETE FROM recalls WHERE content=:content';
    $s = $pdo->prepare($sql);
    $s->bindValue(':content', $_POST['comCon']);
    $s->execute();
    header('Location: controller.php?link=recalls');
    exit();
}
if (isset($_POST['addmusic'])) {
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . "music/mp3/" . $_FILES['file']['name'])) {
            $sql = 'INSERT INTO music SET name=:name,type=:type';
            $s = $pdo->prepare($sql);
            $s->bindValue(':name', $_FILES['file']['name']);
            $s->bindValue(':type', $_FILES['file']['type']);
            $s->execute();
            header('Location: controller.php?link=music');
            exit();
        } else {
            $output = "File is not moved" . __DIR__;
            include 'error.php';
            exit();
        }
    } else {
        $output = "Something has gone wrong";
        include 'error.php';
        exit();
    }
    header('Location: ?');
    exit();
}
if (isset($_GET['exit'])) {
    session_start();
    session_destroy();
    header('Location: index.php');
    exit();
}
if (isset($_GET['link']) && $_GET['link'] === 'music') {
    $sql = 'SELECT * FROM music';
    $s = $pdo->query($sql);
    $result = $s->fetchAll();
    foreach ($result as $res) {
        $audios[] = array(
            'name' => $res['name'],
            'type' => $res['type']
        );
    }
    include 'music.php';
    exit();
}
if (isset($_POST['deleteAudio'])) {
    $sql = 'DELETE FROM music WHERE name=:name';
    $s = $pdo->prepare($sql);
    $s->bindValue(':name', $_POST['audioName']);
    $s->execute();
    header('Location: controller.php?link=music');
    exit();
}