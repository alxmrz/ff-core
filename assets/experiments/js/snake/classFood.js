function Food(){
    this.x;
    this.y;
    this.setFoodCoord=function(x1,y1){
        this.x=x1;
        this.y=y1;
    }
    this.drawFood=function(){
        ctx.fillStyle="yellow";
        ctx.fillRect(this.x,this.y,10,10);
    }
}
