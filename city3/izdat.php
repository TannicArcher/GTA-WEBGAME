<?php
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban,redaktor from users where id='".$id."';");
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
$zav=$data['zav'];
$lsd=$data['lsd'];
$ban=$data['ban'];
$redaktor=$data['redaktor'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
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

print "<b>".$lang['izdat']."</b><br/>";
print "<u>".$lang['izdat1']."</u><br/>";
print "<b>".$lang['glav_redaktor']."</b><br/>";

$pr_q=mysql_query("select login,redaktor from users where redaktor>0;");

while($pr_ar=mysql_fetch_array($pr_q))
{
++$i;
print "<b>".$i.".</b>".$pr_ar['login']." (".$pr_ar['redaktor'].")<br/>";
}
if($redaktor>=1)
{
print "<a href=\"add.php?newn&amp;id=$id&amp;pass=$pass\">".$lang['add']."</a><br/>";

}

if($redaktor==0)
{
	print "<br/>---";
print "<br/>&gt;&gt;<a href=\"vykup.php?id=$id&amp;pass=$pass\">".$lang['kupit_mesto']."</a><br/>";
}
print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";


include "./../includes/footer2.php";
}



mysql_close();
?>