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
  /*  var SY1=snake1.getSnakeFirstBody().y;
    var SX1=snake1.getSnakeFirstBody().x;**/
   /* var SY2=snake2.getSnakeFirstBody().y;
    var SX2=snake2.getSnakeFirstBody().x;   */     
   // if(SY===food.y){alert('Is');}
    if(SY<food.y){
      /*if(SX+10===SX1||SX+10===SX2){
        snake.move("DOWN");return;
      }
      if(SX-10===SX1||SX-10===SX2){
        snake.move("UP");return;
      }
      if(SY+10===SY1||SY+10===SY2){
        snake.move("LEFT");return;
      } 
      if(SY-10===SY1||SY-10===SY2){
        snake.move("RIGHT");return;
      }                 
      if(snake.directionWay()==="UP"){
        snake.move("RIGHT");
        return;
      }*/
     
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
    /*console.log(snake.showCoordinates());
    alert('ddd'+snake.showCoordinates()[0]+'FOODX:'+food.y);*/
  }
}
