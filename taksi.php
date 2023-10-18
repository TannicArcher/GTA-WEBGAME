<?php
include "ini3.php";
include "includes/header2.php";
include "includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health from users where id='".$id."';"); 
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

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

include "includes/inc_secur.php";
include "includes/inc_golod.php";
include "includes/inc_hospital.php";
include "includes/inc_police.php";
include "includes/inc_die.php";
include "includes/inc_voodoo.php";
include "includes/inc_attack.php";
include "includes/inc_mes.php";
$money=$money-5;
mysql_query("update users set money='".$money."' where id='".$id."';");
print "<b>Плата за вызов такси 5$!</b><br/>";
print "Куда едем?<br/>";
print "------<br/>";
if($level>=0 && $level<35)
{
	
print "<a href=\"city1/index.php?id=$id&amp;pass=$pass\"><b>".$lang['game_city1']."</b></a><br/>";
print "<a href=\"city1/univermag.php?id=$id&amp;pass=$pass\">>".$lang['city1_market']."</a><br/>";
print "<a href=\"city1/slums.php?id=$id&amp;pass=$pass\">=>".$lang['city1_slums']."</a><br/>";
print "<a href=\"city1/area.php?id=$id&amp;pass=$pass\">=>".$lang['city1_area']."</a><br/>";
print "<a href=\"city1/police_house.php?id=$id&amp;pass=$pass\">=>".$lang['city1_police_house']."</a><br/>";
}

elseif($level>=35)
{
print "<a href=\"city1/index.php?id=$id&amp;pass=$pass\"><b>".$lang['game_city1']."</b></a><br/>";
print "<a href=\"city1/univermag.php?id=$id&amp;pass=$pass\">>".$lang['city1_market']."</a><br/>";
print "<a href=\"city1/slums.php?id=$id&amp;pass=$pass\">=>".$lang['city1_slums']."</a><br/>";
print "<a href=\"city1/area.php?id=$id&amp;pass=$pass\">=>".$lang['city1_area']."</a><br/>";
print "<a href=\"city1/police_house.php?id=$id&amp;pass=$pass\">=>".$lang['city1_police_house']."</a><br/>";
print "<a href=\"city2/index.php?id=$id&amp;pass=$pass\"><b>==>".$lang['game_city2']."</b></a><br/>";
print "<a href=\"city2/napitki.php?id=$id&amp;pass=$pass\">".$lang['napitki']."</a><br/>";
print "<a href=\"city2/gunman.php?id=$id&amp;pass=$pass\">".$lang['city2_gunman']."</a><br/>";
print "<a href=\"city1/gunman.php?id=$id&amp;pass=$pass\">Подозpительный тип</a><br/>";
print "<a href=\"city2/supermarket.php?id=$id&amp;pass=$pass\">".$lang['supermarket']."</a><br/>";
}


include "./../includes/footer2.php";	


mysql_close();
?>