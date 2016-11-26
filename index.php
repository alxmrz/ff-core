<?php
  require 'autoloader.php';
  spl_autoload_register('classAutoloader');
  
  use model\HeaderElement\HeaderElement as HeaderElement;
  use model\BodyElement\BodyElement as BodyElement;
  use model\FooterElement\FooterElement as FooterElement;
  
  $urlParams = explode('/',($_SERVER['REQUEST_URI']));
  
  if(!empty($urlParams[1]))
  {
		$link=$urlParams[1];
	}
	else 
  {
		$link='mainpage';
	}	  
  
 
	$header = new HeaderElement($link);
  $body   = new BodyElement($link);
  $footer = new FooterElement($link);
  $header -> setTitle ('MainPage');  
	$header -> showYourself();
  
  $body   -> showYourself();
  $footer -> showYourself();
	
	


	


