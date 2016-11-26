<?php

if($link==='feedback')
{
    try
    {
    $sql='SELECT * FROM recalls';
    $s=$pdo->query($sql);
    $result=$s->fetchAll();
    foreach($result as $res)
    {
        $recalls[]=array(
          'name'=>$res['name'],
          'content'=>$res['content'],
          'time'=>$res['time']
        );
    }
    }
    catch(Exception $e)
    {
        $errorMessage='Something wrong! Try again later.';
        $messageToDeveloper='Ошибка при попытке подключения к таблице recalls!';
        $errorDate=date('Y-m-d H:i:s');
        $logInfo="**********************{$messageToDeveloper}*******************\r\n"
                ."Time of error: {$errorDate}\r\n Error: [{$e->getMessage()}]\r\n "
                . "IN {$e->getFile()}\r\n "
                . "ON LINE{$e->getLine()}\r\n";
        file_put_contents("siteLog.txt", $logInfo,FILE_APPEND);
        require 'view/error.php';
        require 'view/footer.php';
        exit();
    }
}
if($link==='games')
{
    $scripts='<script type="text/javascript" src="view/games/js/games.js"></script>
    <script type="text/javascript" src="view/games/js/kn/kn.js"></script>3
    <script type="text/javascript" src="view/games/js/snake/AI_snake.js"></script>
    <script type="text/javascript" src="view/games/js/snake/classFood.js"></script>
    <script type="text/javascript" src="view/games/js/snake/classSnake.js"></script>
    <script type="text/javascript" src="view/games/js/snake/classSnakeBody.js"></script>
    <script type="text/javascript" src="view/games/js/snake/functions.js"></script>
    <script type="text/javascript" src="view/games/js/snake/snake.js"></script>';
		
}
if(isset($_POST['addComment']))
{
  $sql='INSERT INTO recalls SET name=:name,content=:content,time=NOW()';
  $s=$pdo->prepare($sql);
  $s->bindValue(':name',  $_POST['name']);
  $s->bindValue(':content',$_POST['content']);
  $s->execute();
  header('Location: index.php?link=recalls');       
  exit();
}
if(!include 'view/'.$link . '/' . $link . '.php')
{
    echo "No access to " . $link;
}	
