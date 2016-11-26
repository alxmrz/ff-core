document.onkeydown=function(event){
    if(event.keyCode===37){
        if(mainSnake.directionWay()!=="RIGHT")mainSnake.move("LEFT");
    }
    if(event.keyCode===38){
        if(mainSnake.directionWay()!=="DOWN")mainSnake.move("UP");
    }
    if(event.keyCode===39){
        if(mainSnake.directionWay()!=="LEFT")mainSnake.move("RIGHT");
    }
    if(event.keyCode===40){
        if(mainSnake.directionWay()!=="UP")mainSnake.move("DOWN");       
    }

}
var xsy=document.getElementById("XSY");
var xfy=document.getElementById("XFY");
var mainSnake=new Snake(100,100);
//var secondSnake=new Snake(50,50);
//var thirdSnake=new Snake(200,200);
var aiSnake=new AI_snake();
var food=generateFood();
mainSnake.drawSnake();
//secondSnake.drawSnake();
//thirdSnake.drawSnake();
food.drawFood();
var game=setInterval(function(){
   
    if(food===undefined){
        food=generateFood();        
    }
    if(checkPositions(food,mainSnake)){
        food=undefined;
        mainSnake.pushBody();
    }
    if(mainSnake.directionWay()!=='Nowhere'){      
        mainSnake.changePosition();
       
        //thirdSnake.changePosition();
       // console.log(mainSnake.getSnakeLength()[0]);
        ctx.clearRect(0,0,500,400); 
        mainSnake.drawSnake();
        
        //thirdSnake.drawSnake();
        if(food!==undefined){
            food.drawFood();           
        }

    }
    
    /*if(mainSnake.checkHealth()){
        alert('Игра окончена!');
        location.reload();
    }*/
    aiSnake.setSnakeDirection(mainSnake,food);
              
    
   /* if(checkPositions(food,mainSnake)){
        food=undefined;
        mainSnake.pushBody();
    }
    aiSnake.setSnakeDirection(secondSnake,mainSnake,food);
        if(food===undefined){
        food=generateFood();        
    }
    if(checkPositions(food,secondSnake)){
        food=undefined;
        secondSnake.pushBody();
    }*/
   /* aiSnake.setSnakeDirection(thirdSnake,mainSnake,secondSnake,food);
    if(food===undefined){
        food=generateFood();        
    }
    if(checkPositions(food,thirdSnake)){
        food=undefined;
        thirdSnake.pushBody();
    }*/
    console.log(mainSnake.getSnakeFirstBody());
    xsy.innerHTML="X:"+mainSnake.getSnakeFirstBody().x+"Y: "+mainSnake.getSnakeFirstBody().y;
    xfy.innerHTML="X: "+food.x+"Y: "+food.y;
    ctx.fillStyle = "#76f69f";
    ctx.font = "italic 30pt Arial";
    ctx.fillText("Счет: "+mainSnake.getSnakeLength().length, 300, 30);
	
}
,1000/20);
