<?php
include '../config.php';
$title = 'Смена пароля';
include 'head.php';

echo '<div class="head">Смена пароля</div>';

$id = $_GET['id'];
$pass = $_GET['pass'];
$go = $_GET['go'];

//Проверка пароля
if(preg_match("#[^a-zA-Z_0-9]+#",$pass))
{
	echo '<div class="menu">Ошибка!<br/>
	Пароль введён не верно!<br/>
	Он может состоять из цифр, букв латинского алфавита и знака подчёркивания!</div>
	<div class="menu"><a href="in.php">Назад</a></div>';
	include 'foot.php';
	exit();
}

$data = mysql_fetch_array(mysql_query("SELECT * FROM `admin` "));
if($data['pass'] != $pass)
{
	echo '<div class="menu">Ошибка!<br/>
	Пароль не верный, в авторизации отказано!</div>
	<div class="menu"><a href="in.php">Назад</a></div>';
	include 'foot.php';
	exit();
}
else
{
if($go == 'add')
{    $pass = $_POST['pass'];
	mysql_query("UPDATE `admin` SET `pass`='".$pass."'") or die(mysql_error());
	echo '<div class="menu">Успешно сохранено!</div>
	<div class="menu"><a href="?pass='.$pass.'">Назад</a><br/>
	<a href="index.php?pass='.$pass.'">В панель</a></div>';
	include 'foot.php';
	exit();
}
$result = mysql_query("select * from admin");
while ($row = mysql_fetch_object($result))
{
echo '<div class="menu"><form action="?go=add&amp;pass='.$pass.'" method="POST">
Ваш пароль:<br/>
<input type="text" name="pass" maxlength="80" value="'.$row->pass.'" /><br/>
<input type="submit" value="Сохранить" /></form></div>';
echo '<div class="menu"><a href="index.php?pass='.$row->pass.'">В панель</a></div>';
}

include 'foot.php';
}
?>