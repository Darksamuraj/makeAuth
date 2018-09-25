<?php
include 'config.php';
	//ПРОВЕРКА ПРАВИЛЬНОСТИ ЛОГИНА И ПАРОЛЯ В БД
	$login=$_POST['login'];
	$password=$_POST['password'];
	if(isset($_POST['go'])){
		$users = R::find('user',' login LIKE ?',array($login));
		$user = R::exportAll($users);		
		$user=$user[0];
		if($user[password]==$password){
			setcookie('login',$login,time()+3600*24);
			header('Refresh: 0.1; url=result.php');
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
