<?php
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</body>
</html>");
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
$zav=$data['zav'];
$lsd=$data['lsd'];
$ban=$data['ban'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");
if($ban==0)
{

include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
print "<b>[Зд: $health %][Сыт: $golod %][Зщ: $secur %]</b><br/>";
print "<b>".$lang['game_city1']."</b><br/>";
print "<u>[".$lang['sl_fastfood']."]</u><br/>";

if(!empty($p))
{
if(($money-$p)<=0) print $lang['voo_no_money'];
else
{
if($p==50)
{
$gol_rand=rand(30,50);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-50;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
elseif($p==20)
{
$gol_rand=rand(10,20);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-20;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
elseif($p==10)
{
$gol_rand=rand(5,10);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-10;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
elseif($p==5)
{
$gol_rand=rand(1,5);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-5;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
}
}

print $lang['city1_at_you']." <b>$money $$</b> ".$lang['city1_want_buy']."<br/>";
print "-<a href=\"fastfood.php?id=$id&amp;pass=$pass&amp;p=50\">".$lang['ff-1']."</a>(50$$)<br/>";
print "-<a href=\"fastfood.php?id=$id&amp;pass=$pass&amp;p=20\">".$lang['ff-2']."</a>(20$$)<br/>";
print "-<a href=\"fastfood.php?id=$id&amp;pass=$pass&amp;p=10\">".$lang['ff-3']."</a>(10$$)<br/>";
print "-<a href=\"fastfood.php?id=$id&amp;pass=$pass&amp;p=5\">".$lang['ff-4']."</a>(5$$)<br/>";


print "&gt;<a href=\"slums.php?id=$id&amp;pass=$pass\">".$lang['city1_slums']."</a><br/>";


print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer2.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</body>
</html>");

}
?>