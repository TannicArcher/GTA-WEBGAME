<?php


function maketime($string) {
if($string < 3600){
$string = sprintf("%02d:%02d", (int)($string / 60) % 60, $string % 60);
}else{
$string = sprintf("%02d:%02d:%02d", (int)($string / 3600) % 24, (int)($string / 60) % 60, $string % 60);
};
return $string;
};
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$login=cyr(htmlspecialchars(stripslashes(trim($login))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($login)) 
{  
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd,gorod_firm from users where login='".cyr($login)."';");
}
elseif(!empty($id)) 
{
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd,gorod_firm from users where id='".$id."';");
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
$gorod_firm=$data['gorod_firm'];


if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body></html>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

$gconf=mysql_fetch_array(mysql_query("SELECT * FROM `gorod_conf`"));




echo '<img src="images/firm.gif" alt=""/><b><font color="red">МЕНЮ ФИРМЫ</font></b><br/>';


$action=htmlspecialchars(trim($_GET['action']));


switch ($action){






default:
$x=mysql_query("SELECT * FROM `gorod_firm` WHERE `login`='".$login."' LIMIT 1");
if(!mysql_num_rows($x)){echo 'У вас нет фирмы! <a href="firma.php?id='.$id.'&amp;pass='.$pass.'&amp;action=reg">Зарегистрировать фирму!</a>';break;};
$x=mysql_fetch_assoc($x);

if($x['update']<time()){
mysql_query("UPDATE `gorod_firm` SET `pritok`=`pritok`+'".$x['dohod']."',`update`='".(time()+80000)."' WHERE `login`='".$login."'");
};

echo 'Название: <font color="red">'.$x['name'].'</font><br/>';
echo 'Информация о фирме: <font color="red">'.$x['opis'].'</font><br/>';
echo 'Дата регистрации:<font color="red"> '.date("H:i:s, d-m-Y",$x['date']).'</font><br/>';
if ($x['balans']!=0) {
echo"Баланс фирмы: ".$x['balans']."<br/>";
}else{
echo '<font color="red">Фирма не приносит доход!</font><br/>';
};

if($x['pritok']!=0){
echo 'На счету: '.$x['pritok'].'<br/>';
};

if ($x['dohod']!=0) {
echo 'Приносит доход: '.$x['dohod'].'<br/>';
}else{
echo '<font color="red">Нет доходов!<br/></font>';
};

if (time()>=$x['lasttake'] && $x['pritok']!=0){
echo '<a href="firma.php?id='.$id.'&amp;pass='.$pass.'&amp;action=dengi">Забрать выручку</a><br/>';
}else{
if($x['pritok']!=0){
echo 'Сможешь забрать выручку через <font color="red">'.maketime($x['lasttake']-time()).'</font><br/>';
}
}

echo 'В кармане: <font color="red">'.$money.'$</font>';
echo '<form action="firma.php?id='.$id.'&amp;pass='.$pass.'&amp;action=balans" method="post">';
echo 'Bвeди cyммy:<br/>';
echo '<input title="Bвeди cyммy:" size="20" maxlength="30" name="dol"/><br/>';
echo '<select name="oper">';
echo '<option value="1">Пoлoжить</option>';
echo '<option value="2">Bзять</option>';
echo '</select><br/>';
echo '<input type="submit" value="OK"/></form>';

echo '<a href="firma.php?id='.$id.'&amp;pass='.$pass.'&amp;action=faq">Справка</a><br/>';

if($x['balans']>=50000 && $x['birga']!='yes'){
echo'<a href="firma.php?id='.$id.'&amp;pass='.$pass.'&amp;action=emis">Выпустить акции</a><br/>';
}
break;


case 'reg':
if(!empty($gorod_firm)){echo 'У вас уже есть фирма!';break;};
echo '<form action="firma.php?id='.$id.'&amp;pass='.$pass.'&amp;action=save" method="post">';
echo 'Название фирмы:<br/>';
echo '<input name="name" type="text" value=""/><br/>';
echo 'Описание фирмы:<br/>';
echo '<textarea name="opis"></textarea><br/>';
echo '<input type="submit" value="Регистрировать"/>';
echo '</form>';
break;


case 'save':
if(!empty($gorod_firm)){echo 'У вас уже есть фирма!';break;};
$name=htmlspecialchars(mysql_real_escape_string(trim($_POST['name'])));
$opis=htmlspecialchars(mysql_real_escape_string(trim($_POST['opis'])));
if(!$name || !$opis){echo 'Пустые параметры!';break;};
mysql_query("INSERT INTO `gorod_firm` (`name`,`opis`,`login`,`date`)VALUES('$name','$opis','".$login."','".time()."')");
mysql_query("UPDATE `users` SET `gorod_firm`='$name' WHERE `id`='".$id."'");
echo 'Фирма создана!<br/>';
echo '<a href="firma.php?id='.$id.'&amp;pass='.$pass.'">К фирмам</a>';
break;


case 'faq':
echo'Памятка коммерса:<br/>
Фирма нужна для того, чтобы она приносила постоянный доход.
Фирма будет работать только при условии, что хозяин фирмы будет вкладывать
средства в свою фирму.
Если расход фирмы больше, чем доход, то
такая фирма становится убыточной и не приносит прибыли.
Это вас ожидает на начальном этапе, при открытии фирмы. Ваше ЧП не будет
приносить доход, пока на балансе не будет достаточно средств.
Выручку фирмы вы можете забирать каждый день.
Если вас устраивает доход, который приносит фирма, то
можно перестать ложить деньги на счёт фирмы и она перейдёт на
самобаланс, а вы будете просто каждый день забирать доход с кассы.
В случае пополнения баланса фирмы-доход постоянно меняется!
и чем больше вы вкладываете в фирму,-тем больше будет сумма дохода.
Для раскрутки фирмы нужно более 10000. Если вы не располагаете этими
деньгами, то можете постепенно вкладывать их в свою фирму. Успехов в
частном бизнесе! С н.п. Admin<br/>p.s. При достижении определенного
баланса ваши акции могут играть на бирже';
echo'<br/><a href="firma.php?id='.$id.'&amp;pass='.$pass.'">Назад</a>';
break;


case 'balans':
if(!$gorod_firm){echo 'У вас нет фирмы!';break;};
$dol=(int)$_POST['dol'];
$oper=(int)$_POST['oper'];
if(!$dol || $dol<0 || !$oper || $oper<1 || $oper>2){echo 'Пустые параметры!';break;};

$x=mysql_query("SELECT * FROM `gorod_firm` WHERE `name`='".$gorod_firm."' AND `login`='".$login."'");
if(!mysql_num_rows($x)){echo 'Ошибка';break;};
$x=mysql_fetch_assoc($x);

if ($oper=="1"){
if ($money>$dol){
mysql_query("UPDATE `users` SET `money`=`money`-'$dol' WHERE `id`='".$id."'");

$newbalans=$x['balans']+$dol;
$c=round($newbalans/2);
$pribil=rand(10,$newbalans-$с);
if ($pribil<0){$pribil=0;}
mysql_query("UPDATE `gorod_firm` SET `balans`='$newbalans',`dohod`='$pribil' WHERE `name`='".$gorod_firm."' AND `login`='".$login."'");

echo 'Деньги положены!<br/><a href="firma.php?id='.$id.'&amp;pass='.$pass.'">Назад</a>';
}else{
echo'У вас нет столько денег!<br/><a href="firma.php?id='.$id.'&amp;pass='.$pass.'">Назад</a>';};
};


if ($oper=="2"){
if ($x['balans']>$dol){
mysql_query("UPDATE `users` SET `money`=`money`+'$dol' WHERE `id`='".$id."'");
$newbalans=$x['balans']-$dol;
$c=round($newbalans/2);
$pribil=rand(10,$newbalans-$с);
if ($pribil<0){$pribil=0;}
mysql_query("UPDATE `gorod_firm` SET `balans`='$newbalans',`dohod`='$pribil',`lasttake`='".(time()+80000)."' WHERE `name`='".$gorod_firm."' AND `login`='".$login."'");

echo 'Вы забрали деньги!<br/><a href="firma.php?id='.$id.'&amp;pass='.$pass.'">Назад</a>';
}else{
echo'Ваша фирма ненастолько богата, как вам хотелось бы!<br/>
<a href="firma.php?id='.$id.'&amp;pass='.$pass.'">Назад</a>';};
};
break;




case 'emis':
if(!$gorod_firm){echo 'У вас нет фирмы!';break;};
$x=mysql_query("SELECT * FROM `gorod_firm` WHERE `name`='".$gorod_firm."' AND `login`='".$login."'");
if(!mysql_num_rows($x)){echo 'Ошибка';break;};
$x=mysql_fetch_assoc($x);
if($x['birga']=='yes'){echo 'Ваши акции уже продаются!';break;};
$zact=round($x['balans']/100);
$zact2=$zact*49;
mysql_query("UPDATE `users` SET `money`=`money`+'$zact2' WHERE `id`='".$id."'");
mysql_query("UPDATE `gorod_firm` SET `birga`='yes' WHERE `login`='".$login."'");
echo'Ваша фирма стала акционерным обществом. 51% акций остается у
вас,49% продано на биржу по цене '.$zact.' монет.<br/>';
break;



case 'dengi':
if(!$gorod_firm){echo 'У вас нет фирмы!';break;};
$x=mysql_query("SELECT * FROM `gorod_firm` WHERE `name`='".$gorod_firm."' AND `login`='".$login."'");
if(!mysql_num_rows($x)){echo 'Ошибка';break;};
$x=mysql_fetch_assoc($x);

echo'КАССА ФИРМЫ<br/><br/>';

if (time()>=$x['lasttake']){
echo'ЕЖЕДНЕВНЫЙ ОТЧЁТ:<br/>';
$zp=rand(0,$x['pritok']/2);
$zp2=rand(0,$zp);
$zp3=rand(0,$zp2);
$zp4=rand(0,$zp3);
$pritog=round($x['pritok']-$zp);

if($x['birga']=='yes'){
$pritog=round($pritog/2);
echo 'Дивиденды по акциям переведены!<br/>';};

echo 'Вы забрали из кассы своей фирмы <font color="red">'.$pritog.'</font> монет.<br/>
'.$zp.' денег ушло на содержание фирмы.<br/>Из них:<br/>
'.$zp2.'-зарплата персонала<br/>
'.$zp3.'-налоги Админу<br/>
'.$zp4.'-закупка товара<br/><br/>';
mysql_query("UPDATE `gorod_firm` SET `pritok`='0',`lasttake`='".(time()+80000)."' WHERE `login`='".$login."'");
mysql_query("UPDATE `users` SET `money`=`money`+'$pritog' WHERE `id`='".$id."'");

}else{
echo'Взять выручку вы сможете только через '.maketime($x['lasttake']-time()).' работы фирмы.<br/>';};
echo'<br/><a href="firma.php?id='.$id.'&amp;pass='.$pass.'">Назад</a>';
break;





};


echo '<div class="msg"><a href="index.php?id='.$id.'&amp;pass='.$pass.'">В город</a></div>';


mysql_close();
print "</body></html>";
?>