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
$admin=$data['admin'];
if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");




if($admin != 7)
{
echo "ошибка,пароль не верный!";
}
elseif($admin == 7 &&  !isset($_GET['monet']) && !isset($_GET['monet2']) && !isset($_GET['status']) && !isset($_GET['status2']) && !isset($_GET['npass']) && !isset($_GET['npass2']) && !isset($_GET['newn']) && !isset($_GET['newn2']) && !isset($_GET['level']) && !isset($_GET['level2']) && !isset($_GET['userdel']) && !isset($_GET['userdel2']) && !isset($_GET['banddel']) && !isset($_GET['banddel2']) && !isset($_GET['health']) && !isset($_GET['health2']) && !isset($_GET['golod']) && !isset($_GET['golod2']) && !isset($_GET['bandname']) && !isset($_GET['bandname2']) && !isset($_GET['admina']) && !isset($_GET['admina2']) && !isset($_GET['radmina']) && !isset($_GET['radmina2']) && !isset($_GET['moder']) && !isset($_GET['moder2']) && !isset($_GET['rmoder']) && !isset($_GET['rmoder2']))

{



echo '<b>Админка</b><br/>
<a href="?monet&amp;id='.$id.'&pass='.$pass.'">изменить кол. монет</a><br/>
<a href="?zaban&amp;id='.$id.'&pass='.$pass.'">бан</a><br/><a href="?razban&amp;id='.$id.'&pass='.$pass.'">разбан</a><br/>
<a href="?level&amp;id='.$id.'&pass='.$pass.'">авторитет</a><br/>
<a href="?newn&amp;id='.$id.'&pass='.$pass.'">изменение ника</a><br/>
<a href="?npass&amp;id='.$id.'&pass='.$pass.'">изменение пароля</a><br/><a href="?status&amp;id='.$id.'&pass='.$pass.'">изменение статуса</a><br/>
<a href="?health&amp;id='.$id.'&pass='.$pass.'">здоровье</a><br/>
<a href="?bandname&amp;id='.$id.'&pass='.$pass.'">переименовать банду</a><br/>
<a href="?golod&amp;id='.$id.'&pass='.$pass.'">сыстность</a><br/>
<a href="?userdel&amp;id='.$id.'&pass='.$pass.'">удалить юзера</a><br/><a href="?banddel&amp;id='.$id.'&pass='.$pass.'">удалить банду</a><br/>
<a href="?admina&amp;id='.$id.'&pass='.$pass.'">Сделать Админом</a><br/>
<a href="?radmina&amp;id='.$id.'&pass='.$pass.'">Снять Админа</a><br/>
<a href="?moder&amp;id='.$id.'&pass='.$pass.'">Сделать Модератором</a><br/>
<a href="?rmoder&amp;id='.$id.'&pass='.$pass.'">Снять Модера</a><br/>
<a href="?mer&amp;id='.$id.'&pass='.$pass.'">Назначить Мэра</a><br/>
<a href="?rmer&amp;id='.$id.'&pass='.$pass.'">Снять Мера</a><br/>

';

}



if(isset($_GET['monet'])&& $admin == 7)
{


echo '<form method="POST" action="?monet2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Монеты:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['monet2'])&& $admin == 7)
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

if(isset($_GET['zaban'])&& $admin == 7)
{
echo '<form method="POST" action="?zaban2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="забанить">
</FORM>';
}
if(isset($_GET['zaban2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,ban from users where login='".$nick."';");
$bann="1";

	$data = mysql_fetch_array($q);
	mysql_query("update users set ban='".$bann."' where login='".$nick."';");
	echo "Игрок $nick успешно забанен <br/>";


}


if(isset($_GET['razban'])&& $admin == 7)
{
echo '<form method="POST" action="?razban2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="разбанить">
</FORM>';
}
if(isset($_GET['razban2'])&& $admin == 7)
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
	echo "Игрок $nick успешно разбанен <br/>";
}

}


if(isset($_GET['newn'])&& $admin == 7)
{
echo '<form method="POST" action="?newn2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Новый ник:<br/>
<input type="text" name="new" maxlength="3"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['newn2'])&& $admin == 7)
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


if(isset($_GET['level']) && $admin == 7)
{
echo '<form method="POST" action="?level2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Aвторитет:<br/>
<input type="text" name="moneta" maxlength="3"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['level2'])&& $admin == 7)
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




if(isset($_GET['status']) && $admin == 7)
{
echo '<form method="POST" action="?status2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Статус:<br/>
<input type="text" name="moneta" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['status2'])&& $admin == 7)
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

if(isset($_GET['health'])&& $admin == 7)
{
echo '<form method="POST" action="?health2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Здоровье:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['health2'])&& $admin == 7)
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

if(isset($_GET['npass'])&& $admin == 7)
{
echo '<form method="POST" action="?npass2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Новый пароль:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['npass2'])&& $admin == 7)
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
	mysql_query("update users set pass='".$moneta."' where login='".$nick."';");
	echo "пароль успешно обновлён у $nick<br/>";
}

}


