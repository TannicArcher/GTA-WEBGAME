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
print "<u>[".$lang['ph_enter']."]</u><br/>";

switch ($mode) 
{  
  case "sale":

    if(!empty($p) && $money>=$p && ($health+$p)<=150 && ($p==50 || $p==70 || $p==100))
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
$money=$money-$p;
$health=$health+($p-30);
mysql_query("update users set health='$health',money='$money' where id='".$id."';");
print $lang['city1_health_corrected']." <b>$p %</b>!<br/>";
}
    elseif($money<=$p)
{
print $lang['city1_dont_have_money']."<br/>";
}
    elseif(($health+$p)>=150)
{
print $lang['city1_health_cannot_be_more']." 150 %.<br/>";
}
    elseif(empty($p))
{
    print "<img src=\"./../pics/1.jpg\" alt=\"50 $$\"/><br/>";
    print "-<a href=\"public_house.php?id=$id&amp;pass=$pass&amp;mode=sale&amp;p=50\">".$lang['ph_kup']."</a><b>(50 $$)</b><br/>";
    print "<img src=\"./../pics/2.jpg\" alt=\"70 $$\"/><br/>";
    print "-<a href=\"public_house.php?id=$id&amp;pass=$pass&amp;mode=sale&amp;p=70\">".$lang['ph_kup']."</a><b>(70 $$)</b><br/>";
    print "<img src=\"./../pics/3.jpg\" alt=\"100 $$\"/><br/>";
    print "-<a href=\"public_house.php?id=$id&amp;pass=$pass&amp;mode=sale&amp;p=100\">".$lang['ph_kup']."</a><b>(100 $$)</b><br/>";
   }
    print "&gt;<a href=\"public_house.php?id=$id&amp;pass=$pass\">".$lang['ph_enter']."</a><br/>";
 break;
  default:
   
   print $lang['ph_mes']."<br/>";
   print "<a href=\"public_house.php?id=$id&amp;pass=$pass&amp;mode=sale\">".$lang['ph_kup_sh']."</a><br/>";
  break;
}



print "---<br/>&gt;<a href=\"slum.php?id=$id&amp;pass=$pass\">".$lang['city1_slums']."</a>";
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