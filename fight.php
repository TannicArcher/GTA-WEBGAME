<?php
include "ini.php";
include "includes/header.php";
include "includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));

if(!empty($id)) 
{
$q = mysql_query("select secur,id,login,pass,health,police,guns,money from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

if(!empty($dbid)) 
{
$qdb = mysql_query("select secur,id,login,pass,health,police,guns,money from users where id='".$dbid."';"); 
}
else
{
die ($lang['select_user_false']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);
$id=$data['id'];
$login=$data['login'];
$health=$data['health'];
$police=$data['police'];
$guns=$data['guns'];
$money=$data['money'];
$secur=$data['secur'];

$dbdata = mysql_fetch_array($qdb);
$dblogin=$dbdata['login'];
$dbpass=$dbdata['pass'];
$dbhealth=$dbdata['health'];
$dbpolice=$dbdata['police'];
$dbguns=$dbdata['guns'];
$dbmoney=$dbdata['money'];
$dbsecur=$dbdata['secur'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}



mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

if(!empty($dbsecur) && $dbsecur!=0) die ($lang['secur_oblom']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");


$db=mysql_fetch_array(mysql_query("select userid,last from fights where userid='".$dbid."';"));
$dbf=$db['userid'];
if(empty($dbf))
{
mysql_query("insert into fights values(0,'$dbid','".time().".".$id."');");
$db=mysql_fetch_array(mysql_query("select userid,last from fights where userid='".$dbid."';"));
}
else
{
$f_data = explode(".", $db['last']);
$f_last = 300+intval($f_data[0]);
$f_id= intval($f_data[1]);

if(time()>$f_last) mysql_query("delete from fights where userid='".$dbid."';");


if($id!=$f_id || $id==$f_id) die ($lang['fi_already_fight']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");


}

$user_power=rand(1,100);
$db_user_power=rand(1,100);


if($user_power>$db_user_power)
{
if(($dbhealth-$user_power)>0) 
{
print $user_power." ".$lang['fi_mes_health']." ".$dblogin."<br/>";
$dbhealth=$dbhealth-$user_power;
mysql_query("update users set health='".$dbhealth."' where id='".$dbid."';");
}
else
{
print $lang['fi_chuvak_slab'];
}
if(($dbmoney-$user_power)>0) 
{
print $db_user_power." ".$lang['fi_mes_money']." ".$dblogin."<br/>";
$dbmoney=$dbmoney-$user_power;
mysql_query("update users set money='".$dbmoney."' where id='".$dbid."';");
$money=$money+$user_power;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
$dbguns_ar=explode(".",$dbguns);
if(!empty($dbguns) && count($dbguns_ar)>1)
{
srand((double)microtime() *1000000);
$rand_key = array_rand($dbguns_ar,2);
$puwka=$dbguns_ar[$rand_key[0]];

$guns_count = explode(".", $dbguns);
$count_guns=count($guns_count);
if(!in_array($puwka,$guns_count)) die($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(empty($guns)) mysql_query("update users set guns='$puwka' where id='".$id."';");
else mysql_query("update users set guns='$guns.$puwka' where id='".$id."';");

if($count_guns<=1)
{
$dbguns=str_replace("$puwka","","$dbguns");
mysql_query("update users set guns='$dbguns' where id='".$dbid."';");
}
elseif($count_guns>1 && $guns_count[0]!=$puwka)
{
$dbguns=str_replace(".$puwka","","$dbguns");
mysql_query("update users set guns='$dbguns' where id='".$dbid."';");
}
elseif($count_guns>1 && $guns_count[0]==$puwka)
{
$dbguns=str_replace("$puwka.","","$dbguns");
mysql_query("update users set guns='$dbguns' where id='".$dbid."';");
}
print "<b>$puwka</b> ".$lang['uh_now_at_you']."<br/>";
}
++$police;
mysql_query("update users set police='".$police."' where id='".$id."';");

mysql_query("DELETE FROM messagi WHERE kto='".$id."' and komu='".$dbid."' limit 1;");
$messaga="<b>".$lang['fi_fight_with_you']." <a href=\"./../userview.php?id=$dbid&amp;pass=$dbpass&amp;dbid=$id\">".$login."</a>!</b><br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");

}
else
{
if(($health-$user_power)>0) 
{
print $lang['fi_false']." ".$user_power." ".$lang['fi_health']."<br/>";
$health=$health-$user_power;
mysql_query("update users set health='".$health."' where id='".$id."';");
}
else
{
print $lang['fi_you_looser'];
}
if(($money-$user_power)>0) 
{
print $lang['fi_false']." ".$db_user_power."$$<br/>";
$money=$money-$user_power;
mysql_query("update users set money='".$money."' where id='".$id."';");
$dbmoney=$dbmoney+$user_power;
mysql_query("update users set money='".$dbmoney."' where id='".$dbid."';");
}
$guns_ar=explode(".",$guns);
if(!empty($guns) && count($guns_ar)>1)
{
srand((double)microtime() *1000000);
$rand_key = array_rand($guns_ar,2);
$puwka=$guns_ar[$rand_key[0]];

$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
if(!in_array($puwka,$guns_count)) die($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(empty($dbguns)) mysql_query("update users set guns='$puwka' where id='".$dbid."';");
else mysql_query("update users set guns='$guns.$puwka' where id='".$dbid."';");

if($count_guns<=1)
{
$guns=str_replace("$puwka","","$guns");
mysql_query("update users set guns='$guns' where id='".$id."';");
}
elseif($count_guns>1 && $guns_count[0]!=$puwka)
{
$guns=str_replace(".$puwka","","$guns");
mysql_query("update users set guns='$guns' where id='".$id."';");
}
elseif($count_guns>1 && $guns_count[0]==$puwka)
{
$guns=str_replace("$puwka.","","$guns");
mysql_query("update users set guns='$guns' where id='".$id."';");
}
print $dblogin." ".$lang['fi_otbilsya']."<b>".$puwka."</b> ".$lang['fi_now_u_nego']."<br/>";
}


mysql_query("DELETE FROM messagi WHERE kto='".$id."' and komu='".$dbid."' limit 1;");
$messaga="<b>".$lang['fi_fight_with_you']." <a href=\"./../userview.php?id=$dbid&amp;pass=$dbpass&amp;dbid=$id\">".$login."</a>!</b><br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");

}

$ref=mysql_fetch_array(mysql_query("select refer from refers where userid='".$id."';"));
$link=$ref['refer'];
if(empty($link))
print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
else
{
$link=preg_replace ("'&'", "&amp;", $link);
print "---<br/>&gt;<a href=\"".$link."\">".$lang['back']."</a><br/>";
}

print "&gt;&gt;<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
print "</small></p></card></wml>";
?>