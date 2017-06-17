/**
 * Класс "Еды"
 * @constructor
 */
function Food() {
    /**
     * Значение координаты x
     */
    this.x;
    /**
     * Значение координаты y
     */
    this.y;
    /**
     * Установить значение координат еды
     * @param x1
     * @param y1
     */
    this.setFoodCoord = function (x1, y1) {
        this.x = x1;
        this.y = y1;
    }
    /**
     * Прорисовка еды на холсте
     */
    this.drawFood = function () {
        ctx.fillStyle = "yellow";
        ctx.fillRect(this.x, this.y, 10, 10);
    }
}
