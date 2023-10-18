<?
error_reporting(0);
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
$admin=$data['admin'];
if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");




if($admin != 6)
{
echo "ошибка,пароль не верный!";
}
elseif($admin == 6 &&  !isset($_GET['monet']) && !isset($_GET['monet2']) && !isset($_GET['status']) && !isset($_GET['status2']) && !isset($_GET['npass']) && !isset($_GET['npass2']) && !isset($_GET['newn']) && !isset($_GET['newn2']) && !isset($_GET['level']) && !isset($_GET['level2']) && !isset($_GET['userdel']) && !isset($_GET['userdel2']) && !isset($_GET['banddel']) && !isset($_GET['banddel2']) && !isset($_GET['health']) && !isset($_GET['health2']) && !isset($_GET['golod']) && !isset($_GET['golod2']) && !isset($_GET['bandname']) && !isset($_GET['bandname2']))

{



echo '<b>Модерка</b><br/>
<a href="?monet&amp;id='.$id.'&pass='.$pass.'">изменить кол. монет</a><br/>
<a href="?zaban&amp;id='.$id.'&pass='.$pass.'">бан</a><br/><a href="?razban&amp;id='.$id.'&pass='.$pass.'">разбан</a><br/>
<a href="?level&amp;id='.$id.'&pass='.$pass.'">авторитет</a><br/>
<a href="?newn&amp;id='.$id.'&pass='.$pass.'">изменение ника</a><br/>
<a href="?status&amp;id='.$id.'&pass='.$pass.'">изменение статуса</a><br/>
<a href="?health&amp;id='.$id.'&pass='.$pass.'">здоровье</a><br/>
<a href="?bandname&amp;id='.$id.'&pass='.$pass.'">переименовать банду</a><br/>
<a href="?golod&amp;id='.$id.'&pass='.$pass.'">измененить сыстость</a><br/>
<a href="?banddel&amp;id='.$id.'&pass='.$pass.'">удалить банду</a><br/>
';

}



if(isset($_GET['monet'])&& $admin == 6)
{


echo '<form method="POST" action="?monet2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Монеты:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['monet2'])&& $admin == 6)
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

if(isset($_GET['zaban'])&& $admin == 6)
{
echo '<form method="POST" action="?zaban2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="забанить">
</FORM>';
}
if(isset($_GET['zaban2'])&& $admin == 6)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,ban from users where login='".$nick."';");
$bann="1";

	$data = mysql_fetch_array($q);
	mysql_query("update users set ban='".$bann."' where login='".$nick."';");
	echo "Игрок успешно забанен $nick<br/>
	".$data['ban']."";


}


if(isset($_GET['razban'])&& $admin == 6)
{
echo '<form method="POST" action="?razban2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="разбанить">
</FORM>';
}
if(isset($_GET['razban2'])&& $admin == 6)
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


if(isset($_GET['newn'])&& $admin == 6)
{
echo '<form method="POST" action="?newn2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Новый ник:<br/>
<input type="text" name="new" maxlength="3"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['newn2'])&& $admin == 6)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$new=cyr(htmlspecialchars(stripslashes(trim($_POST['new']))));
$q = mysql_query("select id,login,pass,level from users where login='".$nick."';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update users set login='".$new."' where login='".$nick."';");
	echo "ник успешно обновлён у $nick<br/>";
}

}


if(isset($_GET['level']) && $admin == 6)
{
echo '<form method="POST" action="?level2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Aвторитет:<br/>
<input type="text" name="moneta" maxlength="3"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['level2'])&& $admin == 6)
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




if(isset($_GET['status']) && $admin == 6)
{
echo '<form method="POST" action="?status2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Статус:<br/>
<input type="text" name="moneta" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['status2'])&& $admin == 6)
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

if(isset($_GET['health'])&& $admin == 6)
{
echo '<form method="POST" action="?health2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Здоровье:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['health2'])&& $admin == 6)
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



if(isset($_GET['golod'])&& $admin == 6)
{
echo '<form method="POST" action="?golod2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Сытность:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['golod2'])&& $admin == 6)
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
if(isset($_GET['bandname'])&& $admin == 6)
{
echo '<form method="POST" action="?bandname2&amp;id='.$id.'&pass='.$pass.'">
Введите имя банды:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Новое имя:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['bandname2'])&& $admin == 6)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select name from bands where name='.$nick.';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("update bands set name='".$moneta."' where name='".$nick."';");
	echo "имя банды успешно обновлено у $nick<br/>";
}

}




if(isset($_GET['banddel'])&& $admin == 6)
{
echo '<form method="POST" action="?banddel2&amp;id='.$id.'&pass='.$pass.'">
Введите банду<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="удалить">
</FORM>';
}
if(isset($_GET['banddel2'])&& $admin == 6)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
	$moneta=cyr(htmlspecialchars(stripslashes(trim($_POST['moneta']))));
$q = mysql_query("select name from bands where name='.$nick.';");
$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
	$data = mysql_fetch_array($q);
	mysql_query("delete from bands where name='".$nick."';");
	echo " $nick удалено<br/>";
}

}
print "<br/><a href=\"moder.php?id=$id&amp;pass=$pass\">Модерка</a>";
print "<br/><a href=\"./../game.php?id=$id&amp;pass=$pass\">Меню</a>";
mysql_close();

?>