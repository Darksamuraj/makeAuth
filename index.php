<?php
include 'config.php';
	//ПРОВЕРКА ПРАВИЛЬНОСТИ ЛОГИНА И ПАРОЛЯ
	$login=$_POST['login'];
	$password=$_POST['password'];
	$texFile=file_get_contents('file.txt');
	$arrTextFile=explode(' ',$texFile);
	$i=0;
	if(isset($_POST['go'])){
		while(count($arrTextFile)>=$i+3){
			if($arrTextFile[$i]==$login){
				if($arrTextFile[$i+1]==$password){
					setcookie('login',$login,time()+3600*24);
					header('Refresh: 0.1; url=result.php');
				} 
			}
			$i+=3;
		}
	}
	$error="";
	//ЕСЛИ УЖЕ АВТОРИЗОВАН, ТО ПОСЫЛАТЬ НА СТРАНИЧКУ С КЛИКЕРОМ
	if($_COOKIE['login']!=""){
		header('Location: result.php'); exit;
	} else {
		if(isset($_POST['go'])){
			$error = 'не правильный логин или пароль';
		}
	}
	
	$templ = $twig->loadTemplate('Sign_in.html');
	echo $templ->render(array('error'=>$error));
?>
