<?php
  include 'adminpanel/db.php';
	include 'components/functions.php';
	//crowdCount();		
	if(!isset($_COOKIE['User'])){
		
		setcookie('User','HERE');
		$_COOKIE['Switch']='off';
	}
	
	if(isset($_GET['download'])){
		$file = 'files/job.zip';
		if (file_exists($file)) {
    		header('Content-Description: File Transfer');
    		header('Content-Type: application/octet-stream');
    		header('Content-Disposition: attachment; filename='.basename($file));
    		header('Expires: 0');
    		header('Cache-Control: must-revalidate');
    		header('Pragma: public');
    		header('Content-Length: ' . filesize($file));
    		readfile($file);
		}
	}
	if(isset($_GET['link'])){
		$link=$_GET['link'];
	}
	else{
		$link='mainpage';
	}	        
	include 'view/header.php';
	include 'controller/directionController.php';
  include 'view/footer.php';
	
	


	


