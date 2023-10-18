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
$q = mysql_query("select id,login,pass from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}


$data = mysql_fetch_array($q);
$id=$data['id'];
$login=$data['login'];



if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}


mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

print $lang['exit_ok']."<br/>";

print "<a href=\"index.php\">".$lang['home_page']."</a><br/>";

mysql_close();
print "</small></p></card></wml>";
?>