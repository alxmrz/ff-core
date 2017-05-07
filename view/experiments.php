<?php $this->addLocalCss('experiments/css/experiments.css'); 
$this->setTitle("Эксперименты");
?>
<div id="game">
    <div id="knui">	
        <div id="level">
            Уровень сложности:
            <select name="lvl"  id="lvl">
                <option  name="easy" >Легко</option>
                <option name="normal" >Нормально</option>
                <option name="difficult" >Сложно</option>
            </select>
        </div><hr />
        <div id="gameui">
            <ul>
                <li><input type="button" onclick='mainProcess(this)' value=" " id="cell1" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell2" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell3" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell4" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell5" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell6" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell7" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell8" /></li>
                <li><input type="submit" onclick='mainProcess(this)' value=" " id="cell9" /></li>
            </ul>
            <button onclick="location.reload();">Начать игру заново</button>
        </div>
    </div>
    <div id="snake">
        <canvas id="myCanvas" width="500" height="400">
            Ваш браузер не поддерживает технологию Canvas
        </canvas>
    </div>
</div>
<div id="gameblock">
    <ul>
        <li id="knlink">Крестики-нолики</li>
        <li id="sklink">Змейка</li>

    </ul>
    Змейка:<div id="XSY"></div>
    Еда:<div id="XFY">
    </div>
    <?php
    $this->addLocalJs([
        'experiments/js/games.js',
        'experiments/js/kn/kn.js',
        'experiments/js/snake/AI_snake.js',
        'experiments/js/snake/classFood.js',
        'experiments/js/snake/classSnake.js',
        'experiments/js/snake/classSnakeBody.js',
        'experiments/js/snake/functions.js',
        'experiments/js/snake/snake.js'
    ]);
    ?>