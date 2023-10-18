<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,band,voodoo,nums,guns,cars,id,login,pass,money,level,police,health from users where id='".$id."';"); 
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
$band=$data['band'];
$golod=$data['golod'];
$secur=$data['secur'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
print "<b>".$lang['game_city1']."</b><br/>";
print "<u>[".$lang['rest']."]</u><br/>";


$db=mysql_fetch_array(mysql_query("select * from krisha where city='1' and house='restaurant';"));
$bcity=$db['city'];
$bband=$db['band'];
$busers=$db['users'];
$bmoney=$db['money'];
$btime=$db['time'];

if(empty($bmoney))
{
$bank_money=rand(1,10000);
mysql_query("update krisha set money='".$bank_money."' where city='1' and house='restaurant';");
}

switch ($mode) 
{  
case "eat":

if(!empty($p))
{
if(($money-$p)<=0) print $lang['voo_no_money']."<br/>";
else
{
if($p==500)
{
$money=$money-500;
mysql_query("update users set money='".$money."',golod='150' where id='".$id."';");
print $lang['rest_now_yr_golod']." 150% :-)<br/>";
}
elseif($p==300)
{
$money=$money-300;
mysql_query("update users set money='".$money."',golod='100' where id='".$id."';");
print $lang['rest_now_yr_golod']." 100% :-)<br/>";
}
elseif($p==200)
{
$gol_rand=rand(50,100);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-200;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
elseif($p==100)
{
$gol_rand=rand(30,70);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-100;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
elseif($p==50)
{
$gol_rand=rand(5,10);
$golod=$golod+$gol_rand;
if($golod>150)print $lang['rest_golod_err'];
else
{
$money=$money-50;
mysql_query("update users set money='".$money."',golod='".$golod."' where id='".$id."';");
print $lang['rest_now_yr_golod']." ".$golod."% :-)<br/>";
}
}
}
}

print $lang['city1_at_you']." <b>$money $$</b>. ".$lang['rest_what_u_want']."<br/>";
print "-<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=eat&amp;p=500\">".$lang['rest-1']."</a>(500$$)<br/>";
print "-<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=eat&amp;p=300\">".$lang['rest-2']."</a>(300$$)<br/>";
print "-<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=eat&amp;p=200\">".$lang['rest-3']."</a>(200$$)<br/>";
print "-<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=eat&amp;p=100\">".$lang['rest-4']."</a>(100$$)<br/>";
print "-<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=eat&amp;p=50\">".$lang['rest-5']."</a>(50$$)<br/>";

print "&gt;<a href=\"rest.php?id=$id&amp;pass=$pass\">".$lang['rest']."</a><br/>";
break;

  case "grab":

if(empty($guns) || ($bband==$band || $bband==''))
{
print $lang['uv_without_guns']."<br/>";
}
else
{
if(empty($a))
{
$guns_array = explode(".", $guns);
$count_guns=count($guns_array);
print $lang['cops_select_gun']."</small><br/><select name=\"at_gun\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_array[$i]."\">".$guns_array[$i]."</option>"; 
}
print "</select><br/><small>";
print "<anchor>".$lang['ok']."
<go href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=grab\" method=\"post\">
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

$gun_cop=rand(3,12);

if($gun_cop==3)$cop_gun=$lang['gun3'];
elseif($gun_cop==4)$cop_gun=$lang['gun4'];
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

$health=$health-50;
if($health<0) $health=0;
mysql_query("update users set health='".$health."',police='".$police."' where id='".$id."';");
print $lang['bank_grab_fuck']." ".$cop_gun."!<br/>".$lang['bank_grab_health']." ".$health."%<br/>";
}
else
{
$grab_money=$money+$bmoney;
mysql_query("update users set money='".$grab_money."',police='".$police."' where id='".$id."';");
mysql_query("update krisha set money='0' where city='1' and house='restaurant';");
print $lang['rest_grab_yeah']." ".$grab_money."$$<br/>";
}

}

}
print "&gt;<a href=\"rest.php?id=$id&amp;pass=$pass\">".$lang['rest']."</a><br/>";
    break;
  case "kr":

if(empty($bband) && !empty($band)) 
{
mysql_query("update krisha set band='".$band."' where city='1' and house='restaurant'");
print $lang['rest_now_your_band_is_kr'];

$bank_band=mysql_fetch_array(mysql_query("select boss from bands where name='".$band."';"));
$boss=$bank_band['boss'];
$db_boss=mysql_fetch_array(mysql_query("select id,pass from users where login='".$boss."';"));
$dbid=$db_boss['id'];
$dbpass=$db_boss['pass'];
$messaga=$lang['rest_now_mes']."<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=0&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'0','$dbid','$messaga');");
}
else
{
print $lang['error']."<br/>";
}
print "&gt;<a href=\"rest.php?id=$id&amp;pass=$pass\">".$lang['rest']."</a><br/>";
    break;
 
 case "at_kr":
if(!empty($band) && $band!=$bband)
{
$band_array_att=mysql_fetch_array(mysql_query("select avtoritet from bands where name='".$band."';"));
$band_array_kr=mysql_fetch_array(mysql_query("select boss,avtoritet from bands where name='".$bband."';"));

$avtoritet_att=$band_array_att['avtoritet'];
$boss_kr=$band_array_kr['boss'];
$avtoritet_kr=$band_array_kr['avtoritet'];

if($avtoritet_att>$avtoritet_kr)
{
mysql_query("update krisha set band='".$band."' where city='1' and house='restaurant';");
print $lang['rest_kr_another_band']." ".$band."!<br/>";


$db_boss=mysql_fetch_array(mysql_query("select id,pass from users where login='".$boss_kr."';"));
$dbid=$db_boss['id'];
$dbpass=$db_boss['pass'];
$messaga="<b>".$lang['rest']."</b><br/>".$lang['rest_kr_another_band']." ".$band.".<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=0&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'0','$dbid','$messaga');");

}
elseif($avtoritet_att<=$avtoritet_kr)
{
print $lang['bank_small_level'];
}

}
else
{
print $lang['error']."<br/>";
}


