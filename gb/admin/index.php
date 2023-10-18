<?php
include '../config.php';
$title = 'Панель управления';
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
	Ты не админ, в авторизации отказано!!!!!!</div>
	<div class="menu"><a href="game.php?id='.$id.'&amp;pass='.$pass.'">Назад</a></div>';
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
	<div class="menu"><a href="game.php?id='.$id.'&amp;pass='.$pass.'">Назад</a></div>';
	include 'foot.php';
	exit();
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");



echo '<div class="head">Панель управления</div>';




if($admin != 7)
{
	echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!1212</div>
	<div class="menu"><a href="in.php">Назад</a></div>';
	include 'foot.php';
	exit();
}
else
{

while ($row = mysql_fetch_object($q))
{
echo '<div class="menu">
<a href="news.php?id='.$id.'&amp;pass='.$pass.'">Список новостей</a><br/>
<a href="add.php?id='.$id.'&amp;pass='.$pass.'">Добавить новость</a><br/>
</div>
<div class="menu"><a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';
include 'foot.php';
}
}
?>