<?
error_reporting(0);
/* mod by Lesnik*/
/* icq 366244181 */
include "./../ini2.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$login=cyr(htmlspecialchars(stripslashes(trim($login))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($login)) 
{  
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd from users where login='".cyr($login)."';");
}
elseif(!empty($id))
{
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$status=$data['status'];
$reg_data=$data['reg_data'];
$money=$data['money'];
$level=$data['level'];
$zav=$data['zav'];
if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");




if($zav != 1)
{
echo "ошибка,пароль не верный!";
}
elseif($zav == 1 &&  !isset($_GET['monet']) && !isset($_GET['monet2']) && !isset($_GET['status']) && !isset($_GET['status2']) && !isset($_GET['npass']) && !isset($_GET['npass2']) && !isset($_GET['newn']) && !isset($_GET['newn2']) && !isset($_GET['level']) && !isset($_GET['level2']) && !isset($_GET['userdel']) && !isset($_GET['userdel2']) && !isset($_GET['banddel']) && !isset($_GET['banddel2']) && !isset($_GET['health']) && !isset($_GET['health2']) && !isset($_GET['golod']) && !isset($_GET['golod2']) && !isset($_GET['bandname']) && !isset($_GET['bandname2']) && !isset($_GET['mer']) && !isset($_GET['mer2']) && !isset($_GET['rmer']) && !isset($_GET['rmer2']))

{



echo '<b>Мэр понель</b><br/>
<a href="?monet&amp;id='.$id.'&pass='.$pass.'">изменить кол. монет</a><br/>
<a href="?razban&amp;id='.$id.'&pass='.$pass.'">разбан</a><br/>
<a href="?level&amp;id='.$id.'&pass='.$pass.'">авторитет</a><br/>
<a href="?status&amp;id='.$id.'&pass='.$pass.'">изменение статуса</a><br/>
<a href="?health&amp;id='.$id.'&pass='.$pass.'">здоровье</a><br/>
<a href="?golod&amp;id='.$id.'&pass='.$pass.'">измененить сыстость</a><br/>

';

}



if(isset($_GET['monet']) && $zav == 1)
{


echo '<form method="POST" action="?monet2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Монеты:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['monet2']) && $zav == 1)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select id,login,pass,money from users where login='.$nick.';");

$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update users set money='".$moneta."' where login='".$nick."';");
	echo "Баланс успешно обновлён у $nick<br/>";
}

}


if(isset($_GET['level']) && $zav == 1)
{
echo '<form method="POST" action="?level2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Aвторитет:<br/>
<input type="text" name="moneta" maxlength="3"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['level2'])&& $zav == 1)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select id,login,pass,money from users where login='.$nick.';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update users set level='".$moneta."' where login='".$nick."';");
	echo "Баланс успешно обновлён у $nick<br/>";
}

}



if(isset($_GET['status']) && $zav == 1)
{
echo '<form method="POST" action="?status2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Статус:<br/>
<input type="text" name="moneta" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['status2'])&& $zav == 1)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select id,login,pass,money from users where login='.$nick.';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update users set status='".$moneta."' where login='".$nick."';");
	echo "статус успешно обновлён у $nick<br/>";
}

}








if(isset($_GET['razban']) && $zav == 1)
{
echo '<form method="POST" action="?razban2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="разбанить">
</FORM>';
}
if(isset($_GET['razban2']) && $zav == 1)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,ban from users where login='".$nick."';");

$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
$razbann="0";

	$data = mysql_fetch_array($q);
	mysql_query("update users set ban='".$razbann."' where login='".$nick."';");
	echo "Игрок успешно разбанен $nick<br/>".$data['ban']."";
}

}



if(isset($_GET['health']) && $zav == 1)
{
echo '<form method="POST" action="?health2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Здоровье:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['health2']) && $zav == 1)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select id,login,pass,money from users where login='.$nick.';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update users set health='".$moneta."' where login='".$nick."';");
	echo "здоровье успешно обновлено у $nick<br/>";
}

}



if(isset($_GET['golod']) && $zav == 1)
{
echo '<form method="POST" action="?golod2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Сытность:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['golod2']) && $zav == 1)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select id,login,pass,money from users where login='.$nick.';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update users set golod='".$moneta."' where login='".$nick."';");
	echo "сытность успешно обновлён у $nick<br/>";
}

}


print "<br/><a href=\"mer.php?id=$id&amp;pass=$pass\">Мэр панель</a>";
print "<br/><a href=\"./../game.php?id=$id&amp;pass=$pass\">Меню</a>";
mysql_close();

?>