if(isset($_GET['golod'])&& $admin == 7)
{
echo '<form method="POST" action="?golod2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Сытность:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['golod2'])&& $admin == 7)
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
if(isset($_GET['bandname'])&& $admin == 7)
{
echo '<form method="POST" action="?bandname2&amp;id='.$id.'&pass='.$pass.'">
Введите имя банды:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
Новое имя:<br/>
<input type="text" name="moneta" maxlength="10"/><br/>
<INPUT TYPE="submit" VALUE="изменить">
</FORM>';
}
if(isset($_GET['bandname2'])&& $admin == 7)
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


if(isset($_GET['userdel'])&& $admin == 7)
{
echo '<form method="POST" action="?userdel2&amp;id='.$id.'&pass='.$pass.'">
Введите ник<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="удалить">
</FORM>';
}
if(isset($_GET['userdel2'])&& $admin == 7)
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
	mysql_query("delete from users where login='".$nick."';");
	echo " $nick удалено<br/>";
}

}

if(isset($_GET['banddel'])&& $admin == 7)
{
echo '<form method="POST" action="?banddel2&amp;id='.$id.'&pass='.$pass.'">
Введите банду<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="удалить">
</FORM>';
}
if(isset($_GET['banddel2'])&& $admin == 7)
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
if(isset($_GET['admina'])&& $admin == 7)
{
echo '<form method="POST" action="?admina2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="Назначить админом">
</FORM>';
}
if(isset($_GET['admina2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,admin from users where login='".$nick."';");
$admina="7";

	$data = mysql_fetch_array($q);
	mysql_query("update users set admin='".$admina."' where login='".$nick."';");
	echo "Игрок $nick успешно назначен админом<br/>
	";


}
if(isset($_GET['radmina'])&& $admin == 7)
{
echo '<form method="POST" action="?radmina2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="Снять админа">
</FORM>';
}
if(isset($_GET['radmina2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,admin from users where login='".$nick."';");
$admina="0";

	$data = mysql_fetch_array($q);
	mysql_query("update users set admin='".$admina."' where login='".$nick."';");
	echo "Игрок  $nick больше не админ<br/>
	";


}
if(isset($_GET['moder'])&& $admin == 7)
{
echo '<form method="POST" action="?moder2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="Назначить модером">
</FORM>';
}
if(isset($_GET['moder2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,admin from users where login='".$nick."';");
$moder="6";

	$data = mysql_fetch_array($q);
	mysql_query("update users set admin='".$moder."' where login='".$nick."';");
	echo "Игрок $nick успешно назначен модератором<br/>
	";


}
if(isset($_GET['rmoder'])&& $admin == 7)
{
echo '<form method="POST" action="?rmoder2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="Снять модера">
</FORM>';
}
if(isset($_GET['rmoder2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,admin from users where login='".$nick."';");
$moder="0";

	$data = mysql_fetch_array($q);
	mysql_query("update users set admin='".$moder."' where login='".$nick."';");
	echo "Игрок  $nick больше не модератор<br/>
	";


}
if(isset($_GET['mer'])&& $admin == 7)
{
echo '<form method="POST" action="?mer2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="забанить">
</FORM>';
}
if(isset($_GET['mer2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,zav from users where login='".$nick."';");
$zavv="1";

	$data = mysql_fetch_array($q);
	mysql_query("update users set zav='".$zavv."' where login='".$nick."';");
	echo "Игрок $nick стал мэром <br/>";


}


if(isset($_GET['rmer'])&& $admin == 7)
{
echo '<form method="POST" action="?rmer2&amp;id='.$id.'&pass='.$pass.'">
Введите ник игрока:<br/>
<input type="text" name="nick" maxlength="20"/><br/>
<INPUT TYPE="submit" VALUE="разбанить">
</FORM>';
}
if(isset($_GET['rmer2'])&& $admin == 7)
{
	$nick=cyr(htmlspecialchars(stripslashes(trim($_POST['nick']))));
$q = mysql_query("select id,login,pass,ban from users where login='".$nick."';");

$count=mysql_num_rows($q);
if($count=0)
{
	echo "Извините, но такого логина нет.";
}
else {
$zavv="0";

	$data = mysql_fetch_array($q);
	mysql_query("update users set zav='".$zavv."' where login='".$nick."';");
	echo "Игрок $nick Больше не мэр <br/>";
}

}
print "<br/><a href=\"./../news/admin/news.php?id=$id&amp;pass=$pass\">Редактировать Новости</a>";
print "<br/><a href=\"./../news/admin/add.php?id=$id&amp;pass=$pass\">Добавить Новость</a>";
print "<br/><a href=\"./../gb/admin/news.php?id=$id&amp;pass=$pass\">Гостевая</a>";
print "<br/><a href=\"./../golos/Admin/index.php?id=$id&amp;pass=$pass\">Мэрия</a>";
print "<br/><a href=\"admina.php?id=$id&amp;pass=$pass\">Админка</a>";
print "<br/><a href=\"./../game.php?id=$id&amp;pass=$pass\">Меню</a>";
mysql_close();

?>