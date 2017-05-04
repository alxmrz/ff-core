function generateFood(){
    var randomX;
    var randomY;
    for(var x=true;x!==false;){
        randomX=Math.round(Math.random()*490);
        randomY=Math.round(Math.random()*390);
        if(randomX%10!==0||randomY%10!==0)continue;
        else{x=false};
    }
   
    var food=new Food();
    food.setFoodCoord(randomX,randomY);
    return food;
     
}
function checkPositions(food1,snake){
    if(food1.x===snake.getSnakeLength()[0].x&&food1.y===snake.getSnakeLength()[0].y)return true;
    else{return false;}
}