print "&gt;<a href=\"rest.php?id=$id&amp;pass=$pass\">".$lang['rest']."</a><br/>";
    break;
  case "gp":
if(($btime+3600)<time())
{
$band_array=mysql_fetch_array(mysql_query("select boss,money from bands where name='".$bband."';"));
$percents=rand(1,1000);
$bmoney=$bmoney-$percents;
$band_money=$band_array['money'];
$band_boss=$band_array['boss'];
$band_money=$band_money+$percents;
mysql_query("update krisha set money='".$bmoney."',time='".time()."' where city='1' and house='restaurant';");
mysql_query("update bands set money='".$band_money."' where name='".$bband."';");
print $percents."$$ ".$lang['bank_now_at_obwak']."<br/>";
$db_boss=mysql_fetch_array(mysql_query("select id,pass from users where login='".$band_boss."';"));
$dbid=$db_boss['id'];
$dbpass=$db_boss['pass'];
$messaga="<b>".$lang['rest']."</b><br/>".$lang['bank_has_percents']."  ".$band_money."$$<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=0&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'0','$dbid','$messaga');");
}
else
{
print $lang['bank_kto-to']." ".$bband." ".$lang['bank_uje']."<br/>";
}

print "&gt;<a href=\"rest.php?id=$id&amp;pass=$pass\">".$lang['rest']."</a><br/>";
    break;

  default:
print $lang['rest_mes'];

print "<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=eat\">".$lang['rest_obed']."</a><br/>";
if(!empty($bband)) print $lang['bank_krishuet'].": <b><a href=\"./../bands/viewband.php?id=$id&amp;pass=$pass&amp;band=".urlencode($bband)."\">".$bband."</a></b><br/>";
if($bband!=$band || $bband=='') print "<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=grab\">".$lang['bank_grab']."</a><br/>";
if(empty($bband) && $band!='') print "<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=kr\">".$lang['bank_krisha']."</a><br/>";
elseif(!empty($bband) && $bband!=$band && $band!='')
{
print "<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=at_kr\">".$lang['bank_att_krisha']."</a><br/>";
}
if($band==$bband && $band!='') print "<a href=\"rest.php?id=$id&amp;pass=$pass&amp;mode=gp\">".$lang['bank_get_percent']."</a><br/>";
print "&gt;<a href=\"area.php?id=$id&amp;pass=$pass\">".$lang['city1_area']."</a><br/>";
  break;
}


print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer.php";
?>