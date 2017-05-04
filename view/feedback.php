<?php $this->addLocalCss('feedback/css/feedback.css');?>
<div id="recalls">
<h1>Отзывы</h1>
<?php if(isset($recalls)):?>
    <div class="recalls">
        <?php foreach($recalls as $recall): ?>
            <div class="recall">
                <p>Имя: <?php echo $recall['name']. " Дата: " .$recall['time'] ; ?> </p>
                <p>Комментарий: <?php echo $recall['content']; ?></p> 
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;?>

</div>
<h1>Ваш отзыв</h1>
<form action="index.php" method="post">
    <input type="text" class="text" placeholder="Ваше имя" required="required" name="name" /><br />
    <textarea name="content" class="text" placeholder="Ваш отзыв" cols="30" required="required" rows="10"></textarea> <br />
    <input type="submit" class="button" name="addComment" value="Добавить комментарий" />
</form>
