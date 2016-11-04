function Snake(x,y){
	var x=x;
	var y=y;
    var direction='Nowhere';
    var snakeColor='green';
	var snakeLength=new Array(new snakeBody(x,y),new snakeBody(x-10,y),new snakeBody(x-20,y));
    this.pushBody=function(){
        snakeLength.push(new snakeBody(snakeLength[snakeLength.length-1].x,snakeLength[snakeLength.length-1].y));
    }
	this.move=function(whereToGo){
		direction=whereToGo;
	}
    this.setPosition=function(x1,y1){
        x=x1;
        y=y1;    
    }
    this.showCoordinates=function(){
        return [x,y];
    }
    this.directionWay=function(){
        return direction;
    }
    this.getSnakeFirstBody=function(){
      return snakeLength[0];
    }
    this.getSnakeLength=function(){
        return snakeLength;
    }
    this.setColor=function(color){
        snakeColor=color;   
    }
    this.checkHealth=function(){
        for(var count=1;count<snakeLength.length;count++){
            if(snakeLength[0].x===snakeLength[count].x&&snakeLength[0].y===snakeLength[count].y){
 
                return true;
            }
        }
    }
    this.changePosition=function(){
        if(direction==="LEFT"){
            var snlen=snakeLength.length;
            for(var count=1;count<=snlen;count++){
                if(count===snlen){snakeLength[0].x-=10;continue;}
                snakeLength[snlen-count].y=snakeLength[snlen-count-1].y;
                snakeLength[snlen-count].x=snakeLength[snlen-count-1].x;
                
            }    
        }
        if(direction==="UP"){
            var snlen=snakeLength.length;
            for(var count=1;count<=snlen;count++){
                if(count===snlen){snakeLength[0].y-=10;continue;}
                snakeLength[snlen-count].y=snakeLength[snlen-count-1].y;
                snakeLength[snlen-count].x=snakeLength[snlen-count-1].x;
                
            }            
        }
        if(direction==="RIGHT"){
            var snlen=snakeLength.length;
            for(var count=1;count<=snlen;count++){
                if(count===snlen){snakeLength[0].x+=10;continue;}
                snakeLength[snlen-count].y=snakeLength[snlen-count-1].y;
                snakeLength[snlen-count].x=snakeLength[snlen-count-1].x;
                
            }            
        }
        if(direction==="DOWN"){
            var snlen=snakeLength.length;
            for(var count=1;count<=snlen;count++){
                if(count===snlen){snakeLength[0].y+=10;continue;}
                snakeLength[snlen-count].y=snakeLength[snlen-count-1].y;
                snakeLength[snlen-count].x=snakeLength[snlen-count-1].x;
                
            }                
        }  
        
        if(snakeLength[0].x<0)snakeLength[0].x=490;
        if(snakeLength[0].y<0)snakeLength[0].y=390;
        if(snakeLength[0].x>490)snakeLength[0].x=0;
        if(snakeLength[0].y>390)snakeLength[0].y=0;
               
    }
    this.drawSnake=function(){
        for(var count=0,x1=0,y1=0;count<snakeLength.length;count++,x1-10,y1-10){
            snakeLength[count].drawBody();
            
        }
    }
}
