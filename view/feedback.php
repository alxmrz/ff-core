<?php
    $this->addLocalCss('feedback/css/feedback.css');
    $this->setTitle("Отзывы");
?>

<?php if(isset($error)):?>
    <div><h4><?=$error;?></h4></div>
<?php endif;?>

<div id="recalls">
    <h1>Отзывы</h1>
    <?php if (isset($data)): ?>
        <div class="recalls">
            <?php foreach ($data as $recall): ?>
                <div class="recall">
                    <p>Имя: <?php echo $recall['from'] . " Дата: " . $recall['date']; ?> </p>
                    <p>Комментарий: <?php echo $recall['comment']; ?></p> 
                </div>
                <hr />
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<h1>Ваш отзыв</h1>
<form action="index.php" method="post">
    <input type="text" class="text" placeholder="Ваше имя" required="required" name="from" /><br />
    <textarea name="comment" class="text" placeholder="Ваш отзыв" cols="30" required="required" rows="10"></textarea> <br />
    <input type="hidden" name="action" value="addComment" />
    <input type="submit" class="button" name="addComment" value="Добавить комментарий" />
</form>
