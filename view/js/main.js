var field=document.getElementById("mainfield");
var on=document.getElementById('ON');
var off=document.getElementById('OFF');
var standby=document.getElementById('standby');

if(getCookie('Switch')==='on'){
    on.style.backgroundColor="lime";
        off.style.backgroundColor="darkred";
	field.style.display="block";
        standby.style.display='none';
    
}

else{
	setCookie('Switch','off');
}
if(getCookie('Switch')=='off'){
    field.style.display="none";
}

on.onclick= function(){
	if(getCookie('Switch')=='off'){
    on.style.backgroundColor="lime";
    off.style.backgroundColor="darkred";
	field.style.display="block";   
    standby.style.display='none';
	setCookie('Switch','on');
	}
	
}

off.onclick= function(){
	if(getCookie('Switch')=='on'){
    	on.style.backgroundColor="#0C3812";
        off.style.backgroundColor="red";             
        field.style.display="none";
        standby.style.display='block';
        setCookie('Switch','off');
	}
}

