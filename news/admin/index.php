<?php
error_reporting(0);
include '../config.php';
$title = 'Панель управления';
include 'head.php';



$id=(htmlspecialchars(stripslashes(trim($id))));
$pass=(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select id,login,pass,lsd,ban,admin from users where id='".$id."';");
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

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

if($admin != 7)
{
	echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!1212</div>
	<div class="menu"><a href="in.php">Назад</a></div>';
	include 'foot.php';
	exit();
}

echo '<div class="head">Панель управления</div>';





else
{
$result = mysql_query("select * from users");
while ($row = mysql_fetch_object($result))
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