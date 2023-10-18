<?php
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</body>
</html>");
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

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
print "<b>".$lang['in_meriya']."</b><br/>";
print "<u>[".$lang['faqm']."]</u><br/>";
print "<u>".$lang['faq_m']."</u><br/>";
print "".$lang['zayav']."<a href=\"./../mes.php?id=$id&amp;pass=$pass&amp;dbid=1&amp;mode=reply\">".$lang['tyt']."</a><br/>";
print "<u>".$lang['faq_m2']."</u><br/>";



print "---<br/>&gt;<a href=\"mer.php?id=$id&amp;pass=$pass\">".$lang['in_meriya']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer2.php";
?>