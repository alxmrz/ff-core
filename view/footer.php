        </div>
            <ul id="menu">

                <li><a href="/mainpage/" >Информация</a></li>
                <li><a href="/skills/">Навыки</a></li>
                <li><a href="/experiments/" >Игры</a></li>
                <li><a href="/feedback/" >Отзывы</a></li>
            </ul>
        </fieldset>
    </div>
</div>
<?php if(isset($link)):?>
<?php foreach(glob("view/{$link}/js/*.js") as $jsName ):?>
<script type='text/javascript' src="<?=DIRECTORY_SEPARATOR . $jsName?>"></script>
<?php endforeach;?>

<?php foreach(glob("view/{$link}/js/*/*.js") as $jsName ):?>
<script type='text/javascript' src="<?=DIRECTORY_SEPARATOR . $jsName?>"></script>
<?php endforeach;?>
<?php endif;?>
<script src="http://code.jquery.com/jquery.js"></script>
<!--<script src="dependencies/bootstrap/js/bootstrap.min.js"></script>-->
<script type="text/javascript" src="view/js/main.js"></script>
<script type="text/javascript" src="view/js/clock.js"></script>
</body>
</html>
