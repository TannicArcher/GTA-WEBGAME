<?php
error_reporting(0);
include 'config.php';
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
	 в авторизации отказано!</div>
	<div class="menu"><a href="./../index.php">На главную</a></div>';
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
	Ходи отсюда, в авторизации отказано!</div>
	<div class="menu"><a href="index.php">Назад</a></div>';
	include 'foot.php';
	exit();
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

$n=intval(@$_GET['n']);
echo '<title>Смайлы</title>';
echo '<div class="hu2"/><div class="hu1">';
require('incs/smiles.php');
$cnt=count($sstr);
for($c=0;$c<7;$c++){
 if($c+$n>$cnt-1) break;
 print $simg[$c+$n].' '.$sstr[$c+$n].'<center><span style="color: #65dd16;">******</span></center>';
}
print '</div><p>';

$path = 'sm';
$d=@opendir($path);
$s=0;
while($e=readdir($d)){
if(is_file($path."/".$e)) $s++;
}
echo 'Всего смайлов: '.$s.'<br />';

$n=$n+$c;
if($n<$cnt) print('&#8594;<a href="smile.php?id='.$id.'&amp;pass='.$pass.'&amp;n='.$n.'">Далее</a>');
print('<a href="index.php?id='.$id.'&amp;pass='.$pass.'">&#8592;B гoстeвую</a></p>');
include 'foot.php';
?>