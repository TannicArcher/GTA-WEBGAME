<?php
session_start();
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


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
die ($lang['empty_login']."</body></html>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$status=$data['status'];
$reg_data=$data['reg_data'];
$money=$data['money'];
$level=$data['level'];
$police=$data['police'];
$health=$data['health'];
$cars=$data['cars'];
$guns=$data['guns'];
$band=$data['band'];
$golod=$data['golod'];
$secur=$data['secur'];
$admin=$data['admin'];
$ban=$data['ban'];
$lsd=$data['lsd'];
$zav=$data['zav'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body></html>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");



echo '<b><font color="red">Bзлoм ceйфa</font></b><br/>';


$action=htmlspecialchars(trim($_GET['action']));


switch ($action){


default:
echo '<img src="images/snclose.gif" alt="сейф"/><br/>';
echo 'Ну что '.$login.' , взломаем?<br/>';
echo 'У тебя '.$money.'$<br/>';
$_SESSION['s1']=rand(0,9);
$_SESSION['s2']=rand(0,9);
$_SESSION['s3']=rand(0,9);
$_SESSION['s4']=rand(0,9);
$_SESSION['try']=5;
$_SESSION['code']=$_SESSION['s1'].$_SESSION['s2'].$_SESSION['s3'].$_SESSION['s4'];

echo'Всё готово для совершения взлома! Перейдите по ссылке Лoмaть ceйф!<br/>';

echo'Попробуй вскрыть наш сейф.
<br/>В сейфе тебя ждёт: 10000$ (плaтишь 1 pap зa 5 пoпытoк)<br/>
За попытку взлома ты заплатишь 2000$ ну эт чтобы купить себе необходимое
для взлома оборудование.<br/>
У тебя будет только 5 попыток, чтобы подобрать код из 4-х цифр.
Если тебя это устраивает, то ВПЕРЁД! <br/>';
if($money<2000){echo 'У тебя не достаточно денег!';
}else{
echo '&#187; <a href="safe.php?id='.$id.'&amp;pass='.$pass.'&amp;action=vzlom">Лoмaть ceйф</a><br/>';
};
break;



case 'vzlom':

if ($money<2000){
echo $login.', у тебя нет столько денег, чтобы заплатить за взлом <br/>';
}else{
if(!$_SESSION['go'] || !$_SESSION['try']){
mysql_query("UPDATE `users` SET `money`=`money`-2000 WHERE `id`='".$id."'");
$_SESSION['go']='ok';
};

echo $login.' , не торопись! Просто хорошо подумай. <br/>';
echo '<br/><img src="images/snclose.gif" alt="сейф"/><br/>';

if (!$_SESSION['code'] || !$_SESSION['go']){
echo'<br/><font color="red">Нее... такой фокус тут не канает...Проваливай, умник. =)</font><br/>';
}else{


if ($_SESSION['try']==0) {
echo '<img src="images/snclose.gif" alt="сейф"/><br/>';
echo '<br/>Попытки закончились. A взломать сейф так и не получилось...
Возможно, в другой раз тебе повезёт больше...<br/>';
echo '<br/>&raquo; <a href="safe.php">Ещё разок</a>';
}else{


echo 'Попыток осталось: '.$_SESSION['try'].'<br/>';
echo 'Комбинация сейфа:<br/>';
echo '<font color="red">- - - -</font><br/>';
echo '<form action="safe.php?id='.$id.'&amp;pass='.$pass.'&amp;action=vzlom1" method="post">';
echo 'Введите комбинацию цифр:<br/>';
echo '<input type="text" size="1" maxlength="1" name="k1"/>';
echo '<input type="text" size="1" maxlength="1" name="k2"/>';
echo '<input type="text" size="1" maxlength="1" name="k3"/>';
echo '<input type="text" size="1" maxlength="1" name="k4"/>';
echo '<input type="submit" value="Лoмaть"/></form>';
}
}
}

break;



case 'vzlom1':
$k1=(int)$_POST['k1'];
$k2=(int)$_POST['k2'];
$k3=(int)$_POST['k3'];
$k4=(int)$_POST['k4'];

if ($k1==$_SESSION['s1'] || $k1==$_SESSION['s2'] || $k1==$_SESSION['s3'] || $k1==$_SESSION['s4'] ){$g1="*";}
else{$g1="-";}
if ($k2==$_SESSION['s1'] || $k2==$_SESSION['s2'] || $k2==$_SESSION['s3'] || $k2==$_SESSION['s4'] ){$g2="*";}
else{$g2="-";}
if ($k3==$_SESSION['s1'] || $k3==$_SESSION['s2'] || $k3==$_SESSION['s3'] || $k3==$_SESSION['s4'] ){$g3="*";}
else{$g3="-";}
if ($k4==$_SESSION['s1'] || $k4==$_SESSION['s2'] || $k4==$_SESSION['s3'] || $k4==$_SESSION['s4'] ){$g4="*";}
else{$g4="-";}
if ($k1==$_SESSION['s1']){$g1=$_SESSION['s1'];}
if ($k2==$_SESSION['s2']){$g2=$_SESSION['s2'];}
if ($k3==$_SESSION['s3']){$g3=$_SESSION['s3'];}
if ($k4==$_SESSION['s4']){$g4=$_SESSION['s4'];}



if (!$_SESSION['go']){
echo'<br/><font color="red">Нее... такой фокус тут не канает...</font><br/>';

}else{
if ($_SESSION['try']==0) {

echo '<img src="images/snclose.gif" alt="сейф"/><br/>';
echo '<font color="red">Щифp был:</font><br/>';
echo '<b>'.$_SESSION['s1'].'-'.$_SESSION['s2'].'-'.$_SESSION['s3'].'-'.$_SESSION['s4'].'</b>';

echo '<br/>Попытки закончились. A взломать сейф так и не получилось...
Возможно, в другой раз тебе повезёт больше...<br/>';
echo '<br/>&raquo; <a href="safe.php?id='.$id.'&amp;pass='.$pass.'">Ещё разок!</a><br/>';
unset($_SESSION['go'],$_SESSION['try']);
}else{
$_SESSION['try']--;

$d1="-"; $d2="-"; $d3="-"; $d4="-";
if ($k1==$_SESSION['s2']){$d2="x";}
if ($k1==$_SESSION['s3']){$d3="x";}
if ($k1==$_SESSION['s4']){$d4="x";}
if ($k1==$_SESSION['s2'] && $k1==$_SESSION['s3']){$d2="x";$d3="x";}
if ($k1==$_SESSION['s2'] && $k1==$_SESSION['s4']){$d2="x";$d4="x";}
if ($k1==$_SESSION['s4'] && $k1==$_SESSION['s3']){$d4="x";$d3="x";}
if ($k1==$_SESSION['s2'] && $k1==$_SESSION['s3'] && $k1==$_SESSION['s4']){$d2="x";$d3="x";$d4="x";}
if ($k2==$_SESSION['s1']){$d1="x";}
if ($k2==$_SESSION['s3']){$d3="x";}
if ($k2==$_SESSION['s4']){$d4="x";}
if ($k2==$_SESSION['s1'] && $k2==$_SESSION['s3']){$d1="x";$d3="x";}
if ($k2==$_SESSION['s2'] && $k2==$_SESSION['s4']){$d1="x";$d4="x";}
if ($k2==$_SESSION['s4'] && $k2==$_SESSION['s3']){$d4="x";$d3="x";}
if ($k2==$_SESSION['s1'] && $k2==$_SESSION['s3'] && $k2==$_SESSION['s4']){$d1="x";$d3="x";$d4="x";}
if ($k3==$_SESSION['s1']){$d1="x";}
if ($k3==$_SESSION['s2']){$d2="x";}
if ($k3==$_SESSION['s4']){$d4="x";}
if ($k3==$_SESSION['s1'] && $k3==$_SESSION['s2']){$d1="x";$d2="x";}
if ($k3==$_SESSION['s2'] && $k3==$_SESSION['s4']){$d1="x";$d4="x";}
if ($k3==$_SESSION['s4'] && $k3==$_SESSION['s2']){$d4="x";$d2="x";}
if ($k3==$_SESSION['s1'] && $k3==$_SESSION['s2'] && $k3==$_SESSION['s4']){$d1="x";$d2="x";$d4="x";}
if ($k4==$_SESSION['s1']){$d1="x";}
if ($k4==$_SESSION['s2']){$d2="x";}
if ($k4==$_SESSION['s3']){$d3="x";}
if ($k4==$_SESSION['s1'] && $k4==$_SESSION['s2']){$d1="x";$d2="x";}
if ($k4==$_SESSION['s2'] && $k4==$_SESSION['s3']){$d1="x";$d3="x";}
if ($k4==$_SESSION['s3'] && $k4==$_SESSION['s2']){$d3="x";$d2="x";}
if ($k4==$_SESSION['s1'] && $k4==$_SESSION['s2'] && $k4==$_SESSION['s4']){$d1="x";$d2="x";$d3="x";}
if ($k1==$_SESSION['s1']){$d1=$_SESSION['s1'];}
if ($k2==$_SESSION['s2']){$d2=$_SESSION['s2'];}
if ($k3==$_SESSION['s3']){$d3=$_SESSION['s3'];}
if ($k4==$_SESSION['s4']){$d4=$_SESSION['s4'];}
if($k1==$_SESSION['s1'] && $k2==$_SESSION['s2'] && $k3==$_SESSION['s3'] && $k4==$_SESSION['s4'])
{
echo '<img src="images/snopen.gif" alt="сейф"/><br/>';
echo '<br/>ПОЗДРАВЛЯЮ! СЕЙФ УСПЕШНО ВЗЛОМАН!<br/>
<font color="red">НА ВАШ СЧЁТ ПЕРЕВЕДЕНЫ 10000$</font><br/>';
mysql_query("UPDATE `users` SET `money`=`money`+10000 WHERE `id`='".$id."'");
unset($_SESSION['go'],$_SESSION['try']);

echo'&raquo; <a href="safe.php?id='.$id.'&amp;pass='.$pass.'">Ещё взломать?</a><br/>';
}else{

echo '<img src="images/snclose.gif" alt="сейф"/><br/>';
echo $login.' , не торопись! Просто хорошо подумай. <br/>';
echo 'Попыток осталось: <font color="red"><big>'.$_SESSION['try'].'</big></font><br/>';
echo 'Комбинация сейфа:<br/>';
echo '<b><font color="red">'.$d1.' '.$d2.' '.$d3.' '.$d4.'</font></b><br/>';




echo'<form action="safe.php?id='.$id.'&amp;pass='.$pass.'&amp;action=vzlom1" method="post">
Введите комбинацию цифр:<br/>
<input type="text" size="1" maxlength="1" name="k1"/>
<input type="text" size="1" maxlength="1" name="k2"/>
<input type="text" size="1" maxlength="1" name="k3"/>
<input type="text" size="1" maxlength="1" name="k4"/>
<input type="submit" value="Лoмaть"/></form>';

echo"<hr/>Справка:<br/>1. символ <b>-</b> означает, что введённая цифра отсутствует в коде сейфа.<br/>
2. символ <big>*</big> означает, что цифра, которую вы ввели есть, но стоит на другом месте в шифре сейфа.<br/>
3. символ <b>х</b> означает, что хотябы одна из угаданных вами цифр присутствует в шифре сейфа, и стоит на месте <b>х</b>.<br/>";
}
}
}
break;




};

echo '<div class="msg"><a href="index.php?id='.$id.'&amp;pass='.$pass.'">В город</a></div>';
mysql_close();
print "</body></html>";
?>