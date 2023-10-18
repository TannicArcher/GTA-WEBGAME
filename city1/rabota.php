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

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");



echo '<b><font color="red">Работа</font></b><br/>';

if(!$_SESSION['go']){
$_SESSION['do']=1;
$_SESSION['time']=time();
$_SESSION['go']='ok';
};

if($_SESSION['do']==30){
mysql_query("UPDATE `users` SET `money`=`money`+2000 WHERE `id`='".$id."'");
$_SESSION['do']=1;
$_SESSION['time']=time();
$_SESSION['go']='ok';
echo '<font color="red">Выплачено 2000$</font><br/>';
};

if(($_SESSION['time']+60)<time()){
$_SESSION['do']++;
$_SESSION['time']=time();
$_SESSION['go']='ok';
};

echo 'Вы попали на шахту. <br/>';
echo 'У вас сейчас '.$money.' $. <br/>';
echo '<font color="blue">Смысл таков:</font><br/>';
echo 'Нажимая определенное время <a href="rabota.php?id='.$id.'&amp;pass='.$pass.'">';
echo '<font color="red">Работать</font></a> по <font color="blue">1</font> разу в минуту<br/>';
echo 'Вы получите <font color="red">2000</font> монет<br/>';
echo 'Продолжительность работ <font color="blue">30</font> минут<br/>';
echo '<a href="rabota.php?id='.$id.'&amp;pass='.$pass.'">';
echo '<font color="red">Работать</font></a><br/> ';
echo 'Вы отработали (<font color="blue">'.$_SESSION['do'].'</font>) минут<br/>';










echo '<div class="msg"><a href="index.php?id='.$id.'&amp;pass='.$pass.'">В город</a></div>';
mysql_close();
print "</body></html>";
?>