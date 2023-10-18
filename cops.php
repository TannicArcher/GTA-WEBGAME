<?php
include "ini.php";
include "includes/header.php";
include "includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$login=cyr(htmlspecialchars(stripslashes(trim($login))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
if(!empty($login)) 
{  
$q = mysql_query("select band,guns,cars,id,login,pass,status,reg_data,money,level,police,health from users where login='".cyr($login)."';"); 
}
elseif(!empty($id)) 
{
$q = mysql_query("select band,guns,cars,id,login,pass,status,reg_data,money,level,police,health from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
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

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

print "<u>[".$lang['cop_title']."]</u><br/>";

switch ($mode) 
{  
  case "arest":
        mysql_query("update users set cars='',guns='',money='$money',police='0' where id='".$id."';");
print $lang['arrested']."<br/>";
    break;
  case "vzyatka":
    if(empty($a) && $money>150)
{
print $lang['cop_mes'];
        print "<a href=\"cops.php?id=$id&amp;pass=$pass&amp;mode=vzyatka&amp;a=b\">".$lang['cop_yes']."</a><br/>";
        print "<a href=\"cops.php?id=$id&amp;pass=$pass\">".$lang['cop_no']."</a><br/>";
}
    else
{
if($money<150) die($lang['voo_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
$money=$money-500;
mysql_query("update users set money='".$money."',police='0' where id='".$id."';");
print $lang['cops_free']."<br/>";
}
    break;
  case "kill":
if(empty($guns))
{
       mysql_query("update users set cars='',guns='',money='$money',police='0' where id='".$id."';");
print $lang['uv_without_guns']."<br/> ".$lang['arrested']."<br/>";
}
else
{
if(empty($a))
{
$guns_array = explode(".", $guns);
$count_guns=count($guns_array);
print $lang['cops_select_gun']."</small><select name=\"at_gun\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_array[$i]."\">".$guns_array[$i]."</option>"; 
}
print "</select><br/><small>";
print "<anchor>".$lang['ok']."
<go href=\"cops.php?id=$id&amp;pass=$pass&amp;mode=kill\" method=\"post\">
<postfield name=\"a\" value=\"b\"/> 
<postfield name=\"at_gun\" value=\"$(at_gun)\"/>
</go></anchor><br/>";
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

$gun_cop=rand(1,12);

if($gun_cop==1)$cop_gun=$lang['gun1'];
elseif($gun_cop==2)$cop_gun=$lang['gun2'];
elseif($gun_cop==3)$cop_gun=$lang['gun3'];
elseif($gun_cop==4)$cop_gun=$lang['gun4'];
elseif($gun_cop==5)$cop_gun=$lang['gun5'];
elseif($gun_cop==6)$cop_gun=$lang['gun6'];
elseif($gun_cop==7)$cop_gun=$lang['gun7'];
elseif($gun_cop==8)$cop_gun=$lang['gun8'];
elseif($gun_cop==9)$cop_gun=$lang['gun9'];
elseif($gun_cop==10)$cop_gun=$lang['gun10'];
elseif($gun_cop==11)$cop_gun=$lang['gun11'];
elseif($gun_cop==12)$cop_gun=$lang['gun12'];

if($gun_cop>$at_gun)
{
mysql_query("update users set cars='',guns='',money='money',police='0' where id='".$id."';");
print $lang['cop_power']." ".$cop_gun."!<br/> ".$lang['arrested']."<br/>";
}
else
{
$money=$money+300;
$level=$level+1;
mysql_query("update users set police='0',money='".$money."',level='".$level."' where id='".$id."';");
print $lang['cop_died']."<br/>";
}

}

}
    break;
  default:
    print $lang['cops_enter'];
    print "<a href=\"cops.php?id=$id&amp;pass=$pass&amp;mode=arest\">".$lang['cops_arrest']."</a><br/>";
    print "<a href=\"cops.php?id=$id&amp;pass=$pass&amp;mode=vzyatka\">".$lang['cops_put_money']."</a><br/>";
    print "<a href=\"cops.php?id=$id&amp;pass=$pass&amp;mode=kill\">".$lang['cops_attack']."</a><br/>";
  break;
}


print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor>";
print "<br/>&gt;&gt;<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
print "</small></p></card></wml>";
?>