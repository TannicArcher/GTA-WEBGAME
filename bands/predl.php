<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));

if(!empty($id)) 
{
$q = mysql_query("select id,login,pass from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

if(!empty($dbid)) 
{
$qdb = mysql_query("select id,login,pass from users where id='".$dbid."';"); 
}
else
{
die ($lang['select_user_false']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];

$dbdata = mysql_fetch_array($qdb);

$dbid=$dbdata['id'];
$dblogin=$dbdata['login'];
$dbpass=$dbdata['pass'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

if(!empty($a))
{
if(empty($messaga)) print $lang['bands_where_offer']."<br/>";
else
{
$predl_que=mysql_query("select komu from messagi where kto='$id' and komu='$dbid';");
$predl_data = mysql_fetch_array($predl_que);
if(!empty($predl_data['komu'])) print $lang['patience']."<br/>";
else
{
$messaga=cyr(htmlspecialchars(stripslashes(trim($messaga))));
$messaga="<b>".$lang['bands_offer_enter_gang']." $login</b><br/>".$messaga."<br/>[<a href=\"./../bands/confirm.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=yes\">".$lang['yes']."</a>/<a href=\"./../bands/confirm.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=no\">".$lang['no']."</a>]";
print $lang['bands_your_offer_for']." $dblogin ".$lang['bands_transferred']."<br/>";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
}
}
}
else
{
print $lang['bands_you_can_make_band']." <b>$dblogin</b>. ".$lang['bands_offer_description']."<br/>";
print $lang['bands_write_your_offer']." $dblogin:</small><br/>";
print "<input name=\"messaga\" type=\"text\"/><br/><small>";
print "<anchor>".$lang['ok']."
<go href=\"predl.php?id=$id&amp;dbid=$dbid&amp;pass=$pass\" method=\"post\">
<postfield name=\"messaga\" value=\"$(messaga)\"/>
<postfield name=\"a\" value=\"b\"/>
</go>
</anchor><br/>";
}

print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
include "./../includes/footer.php";
?>