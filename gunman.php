<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health from users where id='".$id."';"); 
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

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

if($level<50)
{
die ($lang['error']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='2' where id='".$id."';");

include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
print "<b>".$lang['game_city2']."</b><br/>";

print "<u>[".$lang['gm_name']."]</u><br/>";

switch ($mode) 
{  
  case "p":

if(empty($gun_sale))
{
if(!empty($guns))
{
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
print $lang['game_guns']." <b>($count_guns)</b>:<br/></small><select name=\"gun_sale\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select><small><br/>";
print "<anchor>".$lang['ok']."<go href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=p\" method=\"post\">
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
if($p==20) $gun=$lang['gun2'];
elseif($p==50) $gun=$lang['gun4'];
elseif($p==100) $gun=$lang['gun6'];
elseif($p==350) $gun=$lang['gun10'];
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
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=20\">".$lang['gun2']."</a>(20 $$),<br/>";
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=50\">".$lang['gun4']."</a>(50 $$),<br/>";
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=100\">".$lang['gun6']."</a>(100 $$),<br/>";
    print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k&amp;p=350\">".$lang['gun10']."</a>(350 $$)<br/>";
    print "&gt;<a href=\"gunman.php?id=$id&amp;pass=$pass\">".$lang['city2_gunman']."</a><br/>";
    break;

  default:
print $lang['gm_hello'];
print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=k\">".$lang['gm_k']."</a><br/>";
print "<a href=\"gunman.php?id=$id&amp;pass=$pass&amp;mode=p\">".$lang['gm_p']."</a><br/>";
  break;
}


print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer.php";
?>