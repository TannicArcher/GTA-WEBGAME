<?php
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


$gconf=mysql_fetch_array(mysql_query("SELECT * FROM `gorod_conf`"));



echo'<font color="red">Рейтинг фирм</font><br/>';

$k_post=mysql_result(mysql_query("SELECT count(*) FROM `gorod_firm`"),0);
if($k_post==0){echo 'Нет фирм!';}else{

echo 'Всего: <b>'.$k_post.'</b> фирм!<br/>';

$x=mysql_query("SELECT * FROM `gorod_firm` ORDER BY `balans` DESC LIMIT $start, $onpage");


while($row=mysql_fetch_assoc($x)){
echo '<hr/>Название: <b>'.$row['name'].'</b><br/>';
echo 'Описание: <b>'.$row['opis'].'</b><br/>';
echo 'Директор: <b>'.$row['login'].'</b><br/>';
echo 'Баланс: <b>'.$row['balans'].'</b><br/>';
echo 'Дата создания: <b>'.date("H:i:s, d-m-Y",$row['date']).'</b><br/>';
};

};



echo '<div class="msg"><a href="index.php">В город</a></div>';
mysql_close();
print "</body></html>";
?>