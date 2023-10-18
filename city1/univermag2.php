<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
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

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
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
print "<b>".$lang['game_city1']."</b>";

switch ($mode) 
{
  case guns:
    print "<br/><u>[".$lang['city1_guns_market']."]</u><br/>";
    if(!empty($p) && $money>=$p)
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
if($p==10) $gun=$lang['gun1'];
elseif($p==120) $gun=$lang['gun7'];
elseif($p==200) $gun=$lang['gun9'];
elseif($p==1000) $gun=$lang['gun8'];
else 
{
die($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
}
include "./../includes/inc_in_array.php";
if(empty($guns))
{
$money=$money-$p;
mysql_query("update users set guns='$gun',money='$money' where id='".$id."';");
}
elseif(!empty($guns))
{
                $money=$money-$p;
mysql_query("update users set guns='$guns.$gun',money='$money' where id='".$id."';");
}
print $lang['city1_yo_man']." $gun-".$lang['city1_best_purchase']."<br/>";
}
    elseif($money<=$p)
{
print $lang['city1_dont_have_money']."<br/>";
}
    print $lang['city1_at_you']." <b>$money $$</b> ".$lang['city1_want_buy']."<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=guns&amp;p=10\">".$lang['gun1']."</a>(10 $$),<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=guns&amp;p=70\">".$lang['gun5']."</a>(70 $$),<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=guns&amp;p=120\">".$lang['gun7']."</a>(120 $$),<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=guns&amp;p=200\">".$lang['gun9']."</a>(200 $$)<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=guns&amp;p=1000\">".$lang['gun8']."</a>(1000 $$)<br/>";
    print "&gt;<a href=\"univermag.php?id=$id&amp;pass=$pass\">".$lang['city1_market']."</a><br/>";
    break;
  case cars:
    print "<br/><u>[".$lang['city1_motor_show']."]</u><br/>";
    if(!empty($p) && $money>=$p)
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
if($p==80) $car=$lang['car1'];
elseif($p==400) $car=$lang['car2'];
elseif($p==700) $car=$lang['car3'];
elseif($p==1000) $car=$lang['car4'];
else
{
die($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
}
include "./../includes/inc_in_array.php";
if(empty($cars))
{
$money=$money-$p;
mysql_query("update users set cars='$car',money='$money' where id='".$id."';");
}
elseif(!empty($cars))
{
                $money=$money-$p;
mysql_query("update users set cars='$cars.$car',money='$money' where id='".$id."';");
}
print $lang['city1_yo_man']." $car-".$lang['city1_best_purchase']."<br/>";
}
    elseif($money<=$p)
{
print $lang['city1_dont_have_money']."<br/>";
}
    print $lang['city1_at_you']." <b>$money $$</b> ".$lang['city1_want_buy']."<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=cars&amp;p=80\">".$lang['car1']."</a>(80 $$),<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=cars&amp;p=400\">".$lang['car2']."</a>(400 $$),<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=cars&amp;p=700\">".$lang['car3']."</a>(700 $$),<br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=cars&amp;p=1000\">".$lang['car4']."</a>(1000 $$)<br/>";
    print "&gt;<a href=\"univermag.php?id=$id&amp;pass=$pass\">".$lang['city1_market']."</a><br/>";
    break;
  case health:
    print "<br/><u>[".$lang['city1_apteka']."]</u><br/>";
    if(!empty($p) && $money>=$p && ($health+$p)<=150)
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
$money=$money-$p;
$health=$health+$p;
mysql_query("update users set health='$health',money='$money' where id='".$id."';");
print $lang['city1_health_corrected']." <b>$p %</b>!<br/>";
}
    elseif($money<=$p)
{
print $lang['city1_dont_have_money']."<br/>";
}
    elseif(($health+$p)>=150)
{
print $lang['city1_health_cannot_be_more']." 150 %.<br/>";
}
    print $lang['city1_you_health']." <b>$health %</b> ".$lang['city1_and_at_you']." <b>$money $$</b> ".$lang['city1_how_much_correct_health']."</small><br/>";
    print "<input name=\"p\" size=\"3\" format=\"*N\" maxlength=\"3\"/><small>
<anchor>".$lang['ok']."
<go href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=health\" method=\"post\"><postfield name=\"p\" value=\"$(p)\"/></go></anchor><br/>";
    print "&gt;<a href=\"univermag.php?id=$id&amp;pass=$pass\">".$lang['city1_market']."</a><br/>";    
  break;
  case pm:
   print "<br/><u>[".$lang['city1_hair_saloon']."]</u><br/>";
    if(!empty($p) && $money>=$p && $p==100)
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
$money=$money-$p;
mysql_query("update users set police='0',money='$money' where id='".$id."';");
print $lang['city1_crime_rate_0']."<br/>";
}
    elseif(!empty($p) && ($p>100 || $p<100))
{
print $lang['city1_fuck_halyava']."<br/>";
}
    print $lang['city1_at_100']." $$ ".$lang['city1_we_shall_cut_you']." <b>$money $$</b><br/>";
    print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=pm&amp;p=100\">".$lang['city1_hair_cut']."</a><br/>";
    print "&gt;<a href=\"univermag.php?id=$id&amp;pass=$pass\">".$lang['city1_market']."</a><br/>";
  break;
  case tattoo:
   print "<br/><u>[".$lang['city1_tattoo_saloon']."]</u><br/>";
    if(!empty($p) && $money>=$p && ($p==5 || $p==5 || $p==5 || $p==5 || $p==5) && ($level+floor($p/5))<=50)
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
$money=$money-$p;
$level=$level+floor($p/50);
mysql_query("update users set level='$level',money='$money' where id='".$id."';");
print $lang['city1_now_you_authority']." <b>$level</b>!<br/>";
}
    elseif(!empty($p) && ($money<$p || ($level+floor($p/5))>999999 || $p!=5 || $p!=5 || $p!=5 || $p!=5 || $p!=5))
{
print $lang['city1_make_it_impossible']."<br/>";
}
    print $lang['city1_you_authority']." <b>$level</b> ".$lang['city1_and_at_you']." <b>$money $$</b> ".$lang['city1_tattoo_make_help_you_up_auth']."</small><br/>";
    print "<input name=\"p\" size=\"3\" format=\"*N\" maxlength=\"3\"/><small>
<anchor>".$lang['ok']."
<go href=\"univermag2.php?id=$id&amp;pass=$pass&amp;mode=tattoo\" method=\"post\"><postfield name=\"p\" value=\"$(p)\"/></go></anchor><br/>";

    print "&gt;<a href=\"univermag.php?id=$id&amp;pass=$pass\">".$lang['city1_market']."</a><br/>";
  break;
  default:
        print "<br/><u>[".$lang['city1_market']."]</u><br/>";
print $lang['city1_town_supermarket']."<br/>";
print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=guns\">".$lang['city1_guns']."</a><br/>";
print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=cars\">".$lang['city1_cars']."</a><br/>";
print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=health\">".$lang['city1_apteka']."</a><br/>";
print "<a href=\"univermag.php?id=$id&amp;pass=$pass&amp;mode=pm\">".$lang['city1_hair_saloon']."</a><br/>";
print "<a href=\"univermag2.php?id=$id&amp;pass=$pass&amp;mode=tattoo\">".$lang['city1_tattoo_saloon']."</a><br/>";
break;
}

print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</small></p></card></wml>");

}
?>