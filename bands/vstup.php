<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
$band=cyr(htmlspecialchars(stripslashes(trim(urldecode($band)))));

if(!empty($id)) 
{
$q = mysql_query("select id,login,pass from users where id='".$id."';");
$data = mysql_fetch_array($q);
$id=$data['id'];
$login=$data['login']; 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

if(!empty($band)) 
{

$db=mysql_fetch_array(mysql_query("select boss from bands where name='".$band."';"));
$db2=mysql_fetch_array(mysql_query("select id,pass from users where login='".$db['boss']."';"));
$dbid=$db2['id'];
$dbpass=$db2['pass'];
}
else
{
die ($lang['bands_band_not_chosen']."</small></p></card></wml>");
}


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
$messaga="<b>".$lang['bands_request_from']." $login</b><br/>".$messaga."<br/>[<a href=\"./../bands/band_panel.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=new_member&amp;a=b\">".$lang['yes']."</a>/<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['no']."</a>]";
print $lang['bands_request_put_to_boss']."<br/>";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
}
}
}
else
{
print $lang['bands_you_can_enter1']." <b>$band</b>, ".$lang['bands_you_can_enter2']."<br/>";
print $lang['bands_write_you_req']."</small><br/>";
print "<input name=\"messaga\" type=\"text\"/><br/><small>";
print "<anchor>".$lang['ok']."
<go href=\"vstup.php?id=$id&amp;dbid=$dbid&amp;pass=$pass\" method=\"post\">
<postfield name=\"messaga\" value=\"$(messaga)\"/>
<postfield name=\"band\" value=\"$band\"/>
<postfield name=\"a\" value=\"b\"/>
</go>
</anchor><br/>";
}

print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
include "./../includes/footer.php";
?>