<?php
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban,admin from users where id='".$id."';");
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
$admin=$data['admin'];

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
print "<b>[Зд: $health %][Сыт: $golod %][Зщ: $secur %]</b><br/>";
print "<b>".$lang['game_city1']."</b><br/>";
print "<u>[".$lang['in_meriya']."]</u><br/>";

if ($mode == "bands")
{
        print '<b>'.$lang['polh_bands'].'</b><br/>';
        $pr_q=mysql_query("select name,boss,avtoritet from bands order by avtoritet desc limit 10;");

        while($pr_ar=mysql_fetch_array($pr_q))
        {
                ++$i;
                print "<b>".$i.".</b>".$pr_ar['name']." (".$pr_ar['avtoritet'].")<br/>
                ".$lang['polh_boss'].": <b>".$pr_ar['boss']."</b><br/>";
        }
}
else
{

print "".$lang['s_mer']."<br/>";

$pr_q=mysql_query("select login,zav from users where zav=1;");

while($pr_ar=mysql_fetch_array($pr_q))
{
++$i;
print "<b>".$pr_ar['login']."</b><br/>";
}
}
print '---<br/><a href="./../golos/index.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['Vybory'].'</a><br/>';
print '<a href="faq.php?id='.$id.'&amp;pass='.$pass.'&amp;mode=bands">'.$lang['faqm'].'</a><br/>';
print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer2.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</body>
</html>");

}
?>