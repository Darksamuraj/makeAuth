<?php
include 'config.php';
use \RedBeanPHP\R as R;

	$login=$_POST['login'];
	$password=$_POST['password'];
	$dateBRTH=$_POST['date'];
	$error=0;
	$errorText="";
	
	//	ПРОВЕРКА СОВПАДЕНИЯ ПАРОЛЕЙ
	if($password != $_POST['password2']){
		$errorText = 'Пароли не совпадают';
		$error=1;
	} 
	
	// ПРОВЕРКА ВОЗРАСТА
	$age=intval((strtotime('now')-strtotime($dateBRTH))/86400);
	if($age>30000 and $error==0){
		$errorText =  'Вы слишком стары, вам '.intval($age/365).' лет и '. $age%365 .' дней ';
		$error=1;
	}
	if($age<1000 and $error==0){
		$errorText =  'Вы слишком молоды, вам '. intval($age/365) .' лет и '. $age%365 .' дней ';
		$error=1;
	}
	
	//ПРОВЕРКА ПУСТЫЕ СТРОКИ
	if($login=="" or $password=="" and $error==0){
		$errorText =  'Введите логин или пароль ';
		$error=1;
	}
	
	//ПРОВЕРКА УНИКАЛЬНОСТИ ЛОГИНА
	if($error==0){
		$users = R::find('user',' login LIKE ?',array($login));
		if(count($users)>0){
			$errorText =  'Логин не должен повторяться! ';
			$error=1;
		}
	}
	
	//ЗАПИСЬ НОВОГО ПОЛЬЗОВАТЕЛЯ В БД
	if($error==0 and isset($_POST['login'])){
			$user = R::dispense('user');
			$user->login =$login;
			$user->password = $password;
			$user->age = $dateBRTH;
			$user->counter='0';
			R::store($user);
	}
	
	//ОТПРАВЛЕНИЕ НА ФАЙЛ РЕЗУЛЬТАТА И КУКИ
	if($error==0 and isset($_POST['login'])){
		setcookie('login',$login,time()+3600*24);
		header('Location: result.php'); exit;
	}	
	$templ = $twig->loadTemplate('Sign_up.html');
	echo $templ->render(array('error'=>$errorText));
?>