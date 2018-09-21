<?php
	$login=$_POST['login'];
	$password=$_POST['password'];
	$dateBRTH=$_POST['date'];
	$error=0;
	
	//	ПРОВЕРКА СОВПАДЕНИЯ ПАРОЛЕЙ
	if($password != $_POST['password2']){
		echo 'Пароли не совпадают <br>';
		$error=1;
	} 
	
	// ПРОВЕРКА ВОЗРАСТА
	$age=intval((strtotime('now')-strtotime($dateBRTH))/86400);
	if($age>30000 and $error==0){
		echo 'Вы слишком стары, вам ',intval($age/365), ' лет и ',$age%365,' дней <br>';
		$error=1;
	}
	if($age<1000 and $error==0){
		echo 'Вы слишком молоды, вам ', intval($age/365) ,' лет и ', $age%365 ,' дней <br>';
		$error=1;
	}
	
	//ПРОВЕРКА ПУСТЫЕ СТРОКИ
	if($login=="" or $password=="" and $error==0){
		echo 'Введите логин или пароль <br>';
		$error=1;
	}
	
	//ПРОВЕРКА УНИКАЛЬНОСТИ ЛОГИНА
	$texFile=file_get_contents('file.txt');
	$arrTextFile=explode(' ',$texFile);
	$i=0;
	while(count($arrTextFile)>=$i+3 and $error==0){
		if($arrTextFile[$i]==$login){
			echo 'Логин не должен повторяться! <br>';
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
	
?>

<!Doctype html>
<html>
<head>
	<meta charset="utf-8">
	<style>
	<!-- ПРОСТО ПОСЕРЕДИНЕ ФОРМЫ РАСПОЛОЖИМ -->
		.center{
			text-align:center;
		}
	</style>
</head>
<body>
	<!-- СТАНДАРТНАЯ ФОРМА ДЛЯ РЕГИСТРАЦИИ-->
	<form action="" method="post" class="center"> 
			<input type="" name="login" placeholder="Логин тут"><br>
			<input type="password" name="password" placeholder="Пароль тут"><br>
			<input type="password" name="password2" placeholder="Повторите пароль"><br>
			Дата рождения<br>
			<input type="" name="date" placeholder="гггг-мм-дд"><br>
			<button>Регистрировать</button>
	</form>

</body>
</html>