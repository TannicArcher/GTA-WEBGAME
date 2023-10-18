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
print "<u>[".$lang['sl_kol_voodoo']."]</u><br/>";

switch ($mode) 
{  
  case "kill":
if(empty($who))
{
    print $lang['voo_mes'];
    print "</small>";
    print "<input name=\"who\"/><br/><small>";
    print "<anchor>".$lang['ok']."<go href=\"voodoo.php?id=$id&amp;pass=$pass&amp;mode=kill\" method=\"post\">
<postfield name=\"who\" value=\"$(who)\"/>
</go></anchor><br/>";
}
else
{
if($money>50000)
   {
$db=mysql_fetch_array(mysql_query("select id,pass,money from users where login='".$who."';"));
$dbid=$db['id'];
$dbpass=$db['pass'];
$dbmoney=$db['money'];
if(empty($dbid))
{
print $lang['voo_sel_us_err']."<br/>";
}
else
{
/*
if($money<=$dbmoney)
{
$messaga="<b>".$lang['sl_kol_voodoo']."</b><br/>".$login." ".$lang['voo_from_kill']."<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
$dbmoney=$dbmoney-50000;
mysql_query("update users set money='".$money."' where id='".$id."';");
mysql_query("update users set money='".$dbmoney."' where id='".$dbid."';");
print $lang['voo_kill_error'];
}
else
{
*/
$messaga="<b>".$lang['sl_kol_voodoo']."</b><br/>".$login." ".$lang['voo_mes_porcha']."<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
mysql_query("update users set voodoo='1' where id='".$dbid."';");
$money=$money-50000;
mysql_query("update users set money='".$money."' where id='".$id."';");
print $who." ".$lang['voo_died']."<br/>";
/*}*/
}
   }
else
   {
print $lang['voo_no_money'];
   }
}

    print "&gt;<a href=\"voodoo.php?pass=$pass&amp;id=$id\">".$lang['sl_kol_voodoo']."</a><br/>";
    break;
  case "health":
if(empty($who) || empty($which))
{
    print $lang['voo_mes2'];
    print "</small>";
    print "<input name=\"who\"/><br/><small>";
print $lang['voo_and_wh_heal']."<br/></small>";
print "<input name=\"which\" format=\"*N\"/><br/><small>";
    print "<anchor>".$lang['ok']."<go href=\"voodoo.php?id=$id&amp;pass=$pass&amp;mode=health\" method=\"post\">
<postfield name=\"who\" value=\"$(who)\"/>
<postfield name=\"which\" value=\"$(which)\"/>
</go></anchor><br/>";
}
else
{
$who=cyr(htmlspecialchars(stripslashes(trim($who))));
$which=cyr(htmlspecialchars(stripslashes(trim($which))));
if($which<150 && $money>($which*20))
   {
$db=mysql_fetch_array(mysql_query("select id,pass,health from users where login='".$who."';"));
$dbid=$db['id'];
$dbpass=$db['pass'];
$dbhealth=$db['health'];
if(empty($dbid))
{
print $lang['voo_sel_us_err']."<br/>";
}
else
{
$dbhealth=$dbhealth-$which;
$money=$money-($which*20);
if($dbhealth<=10) die($lang['voo_health_err']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
$messaga="<b>".$lang['sl_kol_voodoo']."</b><br/>".$login." ".$lang['voo_heal_mes1']." ".$which." ".$lang['voo_heal_mes2']."<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
mysql_query("update users set money='".$money."' where id='".$id."';");
mysql_query("update users set health='".$dbhealth."' where id='".$dbid."';");
print $lang['voo_succes']."<br/>";

}
   }
else
   {
print $lang['voo_no_money'];
   }
}
    print "&gt;<a href=\"voodoo.php?pass=$pass&amp;id=$id\">".$lang['sl_kol_voodoo']."</a><br/>";
    break;

case "porcha":

if($money<1000) 
{
/*
mysql_query("delete from messagi where kto='".$dbid."' and komu='".$id."' limit 1;");
*/
die($lang['voo_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
}
else
{
$money=$money-1000;
mysql_query("update users set voodoo='',money='".$money."' where id='".$id."'");
print $lang['voo_pr_sn']."<br/>";
}

break;
  default:
print $lang['voo_mes3'];
print "<a href=\"voodoo.php?id=$id&amp;pass=$pass&amp;mode=kill\">".$lang['voo_kill']."</a><br/>";
print "<a href=\"voodoo.php?id=$id&amp;pass=$pass&amp;mode=health\">".$lang['voo_minus_he']."</a><br/>";
if(!empty($voo_por)) print "<a href=\"voodoo.php?pass=$pass&amp;id=$id&amp;mode=porcha\">".$lang['voo_otk_por']."</a><br/>";
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