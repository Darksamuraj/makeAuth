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
	$numCounter=0;
	$i=0;
	$texFile=file_get_contents('file.txt');
	$arrTextFile=explode(' ',$texFile);
	while(count($arrTextFile)>=$i+3){
		if($arrTextFile[$i]==$login){
			$counter=(integer)$arrTextFile[$i+2];
			setcookie('numCounter',$i+2,time()+3600*24);
		}
		$i+=3;
	}
	//ИНКРЕМЕНТИРОВАНИЕ СЧЁТЧИКА
	if(isset($_POST['count'])){
		$counter++;
		$numCounter=(integer)$_COOKIE['numCounter'];
		$arrTextFile[$numCounter]=$counter;
		$texFile=implode(' ',$arrTextFile);
		file_put_contents('file.txt',$texFile);
	}
		$templ = $twig->loadTemplate('result.html');
		echo $templ->render(array('counter'=>$counter));
?>
