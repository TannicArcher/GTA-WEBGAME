<?php
include "ini.php";
include "includes/header.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

$power=cyr(htmlspecialchars(stripslashes(trim(base64_decode($power)))));
$who=htmlspecialchars(stripslashes(trim(base64_decode($who))));

$who=explode(".",$who);

if(!empty($id)) 
{
$q = mysql_query("select secur,cars,guns,id,login,pass,status,reg_data,money,level,police,health from users where id='".$id."';"); 
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
$guns=$data['guns'];
$cars=$data['cars'];
$secur=$data['secur'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");



if(isset($p) && isset($i) && isset($w) && isset($at_gun))
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
$i=cyr(htmlspecialchars(stripslashes(trim($i))));
$w=cyr(htmlspecialchars(stripslashes(trim($w))));
$at_gun=htmlspecialchars(stripslashes(trim($at_gun)));



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


if($p<=$at_gun) 
{
mysql_query("delete from attack where userid='$id' and who='$i.$w' and power='$p' limit 1;");
print $lang['fa_car_back'];
}
else
{

$query_ugon=mysql_query("select what from attack where userid='$id' and who='$i.$w' and power='$p' limit 1;"); 
$ugon_data = mysql_fetch_array($query_ugon);
$ud_what=$ugon_data['what'];
$qdb = mysql_query("select cars, police, health from users where id='$i';"); 
$dbdata = mysql_fetch_array($qdb);
$db_cars=$dbdata['cars'];
$cars_count = explode(".", $db_cars);
/*
if(!in_array($ud_what, $cars_count)) 
{
mysql_query("delete from attack where userid='$id' and who='$i.$w' and power='$p' limit 1;");
print $lang['fa_car_false']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>";
exit;
}
*/
$health2=$dbdata['health'];
$db_police=++$dbdata['police'];
if(empty($db_cars))
mysql_query("update users set cars='$ud_what',police='$db_police' where id='$i';");
elseif(count($cars_count)>=1)
mysql_query("update users set cars='$db_cars.$ud_what',police='$db_police' where id='$i';");
$cars_count2 = explode(".", $cars);
if(count($cars_count2)<=1)
{
$cars=str_replace("$ud_what","","$cars");
mysql_query("update users set cars='$cars' where id='$id';");
}
elseif(count($cars_count2)>1 && $cars_count2[0]!=$ud_what)
{
$cars=str_replace(".$ud_what","","$cars");
mysql_query("update users set cars='$cars' where id='$id';");
}
elseif(count($cars_count2)>1 && $cars_count2[0]==$ud_what)
{
$cars=str_replace("$ud_what.","","$cars");
mysql_query("update users set cars='$cars' where id='$id';");
}
mysql_query("delete from attack where userid='$id' and who='$i.$w' and power='$p' limit 1;");
print $lang['fa_steal1']." <b>$ud_what</b>! ".$lang['fa_steal2'];


}
}
else
{

if(!empty($guns))
{
print $lang['fa_gun_protect'];
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
print "</small><br/><select name=\"at_gun\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select><br/><small>";
print "<anchor>".$lang['fa_begin_protect']."
<go href=\"fuck_attack.php?id=$id&amp;pass=$pass\" method=\"post\">
<postfield name=\"p\" value=\"$power\"/>
<postfield name=\"i\" value=\"".$who[0]."\"/>
<postfield name=\"w\" value=\"".$who[1]."\"/>
<postfield name=\"at_gun\" value=\"$(at_gun)\"/>
</go></anchor><br/>";
}
else
{
$p=$power;
$i=$who[0];
$w=$who[1];
$at_gun=3;
$query_ugon=mysql_query("select what from attack where userid='$id' and who='$i.$w' and power='$p' limit 1;"); 
$ugon_data = mysql_fetch_array($query_ugon);
$ud_what=$ugon_data['what'];
$qdb = mysql_query("select cars, police, health from users where id='$i';"); 
$dbdata = mysql_fetch_array($qdb);
$db_cars=$dbdata['cars'];
$cars_count = explode(".", $db_cars);
if(empty($db_cars))
mysql_query("update users set cars='$ud_what' where id='$i';");
elseif(count($cars_count)>=1)
mysql_query("update users set cars='$db_cars.$ud_what' where id='$i';");
$cars_count2 = explode(".", $cars);
if(count($cars_count2)<=1)
{
$cars=str_replace("$ud_what","","$cars");
mysql_query("update users set cars='$cars' where id='".$id."';");
}
elseif(count($cars_count2)>1)
{
$cars=str_replace(".$ud_what","","$cars");
mysql_query("update users set cars='$cars' where id='".$id."';");
}
mysql_query("delete from attack where userid='$id' and who='$i.$w' and power='$p' limit 1;");
print $lang['fa_succes']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>";
exit;
}

}

print "<br/>---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
print "</small></p></card></wml>";
?>