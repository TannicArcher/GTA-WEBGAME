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
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

if(empty($band)) 
{
die($lang['bands_band_not_chosen']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>"); 
}


$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];


if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}
else
{
$band_q=mysql_query("select * from bands where name='".$band."';");
$band_array=mysql_fetch_array($band_q);
$name=$band_array['name'];
$boss=$band_array['boss'];
$members=$band_array['members'];
$avtoritet=$band_array['avtoritet'];
}

$band_members = explode(".", $members);
$count_members=count($band_members);

print "<b>".$lang['bands_bandname']."</b>: $name<br/>";

$db=mysql_fetch_array(mysql_query("select id from users where login='".$boss."';"));
$dbid=$db['id'];

print "<b>".$lang['bands_boss']."</b>: <a href=\"./../mes.php?id=$id&amp;pass=$pass&amp;dbid=$dbid&amp;mode=reply\">$boss</a><br/>";
print "<b>".$lang['uv_level']."</b>: $avtoritet<br/>";
print "<b>".$lang['bands_members']."($count_members)</b>:<br/>";

for($i=0;$i<$count_members;$i++)
{
print $band_members[$i].","; 
}
print "<br/>";

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");



print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
include "./../includes/footer.php";
?>