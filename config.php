<?php
require "vendor/autoload.php";
use \RedBeanPHP\R as R;
	//DB
	R::setup('mysql:host=127.0.0.1;dbname=makeAuth','root','');
	if(!R::testConnection()){
		exit('Not connection to DB');
	}
	
	//VIEW
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem('views');
	
	$twig = new Twig_Environment($loader);
	
	
?>