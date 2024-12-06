<?php

if(!isset($_GET['pg'])) $pg=0; else $pg=$_GET['pg'];

switch($pg){
	case 1: require "products.php";break;
	case 2: require "login.php";break;
	case 3: require "registar.php";break;
	default: require "registar.php";break;
}
?>