<?php
error_reporting(0);
include 'config.php';
$title = 'Новостная лента';
include 'head.php';



$id=(htmlspecialchars(stripslashes(trim($id))));
$pass=(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
}
else
{
echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!</div>
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

if($pass!=$data['pass'])
{
echo '<div class="menu">Ошибка!<br/>
	Ты не админ, в авторизации отказано!</div>
	<div class="menu"><a href="game.php?id='.$id.'&amp;pass='.$pass.'">Назад</a></div>';
	include 'foot.php';
	exit();
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

echo '<div class="head">Новости ресурса</div>';

$startan = $_GET['startan'];

if(empty($startan)) $startan = 0;
$startan=intval($startan);
if($startan<0) $startan=0; $num_msgs_an=5;
$arr = mysql_query("SELECT * from `news`");
$qi = mysql_query("SELECT * from `news` ORDER by `dbid` DESC LIMIT $startan,$num_msgs_an;;;");
if (mysql_affected_rows()==0)
{
echo '<div class="menu">';
echo "Новостей ещё нет!";
echo '</div>';
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
$row = str_replace('&lt;/i&gt;', '</i>', $row);
echo '<div class="menu">';
echo '['.$row['date'].']<br/>';
echo ''.$row['text'].'<br/>';
echo '['.$row['login'].']<br/>';
echo '</div>';
}
}
echo '<div class="menu">';
$i = @mysql_num_rows($arr);
if($startan!=0)
echo '<a href="?id='.$id.'&amp;pass='.$pass.'&amp;startan='.($startan-$num_msgs_an).'">&laquo;</a> | ';
if($i>$startan+$num_msgs_an)
echo '<a href="?id='.$id.'&amp;pass='.$pass.'&amp;startan='.($startan+$num_msgs_an).'">&raquo;</a>';
echo '</div>';
include 'foot.php';
?>