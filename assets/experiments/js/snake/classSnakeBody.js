function snakeBody(x1,y1){
    this.x=x1;
    this.y=y1;
    var bodyColor = 'green';
    this.setColor=function(color){
        bodyColor=color;
    }
    this.drawBody=function(){
        ctx.strokeStyle="black";
        ctx.fillStyle=bodyColor;
        ctx.strokeRect(this.x,this.y,10,10);
        ctx.fillRect(this.x,this.y,10,10);
    }
}
