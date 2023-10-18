<?php
error_reporting(0);
include 'config.php';
$title = 'Общение';
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

echo '<div class="head">Комната для общения</div>';


echo '<div class="menu"><a href="add.php?id='.$id.'&amp;pass='.$pass.'">написать сообщение</a></div>';

$startan = $_GET['startan'];

if(empty($startan)) $startan = 0;
$startan=intval($startan);
if($startan<0) $startan=0; $num_msgs_an=5;
$arr = mysql_query("SELECT * from `gb`");
$qi = mysql_query("SELECT * from `gb` ORDER by `dbid` DESC LIMIT $startan,$num_msgs_an;;;");
if (mysql_affected_rows()==0)
{
echo '<div class="menu">';
echo "Сообщений ещё нет!";
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
$row = preg_replace('~\[green\](.*?)\[/green\]~uis', '<span style="color: green">\\1</span>', $row);
$row = preg_replace('~\[red\](.*?)\[/red\]~uis', '<span style="color: red">\\1</span>', $row);
$row = preg_replace('~\[blue\](.*?)\[/blue\]~uis', '<span style="color: blue">\\1</span>', $row);
$row =str_replace(':)',"<img src='sm/smile2.gif' alt=':)'/>",$row);
$row =str_replace(':(',"<img src='sm/sad2.gif' alt=':('/>",$row);
$row =str_replace(';)',"<img src='sm/wink2.gif' alt=';)'/>",$row);
$row =str_replace(':-P',"<img src='sm/tongue2.gif' alt=':-P'/>",$row);
$row =str_replace('=-O',"<img src='sm/shok2.gif' alt='=-O'/>",$row);
$row =str_replace(':-[',"<img src='sm/blush2.gif' alt=':-['/>",$row);
$row =str_replace('.daun.',"<img src='sm/gy.gif' alt='daun'/>",$row);
$row =str_replace('.gy.',"<img src='sm/angel2.gif' alt='O:)'/>",$row);
$row =str_replace('.zzz.',"<img src='sm/zzz.gif' alt='zzz'/>",$row);
$row =str_replace(".ura.","<img src='sm/ura.gif' alt='ura'/>",$row);
$row =str_replace(".ninja.","<img src='sm/ninja.gif' alt='ninja'/>",$row);
$row =str_replace('.welcome.',"<img src='sm/welcome.gif' alt='welcome'/>",$row);
$row =str_replace('.hi.',"<img src='sm/hi.gif' alt='hi'/>",$row);
$row =str_replace('.pardon.',"<img src='sm/pardon.gif' alt='pardon'/>",$row);
$row =str_replace('.read.',"<img src='sm/read.gif' alt='read'/>",$row);
$row =str_replace('.unsure.',"<img src='sm/unsure.gif' alt='unsure'/>",$row);
$row =str_replace('.victory.',"<img src='sm/victory.gif' alt='victory'/>",$row);
$row =str_replace('.secret.',"<img src='sm/secret.gif' alt='secret'/>",$row);
$row =str_replace('.inlove.',"<img src='sm/inlove.gif' alt='inlove'/>",$row);
$row =str_replace('^^',"<img src='sm/shy.gif' alt='^^'/>",$row);
$row =str_replace('.vis.',"<img src='sm/vis.gif' alt='vis'/>",$row);
$row =str_replace('.tus.',"<img src='sm/tus.gif' alt='tus'/>",$row);
$row =str_replace('.gitara.',"<img src='sm/gitara.gif' alt='gitara'/>",$row);
$row =str_replace('.nunu.',"<img src='sm/nunu.gif' alt='nunu'/>",$row);
$row =str_replace('.banan.',"<img src='sm/banan.gif' alt='banan'/>",$row);
$row =str_replace('.joke.',"<img src='sm/joke.gif' alt='joke'/>",$row);
$row =str_replace('.elka.',"<img src='sm/elka.gif' alt='elka'/>",$row);
$row =str_replace('.flood.',"<img src='sm/flood.gif' alt='flood'/>",$row);
$row =str_replace('.spam.',"<img src='sm/spam.gif' alt='spam'/>",$row);
$row =str_replace('хуй',"<img src='sm/huy.gif' alt='censored'/>",$row);





echo '<div class="menu">';
echo '['.$row['date'].']<br/>';
echo ''.$row['text'].'<br/>';
echo '['.$row['login'].']<br/>';
echo '</div>';

}
}
echo '<div class="menu">';
$i = mysql_num_rows($arr);
if($startan!=0)
echo '<a href="?id='.$id.'&amp;pass='.$pass.'&amp;startan='.($startan-$num_msgs_an).'">&laquo;</a> | ';
if($i>$startan+$num_msgs_an)
echo '<a href="?id='.$id.'&amp;pass='.$pass.'&amp;startan='.($startan+$num_msgs_an).'">&raquo;</a>';
echo '</div>';
include 'foot.php';
?>