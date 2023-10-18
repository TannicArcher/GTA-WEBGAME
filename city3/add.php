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
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd,redaktor from users where login='".cyr($login)."';");
}
elseif(!empty($id))
{
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd,redaktor from users where id='".$id."';");
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
$redaktor=$data['redaktor'];
if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");




if($redaktor == 0)
{
echo "Ты не редактор!";
}
elseif($redaktor >= 1  && !isset($_GET['newn']) && !isset($_GET['newn2']))

{



echo '<b>Новости</b><br/>
<a href="?newn&amp;id='.$id.'&pass='.$pass.'">Добавить новость</a><br/>
';

}






if(isset($_GET['newn'])&& $redaktor >= 1)
{
echo '<form method="POST" action="?newn2&amp;id='.$id.'&pass='.$pass.'">
Введите тему:<br/>
<input type="text" name="title" maxlength="20"/><br/>
Сообщение:<br/>
<input type="text" name="text" maxlength="300"/><br/>
<INPUT TYPE="submit" VALUE="отправить">
</FORM>';
}
if(isset($_GET['newn2'])&& $redaktor >= 1)
{  $data = mysql_fetch_array($q);


$title=$title;
$text=$text;
$login=$login;
	$time=date("y.m.d H:i");
	$data = mysql_fetch_array($q);
	mysql_query("insert into rnews values('0','$title','$text','$login','$time');");
$count=mysql_num_rows($q);
echo "Новость добавлена!<br/>";
echo "<a href=\"index.php?id=$id&pass=$pass\">В город</a>";
if($count=0)
{
	echo "Ошибка какая-то.";
}


}


mysql_close();

?>