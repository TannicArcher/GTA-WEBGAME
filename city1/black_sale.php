<?php
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
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

switch ($mode) 
{  
  case "skupka":

if(empty($car_sale))
{
if(!empty($cars))
{
$cars_count = explode(".", $cars);
$count_cars=count($cars_count);
print $lang['game_cars']." <b>($count_cars)</b>:<br/>";
echo "<form action=\"black_sale.php?id=$id&amp;pass=$pass&amp;mode=skupka\" method=\"post\">
<postfield name=\"car_sale\" value=\"$(car_sale)\"/>";
print "<select name=\"car_sale\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/>";
    echo "</form>";
}
else
{
print $lang['bs_error'];
}
}
else
{

$check=mysql_fetch_array(mysql_query("select cars from users where id='".$id."';"));
$ch_cars_ar=$check['cars'];
$ch_cars=explode('.',$ch_cars_ar);
if(!in_array($car_sale,$ch_cars)) print $lang['error'];
else
{

$car_sale=cyr(htmlspecialchars(stripslashes(trim($car_sale))));
if($car_sale==$lang['car1'] && !empty($cars)) 
{
$money=$money+40;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car2'] && !empty($cars)) 
{
$money=$money+200;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car3'] && !empty($cars)) 
{
$money=$money+350;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car4'] && !empty($cars)) 
{
$money=$money+500;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car5'] && !empty($cars)) 
{
$money=$money+700;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car6'] && !empty($cars)) 
{
$money=$money+100000009999000;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car7'] && !empty($cars)) 
{
$money=$money+1500;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
elseif($car_sale==$lang['car8'] && !empty($cars)) 
{
$money=$money+1700;
mysql_query("update users set money='".$money."' where id='".$id."';");
}

$cars_array = explode(".", $cars);
if(count($cars_array)<=1)
{
$cars=str_replace("$car_sale","","$cars");
mysql_query("update users set cars='$cars' where id='$id';");
}
elseif(count($cars_array)>1 && $cars_array[0]!=$car_sale)
{
$cars=str_replace(".$car_sale","","$cars");
mysql_query("update users set cars='$cars' where id='$id';");
}
elseif(count($cars_array)>1 && $cars_array[0]==$car_sale)
{
$cars=str_replace("$car_sale.","","$cars");
mysql_query("update users set cars='$cars' where id='$id';");
}
print $lang['bs_car_saled']." ".$money." $$!<br/>";
}
}
    print "<br/>&gt;<a href=\"black_sale.php?id=$id&amp;pass=$pass\">".$lang['sl_black_sale']."</a><br/>";
    break;
  case "nap":
print "<u>[".$lang['bs_nap']."]</u><br/>";
print $lang['bs_nap_mes']."<br/>";

if(!empty($p) && ($p==1 || $p==2 || $p=3))
{
$val=rand(1,4);
if($p==$val)
{
$val=$val*4;
print $lang['bs_nap_yes1']." ".$p." ".$lang['bs_nap_yes2']." ".$val."$$<br/>";
$money=$money+$val;
mysql_query("update users set money='".$money."' where id='".$id."';");
}
else
{
$money=$money-($p+$p);
if($money<=0) print $lang['voo_no_money'];
else
{
mysql_query("update users set money='".$money."' where id='".$id."';");
print $lang['bs_nap_false']." ".$money."$$<br/>";
}
}

}
    print "-<a href=\"black_sale.php?id=$id&amp;pass=$pass&amp;mode=nap&amp;p=1\">".$lang['bs_nap_stakan']." 1</a><br/>";
    print "-<a href=\"black_sale.php?id=$id&amp;pass=$pass&amp;mode=nap&amp;p=2\">".$lang['bs_nap_stakan']." 2</a><br/>";
    print "-<a href=\"black_sale.php?id=$id&amp;pass=$pass&amp;mode=nap&amp;p=3\">".$lang['bs_nap_stakan']." 3</a><br/>";


    print "&gt;<a href=\"black_sale.php?id=$id&amp;pass=$pass\">".$lang['sl_black_sale']."</a><br/>";
    break;
  default:
print "<u>[".$lang['sl_black_sale']."]</u><br/>";
print $lang['bs_mes']."<br/>";
print "<a href=\"black_sale.php?id=$id&amp;pass=$pass&amp;mode=skupka\">".$lang['bs_skup_krad']."</a><br/>";
print "<a href=\"black_sale.php?id=$id&amp;pass=$pass&amp;mode=nap\">".$lang['bs_nap']."</a><br/>";
  break;
}


include "./../includes/inc_in_city.php";
mysql_close();
include "./../includes/footer2.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</body>
</html>");

}
?>