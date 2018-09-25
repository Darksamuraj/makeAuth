<?php
	//ПОДКЛЮЧАЕМ RED BEAN
	require_once "vendor/rb/rb-mysql.php";
	R::setup('mysql:host=127.0.0.1;dbname=makeAuth','root','');
	if(!R::testConnection()){
		exit('Нет подключения к базе');
	}
	
	//ПОДКЛЮЧИМ TWIG
	require_once "vendor/twig/twig/lib/Twig/Autoloader.php";
	Twig_Autoloader::register();
	$loader = new Twig_Loader_Filesystem('views');
	
	$twig = new Twig_Environment($loader);
	
	
?>