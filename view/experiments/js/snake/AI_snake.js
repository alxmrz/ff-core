function AI_snake(){
  var underControll=false;
  var snakes=new Array();
  this.findWay=function(food){
    
  }
  this.getControll=function(snake){
    this.underControll=true;
  }
  this.setSnakeDirection=function(snake,food){
    var SY=snake.getSnakeFirstBody().y;
    var SX=snake.getSnakeFirstBody().x;
    if(SY<food.y){
      if(snake.directionWay()==="UP")
      {
        snake.move("LEFT");
        return;
      }
      snake.move("DOWN");
      return;
    }
    if(SX<food.x){
      if(snake.directionWay()==="LEFT"){
        snake.move("DOWN");
        return;
      }
      snake.move("RIGHT");
      
      return;
    }
    if(SX>food.x){
      if(snake.directionWay()==="RIGHT"){
        snake.move("UP");
        return;
      }
      snake.move("LEFT");
      return;
    }
    if(SY>food.y){
      if(snake.directionWay()==="DOWN"){
        snake.move("RIGHT");
        return;
      }
      snake.move("UP");
      return;
    }
  }
}
