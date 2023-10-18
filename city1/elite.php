<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
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
die ($lang['empty_login']."</small></p></card></wml>");
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




switch ($mode) 
{  
  case "1a":
print "<u>[".$lang['el_1avenu']."]</u><br/>";

if(empty($what))
{
print "<a href=\"elite.php?id=$id&amp;pass=$pass&amp;mode=1a&amp;what=os\">".$lang['el_os']."</a><br/>";
/*print "<a href=\"museum.php?id=$id&amp;pass=$pass\"> </a><br/>";*/
}
elseif($what='os')
{

$os_cars=array($lang['car1'],$lang['car2'],$lang['car3'],$lang['car4'],$lang['car5']);
$cars_rand = rand(0, count($os_cars)-1);

if(empty($tachka) || empty($at_gun))
{
print $lang['el_1av_mes'];
print "<b>".$os_cars[$cars_rand]."</b><br/>";

if(!empty($guns))
{
$guns_array = explode(".", $guns);
$count_guns=count($guns_array);
print $lang['cops_select_gun']."</small><br/><select name=\"at_gun\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_array[$i]."\">".$guns_array[$i]."</option>"; 
}
print "</select><br/><small>";
print "
<anchor>".$lang['uv_try_steal']."
<go href=\"elite.php?id=$id&amp;pass=$pass&amp;mode=1a&amp;what=os\" method=\"post\">
<postfield name=\"tachka\" value=\"".$os_cars[$cars_rand]."\"/>
<postfield name=\"at_gun\" value=\"$(at_gun)\"/>
</go>
</anchor><br/>";
}

}
else
{
if($at_gun==$lang['gun1'])$at_gun=1;
elseif($at_gun==$lang['gun2'])$at_gun=2;
elseif($at_gun==$lang['gun3'])$at_gun=3;
elseif($at_gun==$lang['gun4'])$at_gun=4;
elseif($at_gun==$lang['gun5'])$at_gun=5;
elseif($at_gun==$lang['gun6'])$at_gun=6;
elseif($at_gun==$lang['gun7'])$at_gun=7;
elseif($at_gun==$lang['gun8'])$at_gun=8;
elseif($at_gun==$lang['gun9'])$at_gun=9;
elseif($at_gun==$lang['gun10'])$at_gun=10;
elseif($at_gun==$lang['gun11'])$at_gun=11;
elseif($at_gun==$lang['gun12'])$at_gun=12;

$gun_cop=rand(4,12);

if($gun_cop==4)$cop_gun=$lang['gun4'];
elseif($gun_cop==5)$cop_gun=$lang['gun5'];
elseif($gun_cop==6)$cop_gun=$lang['gun6'];
elseif($gun_cop==7)$cop_gun=$lang['gun7'];
elseif($gun_cop==8)$cop_gun=$lang['gun8'];
elseif($gun_cop==9)$cop_gun=$lang['gun9'];
elseif($gun_cop==10)$cop_gun=$lang['gun10'];
elseif($gun_cop==11)$cop_gun=$lang['gun11'];
elseif($gun_cop==12)$cop_gun=$lang['gun12'];

$police=$police+3;
if($gun_cop>$at_gun)
{
$health=$health-30;
if($health<0) $health=0;
mysql_query("update users set health='".$health."',police='".$police."' where id='".$id."';");
print $lang['bank_grab_fuck']." ".$cop_gun."!<br/>".$lang['bank_grab_health']." ".$health."%<br/>";
}
else
{
$grab_money=$money+$bmoney;
mysql_query("update users set money='".$grab_money."',police='".$police."' where id='".$id."';");
if(empty($cars)) 
mysql_query("update users set cars='$tachka' where id='".$id."';");
else 
mysql_query("update users set cars='$cars.$tachka' where id='".$id."';");
print "<b>$tachka</b> ".$lang['el_car_now_at_you']."<br/>";
}

}


}

print "&gt;<a href=\"elite.php?id=$id&amp;pass=$pass\">".$lang['area_elite']."</a><br/>";
break;
default:
print "<u>[".$lang['area_elite']."]</u><br/>";
    print $lang['el_mes']."<br/>";
  /*  print "<a href=\"museum.php?id=$id&amp;pass=$pass\"></a><br/>";*/
    print "<a href=\"rest.php?id=$id&amp;pass=$pass\">".$lang['rest']."</a><br/>";
    print "<a href=\"elite.php?id=$id&amp;pass=$pass&amp;mode=1a\">".$lang['el_1avenu']."</a><br/>";
    print "<a href=\"osobnyaki.php?id=$id&amp;pass=$pass\">".$lang['el_2avenu']."</a><br/>";
    print "<a href=\"security.php?id=$id&amp;pass=$pass\">".$lang['el_security']."</a><br/>";
print "&gt;<a href=\"area.php?id=$id&amp;pass=$pass\">".$lang['city1_area']."</a><br/>";
break;
}

include("./../includes/inc_in_city.php");

mysql_close();
include "./../includes/footer.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</small></p></card></wml>");

}
?>