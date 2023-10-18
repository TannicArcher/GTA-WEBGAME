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




echo '<b><font color="red">Тараканьи бега</font></b><br/>';


$action=htmlspecialchars(trim($_GET['action']));


switch ($action){


default:
$x=mysql_query("SELECT * FROM `gorod_tbega` WHERE `last`=''");
$c=mysql_fetch_assoc($x);
if(mysql_num_rows($x)>=5){
$win=mt_rand(1,6);
$who=mysql_query("SELECT * FROM `gorod_tbega` WHERE `bet`='$win'");
while($row=mysql_fetch_assoc($who)){
mysql_query("UPDATE `users` SET `money`=`money`+5000 WHERE `login`='".$row['name']."'");
};
mysql_query("DELETE FROM `gorod_tbega`");
mysql_query("INSERT INTO `gorod_tbega` (`last`)VALUES('$win')");
};
echo'<b>Время: '.date("H:i:s").'</b><br/>';
echo'Ты состоятельный человек с приличными деньгами? <br/>';
echo 'Участвуй в тараканьих бегах! <br/> Выигрывай лёгкие деньги! <br/>';
echo 'Крупные ставки по 1000!<br/><br/>';
echo 'НАШИ ТАРАКАНЫ:<br/>';
echo '1.Бешеный Джо<br/>';
echo '2.Стрелка<br/>';
echo '3.Белка<br/>';
echo '4.Крэзи Пайп<br/>';
echo '5.Жирный тони<br/>';
echo '6.Шмыга-бегун<br/>';
$n=mysql_query("SELECT * FROM `gorod_tbega` WHERE `last`!=''");
$n=mysql_fetch_assoc($n);

echo'<font color="red">В предыдущих гонках победил таракан: №'.$n['last'].'</font><br/>';
echo 'Текущее количество ставок :<font color="gold"> '.mysql_num_rows($x).'</font><br/>';
echo 'Бега начнутся когда будет 5 ставок!<br/>';
echo'<br/>Введите номер таракана от 1 до 6 включительно';
echo '<br/><form action="bega.php?id='.$id.'&amp;pass='.$pass.'&amp;action=bilet" method="post">';
echo '<input name="bilet"/><br/>';
echo '<input type="submit" value="Ставить!!!"/>';
echo '</form>';
echo'Ставка равна 1000 монет<br/>';
echo'У вас в наличии монет: '.$money.'<br/>';
break;


case 'bilet':
if($money>1000){
$x=mysql_query("SELECT * FROM `gorod_tbega` WHERE `name`='".$login."'");
if(!mysql_num_rows($x)){
$bet=(int)$_POST['bilet'];
if(!$bet || $bet>6 || $bet<0){echo 'Не правильная ставка!';break;};
mysql_query("INSERT INTO `gorod_tbega` (`name`,`bet`)VALUES('".$login."','$bet')");
mysql_query("UPDATE `users` SET `money`=`money`-1000 WHERE `id`='".$id."'");
echo'<b>Ставки сделаны! Бега состоятся при наличии пяти ставок!</b><br/>';
echo'Результат розыгрыша станет известным после того, как ставки сделают 5 участников!<br/>';
echo'<br/>У вас в наличии монет: '.$money.'<br/>';
}else{
echo'Вы уже сделали ставку! Нельзя ставить дважды, это противоречит правилам
тараканьих бегов!<br/>';};
}else{
echo'Вы не можете играть на тараканьих бегах т.к. на
вашем счете недостаточно денег!<br/>';
};
echo '<br/><a href="bega.php?id='.$id.'&amp;pass='.$pass.'">Вернуться к бегам</a>';

break;







};
echo '<div class="msg"><a href="index.php?id='.$id.'&amp;pass='.$pass.'">В город</a></div>';


mysql_close();
print "</body></html>";
?>