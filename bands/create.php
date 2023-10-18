<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));
$nazv=cyr(htmlspecialchars(stripslashes(trim(substr($nazv,0,20)))));

if(!empty($id)) 
{
$q = mysql_query("select id,login,pass,level from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

if(!empty($dbid)) 
{
$qdb = mysql_query("select id,login,pass,level from users where id='".$dbid."';"); 
}
else
{
die ($lang['select_user_false']."</small></p></card></wml>");
}

if(empty($nazv)) 
{
die($lang['bands_and_where_name']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
}


$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$level=$data['level'];

$dbdata = mysql_fetch_array($qdb);

$dbid=$dbdata['id'];
$dblogin=$dbdata['login'];
$dbpass=$dbdata['pass'];
$dblevel=$dbdata['level'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");


mysql_query("DELETE FROM messagi WHERE kto='".$dbid."' and komu=".$id." limit 1;");


$predl_que=mysql_query("select id from bands where name='$nazv';");
$predl_data = mysql_fetch_array($predl_que);
if(!empty($predl_data['id'])) die($lang['bands_band_already_exists']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
else
{

$messaga=cyr(htmlspecialchars(stripslashes(trim($messaga))));
$messaga="<b>$login ".$lang['bands_band_created']." <u>$nazv</u>!</b><br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");

$band_level=($level+$dblevel)/2;

mysql_query("insert into bands values(0,'".$nazv."','".$login."','$login.$dblogin','".$band_level."','','','');");
mysql_query("update users set band='".$nazv."' where id='".$id."';");
mysql_query("update users set band='".$nazv."' where id='".$dbid."';");

print "<b><u>$nazv</u> ".$lang['bands_in_business']."</b><br/>";

}

print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
include "./../includes/footer.php";
?>