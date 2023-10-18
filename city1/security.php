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
  case "n":
if(empty($money)) print $lang['voo_no_money'];
else
{
print $lang['sec_mes1'];
if(empty($what))
{
print $lang['cops_select_gun'].":<br/>";
print "</small><select name=\"what\">
<option value=\"10\">".$lang['gun1']."(50 $$)</option>
<option value=\"20\">".$lang['gun2']."(100 $$)</option>
<option value=\"40\">".$lang['gun3']."(200 $$)</option>
<option value=\"50\">".$lang['gun4']."(250 $$)</option>
<option value=\"60\">".$lang['gun5']."(350 $$)</option>
<option value=\"100\">".$lang['gun6']."(500 $$)</option>
<option value=\"120\">".$lang['gun7']."(600 $$)</option>
<option value=\"170\">".$lang['gun8']."(850 $$)</option>
<option value=\"200\">".$lang['gun9']."(1000 $$)</option>
<option value=\"310\">".$lang['gun10']."(1550 $$)</option>
<option value=\"550\">".$lang['gun11']."(2700 $$)</option>
<option value=\"1000\">".$lang['gun12']."(5000 $$)</option>
</select><br/><small>";
print "<anchor>".$lang['ok']."
<go href=\"security.php?id=$id&amp;pass=$pass&amp;mode=n\" method=\"post\">
<postfield name=\"what\" value=\"$(what)\"/></go></anchor><br/>";
}
else
{
$what_arr=array(10,20,40,50,60,100,120,170,200,310,550,1000);
if(!in_array($what,$what_arr)) die ($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if(($money-$what*5)<=0) die ($lang['voo_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
--$level;
if($level<0)$level=0;
$what2=$what*5;
mysql_query("update users set secur='".$what."',money='".$money."'-'".$what2."',level='".$level."' where id='".$id."';");
print $lang['sec_succ'];
}
}

print "&gt;<a href=\"security.php?id=$id&amp;pass=$pass\">".$lang['el_security']."</a><br/>";
break;
  case "u":
if(empty($money)) print $lang['voo_no_money'];
else
{
print $lang['sec_mes2'];
if(empty($what))
{
print $lang['cops_select_gun'].":<br/>";
print "</small><select name=\"what\">
<option value=\"10\">".$lang['gun1']."(50 $$)</option>
<option value=\"20\">".$lang['gun2']."(100 $$)</option>
<option value=\"40\">".$lang['gun3']."(200 $$)</option>
<option value=\"50\">".$lang['gun4']."(250 $$)</option>
<option value=\"60\">".$lang['gun5']."(350 $$)</option>
<option value=\"100\">".$lang['gun6']."(500 $$)</option>
<option value=\"120\">".$lang['gun7']."(600 $$)</option>
<option value=\"170\">".$lang['gun8']."(850 $$)</option>
<option value=\"200\">".$lang['gun9']."(1000 $$)</option>
<option value=\"310\">".$lang['gun10']."(1550 $$)</option>
<option value=\"550\">".$lang['gun11']."(2700 $$)</option>
<option value=\"1000\">".$lang['gun12']."(5000 $$)</option>
</select><br/><small>";
print "<anchor>".$lang['ok']."
<go href=\"security.php?id=$id&amp;pass=$pass&amp;mode=u\" method=\"post\">
<postfield name=\"what\" value=\"$(what)\"/></go></anchor><br/>";
}
else
{
$what_arr=array(10,20,40,50,60,100,120,170,200,310,550,1000);
if(!in_array($what,$what_arr)) die ($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if(($money-$what*5)<=0) die ($lang['voo_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
$sec_level=$what+$secur;
--$level;
if($level<0)$level=0;
$what2=$what*5;
mysql_query("update users set secur='".$sec_level."',money='".$money."'-'".$what2."',level='".$level."' where id='".$id."';");
print $lang['sec_mes3'];
}
}

print "&gt;<a href=\"security.php?id=$id&amp;pass=$pass\">".$lang['el_security']."</a><br/>";
break;
default:
print "<u>[".$lang['el_security']."]</u><br/>";
    print $lang['sec_enter'];
 
if($secur==0) print "<a href=\"security.php?id=$id&amp;pass=$pass&amp;mode=n\">".$lang['sec_get']."</a><br/>";
else print "<a href=\"security.php?id=$id&amp;pass=$pass&amp;mode=u\">".$lang['sec_more']."</a><br/>";

print "&gt;<a href=\"elite.php?id=$id&amp;pass=$pass\">".$lang['area_elite']."</a><br/>";
break;
}

print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</small></p></card></wml>");

}
?>