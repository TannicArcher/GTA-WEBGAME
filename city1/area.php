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
print "<u>[".$lang['area_enter']."]</u><br/>";
print $lang['area_mes']."<br/>";

print "<a href=\"bega.php?id=$id&amp;pass=$pass\">Тараканьи бега</a><br/>";

print "<a href=\"about.php?id=$id&amp;pass=$pass\">".$lang['area_chuv']."</a><br/>";

print "<a href=\"chuvak.php?id=$id&amp;pass=$pass\">".$lang['chuv_enter']."</a><br/>";

print "<a href=\"bank.php?id=$id&amp;pass=$pass\">".$lang['area_bank']."</a><br/>";

print "<a href=\"kasino.php?id=$id&amp;pass=$pass\">".$lang['area_kasino']."</a><br/>";

print "<a href=\"agentstvo.php?id=$id&amp;pass=$pass\">".$lang['area_ag']."</a><br/>";

print "<a href=\"elite.php?id=$id&amp;pass=$pass\">Элитный район</a><br/>";

print "<a href=\"safe.php?id=$id&amp;pass=$pass\">Взломать сейф</a><br/>";

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