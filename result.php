<?php
include 'config.php';

	//ПРОВЕРКА ЕСТЬ ЛИ КУКИ
	if($_COOKIE['login']==""){
		header('Location: index.php'); exit;
	}
	
	//ЕСЛИ НАЖАТЬ НА EXIT
	if(isset($_POST['Exit'])){
		setcookie('login', '', time()); 
		header('Location: index.php'); exit;
	}
	$login=$_COOKIE['login'];
	$counter=0;
	
	//СЧИТЫВАНИЕ СЧЁТЧИКА
	$users = R::find('user',' login LIKE ?',array($login));
	$user = R::exportAll($users);		
	$user=$user[0];
	$counter = (integer)$user[counter];
	
	//ИНКРЕМЕНТИРОВАНИЕ СЧЁТЧИКА
	if(isset($_POST['count'])){
		$counter++;
		$users= R::load('user',$user[id]);
		$users->counter=$counter;
		R::store($users);
	}
	
		$templ = $twig->loadTemplate('result.html');
		echo $templ->render(array('counter'=>$counter));
?>
