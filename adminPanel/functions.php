<?php

function checkAdmin($name,$password){
    include 'db.php';
    $pass=md5($password . 'soul');
    $sql="SELECT name,password FROM admins WHERE name=:name AND password=:password";
    $result=$pdo->prepare($sql);
    $result->bindValue(':name',$name);
    $result->bindValue(':password',$pass);
    $result->execute();
    $s=$result->fetchAll();
    if(count($s)>0){
        return true;
    }
    else{
        return false;
    }
}
function getMusic(){
    include 'db.php';
    $sql='SELECT * FROM music';
    $s=$pdo->query($sql);
    $result=$s->fetchAll();
    return $result;
}