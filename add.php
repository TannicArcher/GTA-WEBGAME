<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$money=$data['money'];
$level=$data['level'];
$police=$data['police'];
$stage=$data['stage'];
$health=$data['health'];
$cars=$data['cars'];
$guns=$data['guns'];
$nums=$data['nums'];
$voo_por=$data['voodoo'];
$golod=$data['golod'];
$secur=$data['secur'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
else
echo '<br/>----<br/>';

// --------------------------------------------------------------------------------------------------------------------
$q = mysql_qw ('SELECT * FROM news WHERE id=?',$id);
if(mysql_num_rows($q)==0)
{
echo '[Новостей нет]';
}
switch ($act)
{case 'add':
$name = substr ($name,0,20);
$name=htmlspecialchars(stripslashes($name));
$msg = substr ($msg,0,512);
$msg=htmlspecialchars(stripslashes($msg));
$msg=str_replace("http://","",$msg);
$msg=str_replace("&","",$msg);
$msg=str_replace("&&","",$msg);
$msg=str_replace("wap.","",$msg);
$msg=str_replace("\r","",$msg);
$msg=str_replace("\n","",$msg);
$msg=str_replace(".wen.",".simwap.",$msg);
$msg=str_replace(".kmx.",".simwap.",$msg);
$msg=str_replace(".net.",".simwap.",$msg);
$msg=str_replace(".org.",".simwap.",$msg);
$msg=str_replace("пидарас","хороший чел!",$msg);
$msg=str_replace("хуё","***",$msg);
$msg=str_replace("хуи","***",$msg);
$msg=str_replace("хуй","***",$msg);

if($name =='' or $msg == '')
exit ("Не заполнены обязательные поля".$px);
$q = mysql_qw ('select * from news where id=?',intval($id));
if(mysql_num_rows ($q)==0) exit;
mysql_qw ('INSERT INTO news SET time=?,name=?,msg=?,id_news=?',time(),$login,$msg,intval($id)) or die(mysql_error());
echo 'Комент добавлен<br/>';


break;

default:
if ($admin==7)
{
echo
"<form action='add.php?id=$id&amp;pass=$pass&amp;act=add&amp;' method='post'>
Ваше имя:<input name='$login' /><br/>
Сообщение:<input type='text' name='msg' /><br/>
<input type='submit' value='Добавить' /></form>";
}else{
echo"
Ваше имя:<input name='$login'/><br/>
Мнение:<input name='msg'/><br/>
<anchor>Добавить<go href='add.php?id=$id&amp;pass=$pass&amp;act=add' method='post'>
<postfield name='name' value='$(login)'/>
<postfield name='msg' value='$(msg)'/>
</go></anchor>";}


break;
}


include("./../includes/foot.php");


mysql_close();
include "./../includes/footer.php";
?>
