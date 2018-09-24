<?php
include 'config.php';
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
	$texFile=file_get_contents('file.txt');
	$arrTextFile=explode(' ',$texFile);
	$i=0;
	while(count($arrTextFile)>=$i+3 and $error==0){
		if($arrTextFile[$i]==$login){
			$errorText =  'Логин не должен повторяться! ';
			$error=1;
			}
			$i+=3;
	}
	
	//ЗАПИСЬ НОВОГО ПОЛЬЗОВАТЕЛЯ В ФАЙЛ
	if($error==0 and isset($_POST['login'])){
		$texFile=file_get_contents('file.txt');
		$texFile.= ' '.$login.' '.$password.' 0';
		file_put_contents('file.txt',$texFile);
	}
	
	//ОТПРАВЛЕНИЕ НА ФАЙЛ РЕЗУЛЬТАТА И КУКИ
	if($error==0 and isset($_POST['login'])){
		setcookie('login',$login,time()+3600*24);
		header('Location: result.php'); exit;
	}	
	$templ = $twig->loadTemplate('Sign_up.html');
	echo $templ->render(array('error'=>$errorText));
?>