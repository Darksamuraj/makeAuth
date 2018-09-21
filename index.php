<?php
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
	
	//ЕСЛИ УЖЕ АВТОРИЗОВАН, ТО ПОСЫЛАТЬ НА СТРАНИЧКУ С КЛИКЕРОМ
	if($_COOKIE['login']!=""){
		header('Location: result.php'); exit;
	} else {
		if(isset($_POST['go'])){
			echo 'не правильный логин или пароль <br>';
		}
	}
	
?>
<!Doctype html>
<html>
<head>
	<meta charset="utf-8">
	<style>
	<!-- НАЧАЛ 21.09.2018 21:17-->
	<!-- ПРОСТО ПОСЕРЕДИНЕ ФОРМЫ РАСПОЛОЖИМ -->
		.center{
			text-align:center;
		}
	</style>
</head>
<body>
	<!-- СТАНДАРТНАЯ ФОРМА С ОТСЫЛКОЙ В ФАЙЛ ВХОДА-->
	<form action="" method="post" class="center"> 
			<input type="" name="login" placeholder="Логин тут"><br>
			<input type="password" name="password" placeholder="Пароль тут"><br>
			<button name="go">Войти</button>
	</form>
	<!-- ОТДЕЛЬНАЯ ФОРМА ДЛЯ РЕГИСТРАЦИИ -->
	<form action="signUp.php" method="post" class="center">
			<button>Зарегистрироваться</button>
	</form>

</body>
</html>