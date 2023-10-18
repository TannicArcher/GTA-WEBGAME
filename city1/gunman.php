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

if($level<50)
{
die ($lang['error']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='2' where id='".$id."';");
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
print "<b>".$lang['game_city2']."</b><br/>";

print "<u>[".$lang['gm2_name']."]</u><br/>";

switch ($mode) 
{  

case p:
if(empty($gun_sale))
{
if(!empty($guns))
{
if(empty($gun_sale))
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select><small><br/>";
print "<anchor>".$lang['ok']."<go href=\"./../city2/index.php?id=$id&amp;pass=$pass&amp;mode=p\" method=\"post\">
<postfield name=\"gun_sale\" value=\"$(gun_sale)\"/>
</go></anchor>";
}
else
{
print $lang['bs_error'];
}
}
else
{



$check=mysql_fetch_array(mysql_query("select guns from users where id='".$id."';"));
$ch_guns_ar=$check['guns'];
$ch_guns=explode('.',$ch_guns_ar);
if(!in_array($gun_sale,$ch_guns)) print $lang['error'];
else
{

$gun_sale=cyr(htmlspecialchars(stripslashes(trim($gun_sale))));
if($gun_sale==$lang['gun1'] && !empty($guns)) 
{
$money=$money+5;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun2'] && !empty($guns)) 
{
$money=$money+10;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun4'] && !empty($guns)) 
{
$money=$money+25;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun5'] && !empty($guns)) 
{
$money=$money+30;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun6'] && !empty($guns)) 
{
$money=$money+35;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun7'] && !empty($guns)) 
{
$money=$money+60;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun9'] && !empty($guns)) 
{
$money=$money+100;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($gun_sale==$lang['gun10'] && !empty($guns)) 
{
$money=$money+150;
mysql_query("update users set money='".$money."' where id='".$id."';");
}

$guns_array = explode(".", $guns);
if(count($guns_array)<=1)
{
$guns=str_replace("$gun_sale","","$guns");
mysql_query("update users set guns='$guns' where id='$id';");
}
elseif(count($guns_array)>1 && $guns_array[0]!=$gun_sale)
{
$guns=str_replace(".$gun_sale","","$guns");
mysql_query("update users set guns='$guns' where id='$id';");
}
elseif(count($guns_array)>1 && $guns_array[0]==$gun_sale)
{
$guns=str_replace("$gun_sale.","","$guns");
mysql_query("update users set guns='$guns' where id='$id';");
}

print $lang['gm_saled']." ".$money." $$!";

}
}

    print "<br/>&gt;<a href=\"gunman.php?id=$id&amp;pass=$pass\">".$lang['city2_gunman']."</a><br/>";
    break;

  case k:
    if(!empty($p) && $money>=$p)
{
$p=cyr(htmlspecialchars(stripslashes(trim($p))));
if($p==100000) $gun=$lang['gun11'];
elseif($p==300000) $gun=$lang['gun13'];
elseif($p==500000) $gun=$lang['gun14'];
elseif($p==1000000) $gun=$lang['gun12'];
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
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=100000\">".$lang['gun11']."</a>(100000 $$),<br/>";
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=300000\">".$lang['gun13']."</a>(300000 $$),<br/>";
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=500000\">".$lang['gun14']."</a>(500000 $$),<br/>";
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=1000000\">".$lang['gun12']."</a>(1000000 $$)<br/>";
    print "&gt;<a href=\"gunman.php?id=$id&amp;pass=$pass\">".$lang['city2_gunman2']."</a><br/>";
    break;

  default:
print $lang['gm2_hello'];
print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k\">Нy давай поcмотpим</a><br/>";
print "<a href=\"./../city2/index.php?id=$id&amp;pass=$pass\">".$lang['gm_p2']."</a><br/>";
  break;
}


print "---<br/>&gt;<a href=\"./../city2/index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
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