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
print "<u>[".$lang['chuv_enter']."]</u><br/>";

switch ($mode) 
{  
  case "e":
if(empty($p))
{
    print $lang['chuv_yes'];
print "<a href=\"chuvak.php?id=$id&amp;pass=$pass&amp;mode=e&amp;p=k\">".$lang['ph_kup']."</a><br/>";
}
else
{
if($money<100) die($lang['bands_user_without_money_for']."<br/><anchor>".$lang['back']."<prev/></anchor></p></card></wml>");
$money=$money-1000;
++$police;
mysql_query("update users set money='".$money."',police='".$police."',health='300' where id='".$id."';");
print $lang['chuv_warning'];
}
    break;
  default:
    print $lang['chuv_mes'];
    print "<a href=\"chuvak.php?id=$id&amp;pass=$pass&amp;mode=e\">".$lang['chuv_vopros']."</a><br/>";
    print "<a href=\"area.php?id=$id&amp;pass=$pass\">".$lang['chuv_ok']."</a><br/>";
  break;
}


include("./../includes/inc_in_city.php");

mysql_close();
include "./../includes/footer2.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</body>
</html>");

}
?>