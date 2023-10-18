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

$uh_q=mysql_fetch_array(mysql_query("select userid,guns,cars,money from user_home where userid='".$id."';"));
if($ban==0)
{

$uh_guns=$uh_q['guns'];
$uh_cars=$uh_q['cars'];
$uh_money=$uh_q['money'];
$uh_userid=$uh_q['userid'];

if(empty($uh_cars) && empty($uh_guns) && empty($uh_money) && empty($uh_userid))
mysql_query("insert into user_home values(0,'$id','','','');");

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");
print "<b>[Зд: $health %][Сыт: $golod %][Зщ: $secur %]</b><br/>";


print "<b>".$lang['game_city1']."</b><br/>";

switch ($mode) 
{  
  case "cars":
 if($a=="v")
{
if(empty($tachka))
{
if(!empty($uh_cars))
{
$cars_count = explode(".", $uh_cars);
$count_cars=count($cars_count);
print $lang['uv_cars']." <b>($count_cars)</b>:<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=cars\" method=\"post\">";
print "<select name=\"tachka\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['bands_take']."\"/>";
    echo "</form>";
}
else
{
print $lang['uh_garage_empty'];
}
}
else
{
$cars_count = explode(".", $uh_cars);
$count_cars=count($cars_count);
if(!in_array($tachka,$cars_count)) die($lang['fa_car_false']."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>");

if(empty($cars)) mysql_query("update users set cars='$tachka' where id='".$id."';");
else mysql_query("update users set cars='$cars.$tachka' where id='".$id."';");

$cars_count = explode(".", $uh_cars);
$count_cars=count($cars_count);
if($count_cars<=1)
{
$uh_cars=str_replace("$tachka","","$uh_cars");
mysql_query("update user_home set cars='$uh_cars' where userid='".$id."';");
}
elseif($count_cars>1 && $cars_count[0]!=$tachka)
{
$uh_cars=str_replace(".$tachka","","$uh_cars");
mysql_query("update user_home set cars='$uh_cars' where userid='".$id."';");
}
elseif($count_cars>1 && $cars_count[0]==$tachka)
{
$uh_cars=str_replace("$tachka.","","$uh_cars");
mysql_query("update user_home set cars='$uh_cars' where userid='".$id."';");
}
print "<b>$tachka</b> ".$lang['uh_now_at_you']."<br/>";
}
}
elseif($a=="d")
{
if(empty($tachka))
{
if(!empty($cars))
{
$cars_count = explode(".", $cars);
$count_cars=count($cars_count);
print $lang['uv_cars']." <b>($count_cars)</b>:<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=cars\" method=\"post\">
<postfield name=\"tachka\" value=\"$(tachka)\"/>";
print "<select name=\"tachka\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['bands_add']."\"/>";
    echo "</form>";
}
else
{
print $lang['uh_you_without_cars'];
}
}
else
{
$cars_count = explode(".", $cars);

if(!in_array($tachka,$cars_count)) die($lang['fa_car_false']."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>");

if(empty($uh_cars)) mysql_query("update user_home set cars='$tachka' where userid='".$id."';");
else mysql_query("update user_home set cars='$uh_cars.$tachka' where userid='".$id."';");

$count_cars=count($cars_count);
if($count_cars<=1)
{
$cars=str_replace("$tachka","","$cars");
mysql_query("update users set cars='$cars' where id='".$id."';");
}
elseif($count_cars>1 && $cars_count[0]!=$tachka)
{
$cars=str_replace(".$tachka","","$cars");
mysql_query("update users set cars='$cars' where id='".$id."';");
}
elseif($count_cars>1 && $cars_count[0]==$tachka)
{
$cars=str_replace("$tachka.","","$cars");
mysql_query("update users set cars='$cars' where id='".$id."';");
}
print "<b>$tachka</b> ".$lang['uh_now_at_garage']."<br/>";
}
}
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=cars\">".$lang['uh_take_car_from_garage']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=cars\">".$lang['uh_add_car_into_garage']."</a><br/>";

print "&gt;<a href=\"user_home.php?id=$id&amp;pass=$pass\">".$lang['sl_your_home']."</a><br/>";

    break;
  case "guns":
if($a=="v")
{
if(empty($puwka))
{
if(!empty($uh_guns))
{
$guns_count = explode(".", $uh_guns);
$count_guns=count($guns_count);
print $lang['game_guns']." <b>($count_guns)</b>:<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=guns\" method=\"post\">
<postfield name=\"puwka\" value=\"$(puwka)\"/>";
print "<select name=\"puwka\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['bands_take']."\"/>";
echo "</form>";
}
else
{
print $lang['uh_you_without_guns']."<br/>";
}
}
else
{
$guns_count = explode(".", $uh_guns);
$count_guns=count($guns_count);
if(!in_array($puwka,$guns_count)) die($lang['uh_sklad_without_guns']."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>");

if(empty($guns)) mysql_query("update users set guns='$puwka' where id='".$id."';");
else mysql_query("update users set guns='$guns.$puwka' where id='".$id."';");

$guns_count = explode(".", $uh_guns);
$count_guns=count($guns_count);
if($count_guns<=1)
{
$uh_guns=str_replace("$puwka","","$uh_guns");
mysql_query("update user_home set guns='$uh_guns' where userid='".$id."';");
}
elseif($count_guns>1 && $guns_count[0]!=$puwka)
{
$uh_guns=str_replace(".$puwka","","$uh_guns");
mysql_query("update user_home set guns='$uh_guns' where userid='".$id."';");
}
elseif($count_guns>1 && $guns_count[0]==$puwka)
{
$uh_guns=str_replace("$puwka.","","$uh_guns");
mysql_query("update user_home set guns='$uh_guns' where userid='".$id."';");
}
print "<b>$puwka</b> ".$lang['uh_now_at_you']."<br/>";
}
}
elseif($a=="d")
{
if(empty($puwka))
{
if(!empty($guns))
{
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
print $lang['uv_cars']." <b>($count_guns)</b>:<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=guns\" method=\"post\">
<postfield name=\"puwka\" value=\"$(puwka)\"/>";
print "<select name=\"puwka\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>";
}
print "</select>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['bands_add']."\"/>";
echo "</form>";
}
else
{
print $lang['uh_sklad_without_guns']."<br/>";
}
}
else
{
$guns_count = explode(".", $guns);
if(!in_array($puwka,$guns_count)) die($lang['uh_sklad_without_guns']."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>");

if(empty($uh_guns)) mysql_query("update user_home set guns='$puwka' where userid='".$id."';");
else mysql_query("update user_home set guns='$uh_guns.$puwka' where userid='".$id."';");

$count_guns=count($guns_count);
if($count_guns<=1)
{
$guns=str_replace("$puwka","","$guns");
mysql_query("update users set guns='$guns' where id='".$id."';");
}
elseif($count_guns>1 && $guns_count[0]!=$puwka)
{
$guns=str_replace(".$puwka","","$guns");
mysql_query("update users set guns='$guns' where id='".$id."';");
}
elseif($count_guns>1 && $guns_count[0]==$puwka)
{
$guns=str_replace("$puwka.","","$guns");
mysql_query("update users set guns='$guns' where id='".$id."';");
}
print "<b>$puwka</b> ".$lang['uh_now_at_you_sklad']."<br/>";
}
}

print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=guns\">".$lang['uh_take_gun_from_sklad']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=guns\">".$lang['uh_add_gun_into_sklad']."</a><br/>";

print "&gt;<a href=\"user_home.php?id=$id&amp;pass=$pass\">".$lang['sl_your_home']."</a><br/>";

    break;
  case "money":
if($a=="v")
{
if(empty($babl) || $babl<0)
{
if(empty($uh_money) || $uh_money<=0) print $lang['uh_your_safe_empty'];
else
{
print $lang['uh_in_safe']." <b>$uh_money</b>$$.";
print $lang['bands_how_much_money_you_want']."<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=money\" method=\"post\">
<postfield name=\"babl\" value=\"$(babl)\"/>";
print "<input name=\"babl\" format=\"*N\" size=\"3\"/><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/>";
echo "</form>";
}
}
else
{

if(empty($uh_money) || $uh_money<=0 || $babl<0) print $lang['uh_your_safe_empty'];
else
{
$babl=cyr(htmlspecialchars(stripslashes(trim($babl))));
$money=$babl+$money;
$babl=$uh_money-$babl;
if(empty($babl) || $babl<=0) print $lang['uh_your_safe_empty'];
else
{
mysql_query("update user_home set money='".$babl."' where userid='".$id."';");
mysql_query("update users set money='".$money."' where id='".$id."';");
print $lang['uh_now_at_you']." <b>$money</b>$$<br/>";
}
}
}

}
elseif($a=="d")
{

if(empty($babl))
{
if(empty($money) || $money<=0 || $babl<0) print $lang['voo_no_money']."<br/>";
else
{
print $lang['city1_at_you']." <b>$money</b>$$.";
print $lang['uh_money_into_safe'].":<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=money\" method=\"post\">
<postfield name=\"babl\" value=\"$(babl)\"/>";
print "<input name=\"babl\" format=\"*N\" size=\"3\"/><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/>";
echo "</form>";
}
}
else
{
if(empty($money) || $money<=0 || $babl<0) print $lang['voo_no_money']."<br/>";
else
{
$babl=cyr(htmlspecialchars(stripslashes(trim($babl))));
$money=$money-$babl;
$uh_money=$uh_money+$babl;
if($money<=0) die($lang['voo_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>");
mysql_query("update user_home set money='".$uh_money."' where userid='".$id."';");
mysql_query("update users set money='".$money."' where id='".$id."';");
print $lang['uh_in_safe']." <b>".$babl."</b>$$<br/>";
}
}
}
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=money\">".$lang['uh_take_money_from_safe']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=money\">".$lang['uh_add_money_into_safe']."</a><br/>";

print "&gt;<a href=\"user_home.php?id=$id&amp;pass=$pass\">".$lang['sl_your_home']."</a><br/>";
    break;
  case "mails":

if($a!="see" && $a!="new")
{
print "-<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=see&amp;mode=mails\">".$lang['uh_view_mes']."</a><br/>";
print "-<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=new&amp;mode=mails\">".$lang['uh_write_mes']."</a><br/>";
print "-<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;a=see&amp;mode=mails&amp;del=y\">".$lang['uh_del_all_mes']."</a><br/>";
}
elseif($a=="see")
{
if(!empty($del)) 
{
mysql_query("DELETE FROM messagi WHERE komu='".$id."';");
print $lang['uh_mes_empty'];
}
$mess_q = mysql_query("select * from messagi where komu='$id' order by id desc limit 10;"); 
if(!empty($mess_q))
{
while($arrm=mysql_fetch_array($mess_q))
{
print $arrm['msg']."<br/>"; 
}
}

}
elseif($a=="new")
{

    if(!empty($messaga) && !empty($who))
 {
if(empty($messaga) || empty($who)) print $lang['mes_empty']."<br/>";
else
{
$who=htmlspecialchars(stripslashes(trim($who)));
$db=mysql_fetch_array(mysql_query("select login,id,pass from users where login='".$who."';"));
$dbid=$db['id'];
$dbpass=$db['pass'];
$dblogin=$db['login'];
if(empty($dbid)) die($lang['select_user_false']."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>");
$predl_que=mysql_query("select komu from messagi where kto='$id' and komu='$dbid';");
$predl_data = mysql_fetch_array($predl_que);
if(!empty($predl_data['komu'])) print $lang['patience']."<br/>";
else
{
print $lang['mes_succes1']." $dblogin ".$lang['mes_succes2']."<br/>";
$messaga=htmlspecialchars(stripslashes(trim($messaga)));
$messaga="<b>".$lang['mes_mes1']." $login:</b><br/>".$messaga."<br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=reply\">".$lang['mes_reply']."</a>/<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
}
}
}
else
{
print $lang['uh_mes_whom'];
print "<br/>";
echo "<form action=\"user_home.php?id=$id&amp;pass=$pass&amp;mode=mails&amp;a=new\" method=\"post\">
<postfield name=\"messaga\" value=\"$(messaga)\"/>
<postfield name=\"who\" value=\"$(who)\"/>";
print "<input name=\"who\" type=\"text\"/><br/>";
print $lang['uh_mes_text'];
print "<br/>";
print "<input name=\"messaga\" type=\"text\"/><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/>";
echo "</form>";
}

}

print "&gt;<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;mode=mails\">".$lang['uh_your_mails']."</a><br/>";
print "&gt;&gt;<a href=\"user_home.php?id=$id&amp;pass=$pass\">".$lang['sl_your_home']."</a><br/>";
    break;
  default:
print "<u>[".$lang['uh_logovo']."]</u><br/>";
print $lang['uh_enter'];
print "<a href=\"./../profile.php?id=$id&amp;pass=$pass\">".$lang['uh_your_profile']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;mode=cars\">".$lang['uh_your_cars']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;mode=guns\">".$lang['uh_your_guns']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;mode=money\">".$lang['uh_your_money']."</a><br/>";
print "<a href=\"user_home.php?id=$id&amp;pass=$pass&amp;mode=mails\">".$lang['uh_your_mails']."</a><br/>";
  break;
}


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