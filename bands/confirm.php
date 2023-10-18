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

switch ($mode) 
{  
  case "yes":
    mysql_query("DELETE FROM messagi WHERE kto='".$dbid."' and komu=".$id." limit 1;");
    $messaga=cyr(htmlspecialchars(stripslashes(trim($messaga))));
    $messaga="<b>$login ".$lang['bands_user_agree']."</small><br/><input name=\"nazv\" emptyok=\"false\" maxlength=\"20\"/><br/><small>[<anchor>".$lang['ok']."<go method=\"post\" href=\"./../bands/create.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id\"><postfield name=\"nazv\" value=\"$(nazv)\"/></go></anchor>]";
    mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
    print $lang['bands_mes_transfered_to_boss']."<br/>";
    break;
  case "no":
    mysql_query("DELETE FROM messagi WHERE kto='".$dbid."' and komu=".$id." limit 1;");
    $messaga="<b>$login ".$lang['bands_user_disagree']."</b><br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
    mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
    print $lang['bands_offer_rejected']."<br/>";
    break;
  default:
    print $lang['mes_empty']."<br/></small></p></card></wml>";
    exit;
  break;
}

print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
include "./../includes/footer.php";
?>