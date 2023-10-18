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
	Ты не админ, в авторизации отказано!!!!!!</div>
	<div class="menu"><a href="index.php">Назад</a></div>';
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
	<div class="menu"><a href="./../../index.php?id='.$id.'&amp;pass='.$pass.'">Назад</a></div>';
	include 'foot.php';
	exit();
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");
echo '<div class="head">Список новостей</div>';


$go = $_GET['go'];
$startan = $_GET['startan'];
$dbid = $_GET['dbid'];
$text = $_POST['text'];


// Обрабатываем на плохие символы прежде чем записать в БД
	if(get_magic_quotes_gpc()) $text = stripslashes($text);
	$text = mysql_escape_string(htmlspecialchars(trim($text), ENT_QUOTES));



$data = mysql_fetch_array(mysql_query("SELECT * FROM `users` "));
if($admin != 7)
{
	echo '<div class="menu">Ошибка!<br/>
	ТЫ не админ, в авторизации отказано!</div>
	<div class="menu"><a href="./../../index.php?id='.$id.'&amp;pass='.$pass.'">Назад</a></div>';
	include 'foot.php';
	exit();
}
else
{
if($go == 'delete')
{
	mysql_query("DELETE FROM gb WHERE `dbid`='".$dbid."'") or die(mysql_error());
	echo '<div class="menu">Новость успешно удалена!</div>
	<div class="menu"><a href="?id='.$id.'&amp;pass='.$pass.'">Назад</a><br/>
	<a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';
	include 'foot.php';
	exit();
}
if($go == 'del')
{
	echo '<div class="menu">Вы действительно хотите удалить новость?<br/>
	<a href="?id='.$id.'&amp;pass='.$pass.'&amp;go=delete&amp;dbid='.$dbid.'">Удалить</a> | <a href="?id='.$id.'&amp;pass='.$pass.'">Отмена</a></div>
	<div class="menu"><a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';
	include 'foot.php';
	exit();
}

if($go == 'edit')
{
	$data = mysql_fetch_array(mysql_query("SELECT * FROM `gb` WHERE `dbid`='".$dbid."'"));
	echo '<div class="menu"><form action="?go=save&amp;dbid='.$dbid.'&amp;id='.$id.'&amp;pass='.$pass.'" method="POST">
    <textarea name="text" rows="5" cols="25">'.$data['text'].'</textarea><br/>
    <input type="submit" value="Сохранить" /></form></div>';
	include 'foot.php';
	exit();
}

if($go == 'save')
{
	mysql_query("UPDATE `gb` SET `text`='".$text."' WHERE `dbid`='".$dbid."'") or die(mysql_error());
	echo '<div class="menu">Успешно сохранено!</div>
	<div class="menu"><a href="?id='.$id.'&amp;pass='.$pass.'">Назад</a><br/>
	<a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';
	include 'foot.php';
	exit();
}

if(empty($startan)) $startan = 0;
$startan=intval($startan);
if($startan<0) $startan=0; $num_msgs_an=5;
$arr = mysql_query("SELECT * from `gb`");
$qi = mysql_query("SELECT * from `gb` ORDER by `dbid` DESC LIMIT $startan,$num_msgs_an;;;");
if (mysql_affected_rows()==0)
{
echo '<div class="menu">Новостей ещё нет!</div>';
echo '<div class="menu"><a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">Админка</a></div>';
include 'foot.php';
exit();
}
else
{
while($row=mysql_fetch_array($qi))
{
$row = str_replace('&lt;br/&gt;', '<br/>', $row);
$row = str_replace('&lt;b&gt;', '<b>', $row);
$row = str_replace('&lt;/b&gt;', '</b>', $row);
$row = str_replace('&lt;u&gt;', '<u>', $row);
$row = str_replace('&lt;/u&gt;', '</u>', $row);
$row = str_replace('&lt;i&gt;', '<i>', $row);
$row = str_replace('&lt;/i&gt;', '</i>', $row);
echo '<div class="menu">';
echo '['.$row['date'].']<br/>';
echo ''.$row['text'].'<br/>';
echo ''.$row['login'].'<br/>';
echo '<a href="?dbid='.$row['dbid'].'&amp;go=del&amp;id='.$id.'&amp;pass='.$pass.'">Удалить</a> | <a href="?dbid='.$row['dbid'].'&amp;go=edit&amp;id='.$id.'&amp;pass='.$pass.'">Редактировать</a><br/>';
echo '</div>';
}
}
echo '<div class="menu">';
$i = @mysql_num_rows($arr);
if($startan!=0)
echo '<a href="?startan='.($startan-$num_msgs_an).'&amp;id='.$id.'&amp;pass='.$pass.'">&laquo;</a> | ';
if($i>$startan+$num_msgs_an)
echo '<a href="?startan='.($startan+$num_msgs_an).'&amp;id='.$id.'&amp;pass='.$pass.'">&raquo;</a>';
echo '</div>';
echo '<div class="menu"><a href="./../../cpan/admina.php?id='.$id.'&amp;pass='.$pass.'">В админку</a></div>';

include 'foot.php';
}
?>