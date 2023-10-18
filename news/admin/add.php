<?php
error_reporting(0);
include '../config.php';
$title = 'Список новостей';
include 'head.php';



$id=(htmlspecialchars(stripslashes(trim($id))));
$pass=(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban,admin from users where id='".$id."';");
}
else
{
echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!222</div>
	<div class="menu"><a href="./../../index.php">Назад</a></div>';
	include 'foot.php';
	exit();
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$money=$data['money'];
$level=$data['level'];
$police=$data['police'];
$health=$data['health'];
$cars=$data['cars'];
$guns=$data['guns'];
$nums=$data['nums'];
$voo_por=$data['voodoo'];
$golod=$data['golod'];
$secur=$data['secur'];
$zav=$data['zav'];
$lsd=$data['lsd'];
$ban=$data['ban'];
$admin=$data['admin'];

if($pass!=$data['pass'])
{
echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!</div>
	<div class="menu"><a href="./../../index.php">Назад</a></div>';
	include 'foot.php';
	exit();
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");
echo '<div class="head">Список новостей</div>';

$login = $_POST['login'];
$go = $_GET['go'];
$text = $_POST['text'];
$date = date("d.m.Y");



$data = mysql_fetch_array(mysql_query("SELECT * FROM `users` "));
if($admin != 7)
{
	echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!</div>
	<div class="menu"><a href="./../../index.php">Назад</a></div>';
	include 'foot.php';
	exit();
}
else
{
if($go == 'add')
{
	// Обрабатываем на плохие символы прежде чем записать в БД
	if(get_magic_quotes_gpc()) $text = stripslashes($text);
	$text = mysql_escape_string(htmlspecialchars(trim($text), ENT_QUOTES));
	$login=$data['login'];
	mysql_query("INSERT INTO `news` VALUES ('', '".$text."', '".$login."', '".$date."')") or die(mysql_error());
	echo '<div class="menu">Новость успешно добавлена!</div>
	<div class="menu"><a href="?id='.$id.'&amp;pass='.$pass.'">Назад</a><br/>
	<a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';
	include 'foot.php';
	exit();
}

echo '<div class="menu"><form action="?id='.$id.'&amp;pass='.$pass.'&amp;go=add" method="POST">
Введите новость:<br/>
<textarea name="text" rows="5" cols="25"></textarea><br/>
<input type="submit" value="Добавить" /></form></div>';
echo '<div class="menu"><a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';

include 'foot.php';
}
?>