/**
 * Класс искуственного интеллекта змейки.
 * @constructor
 */
function AI_snake() {
    /**
     * Взята ли змейка под контроль игрока
     * @type {boolean}
     */
    var underControll = false;
    /**
     * Массив змеек
     * @type {Array}
     */
    var snakes = new Array();
    /**
     * Отправляет змейку под контроль игрока
     * @param snake
     * @return void
     */
    this.getControll = function (snake) {
        this.underControll = true;
    }
    /**
     * Устанавливает направление змейки. Вызывается каждый кадр
     * @param snake Объект змейки
     * @param food Объект еды
     */
    this.setSnakeDirection = function (snake, food) {

        /**
         * @var int SY значение Y "головы" змейки
         */
        var SY = snake.getSnakeFirstBody().y;

        /**
         * @var int SX значение X "головы" змейки
         */
        var SX = snake.getSnakeFirstBody().x;

        if (SY < food.y) {
            if (snake.directionWay() === "UP")
            {
                snake.move("LEFT");
                return;
            }
            snake.move("DOWN");
            return;
        }
        if (SX < food.x) {
            if (snake.directionWay() === "LEFT") {
                snake.move("DOWN");
                return;
            }
            snake.move("RIGHT");

            return;
        }
        if (SX > food.x) {
            if (snake.directionWay() === "RIGHT") {
                snake.move("UP");
                return;
            }
            snake.move("LEFT");
            return;
        }
        if (SY > food.y) {
            if (snake.directionWay() === "DOWN") {
                snake.move("RIGHT");
                return;
            }
            snake.move("UP");
            return;
        }
    }
}
