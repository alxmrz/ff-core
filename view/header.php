<!DOCTYPE html>
<html>
<head>
  <title></title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
 <!-- <link href="dependencies/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="screen" />-->
  <link href="view/css/general.css" type="text/css" rel="stylesheet" />
	<link href="view/css/id.css" type="text/css" rel="stylesheet" />
	<link href="view/css/class.css" type="text/css" rel="stylesheet" />
	<link href="view/<?php echo $link;?>/css/<?php echo $link;?>.css" type="text/css" rel="stylesheet" /> 
  <script type="text/javascript" src="view/js/cookie.js"></script>
</head>

<body>  
  <div id="mainblock">      
  	<div id="mainContainer">
	<div id="buttonblock">
		<button type="button"  value="" id="OFF">ВЫКЛ</button>
		<button type="button" value="" id="ON">ВКЛ</button>
  </div>
<?php if(isset($_COOKIE['Switch'])&&$_COOKIE['Switch']==='on'):?>
  <img src="image/standby.jpg" style="display:none" alt="standby" id="standby"/>
<?php endif;?>
<?php if(isset($_COOKIE['Switch'])&&$_COOKIE['Switch']==='off'):?>
  <img src="image/standby.jpg" style="display:block" alt="standby" id="standby"/>
<?php endif;?>
  <fieldset id="mainfield">
	<legend>Alexandr Moroz</legend>
	<div id="clocks"></div>
	<div id="container">

