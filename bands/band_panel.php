<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select cars,guns,money,id,login,pass,band from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}


$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$band=$data['band'];
$cars=$data['cars'];
$guns=$data['guns'];
$money=$data['money'];

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
$bcars=$band_array['cars'];
$bguns=$band_array['guns'];
$bmoney=$band_array['money'];
$band_members = explode(".", $members);
$count_members=count($band_members);
}

$band_level=0;
for($i=0;$i<$count_members;$i++)
{
$level_ar=mysql_fetch_array(mysql_query("select level from users where login='".$band_members[$i]."';"));
$band_level=$level_ar['level']+$band_level;
}
$band_level=ceil($band_level/$count_members);
mysql_query("update bands set avtoritet='".$band_level."' where name='".$band."';");

if($count_members<=1)
{
mysql_query("delete from bands where name='".$band."';");
print $lang['band_haha']."<br/>";
print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";
mysql_close();
include "./../includes/footer.php";
exit;
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

switch ($mode) 
{  
  case "new_member":
if($boss==$login)
{
if(!empty($a))
{
if(empty($dbid) && !empty($imya))
{
$imya=cyr(htmlspecialchars(stripslashes(trim($imya))));

$db=mysql_fetch_array(mysql_query("select id,band,pass from users where login='".$imya."';"));
if(empty($db['id'])) die($lang['bands_such_man_not_exist']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(in_array($imya, $band_members)) die($lang['bands_already_in_your_band']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if(!empty($db['band'])) die($lang['bands_user_already_have_band']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
$dbid=$db['id'];
$dbpass=$db['pass'];
mysql_query("DELETE FROM messagi WHERE kto='".$dbid."' and komu=".$id." limit 1;");
$messaga="<b>$login ".$lang['bands_accept_you_in']." $band!</b><br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
mysql_query("update bands set members='$members.$imya' where name='".$band."';");
mysql_query("update users set band='".$band."' where id='".$db['id']."';");
print "<b>$imya</b> ".$lang['bands_accepted_in_band']."<br/>";
}
else
{
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));
$db=mysql_fetch_array(mysql_query("select login,band,pass from users where id='".$dbid."';"));
$dblogin=$db['login'];
$dbpass=$db['pass'];
$dbband=$db['band'];
if(empty($dblogin)) die($lang['bands_such_man_not_exist']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if(!empty($dbband)) die($lang['bands_user_already_have_band']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if(in_array($dblogin, $band_members)) die($lang['bands_already_in_your_band']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
mysql_query("update bands set members='$members.$dblogin' where name='".$band."';");
mysql_query("update users set band='".$band."' where id='".$dbid."';");
mysql_query("DELETE FROM messagi WHERE kto='".$dbid."' and komu=".$id." limit 1;");
$messaga="<b>$login ".$lang['bands_accept_you_in']." $band!</b><br/>[<a href=\"./../mes.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['ok']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
print "<b>".$dblogin."</b> ".$lang['bands_accepted_in_band']."<br/>";
}
}
else
{
print $lang['bands_enter_nickname_man']."</small><br/>";
print "<input name=\"imya\"/><br/><small>";
print "<anchor>".$lang['ok']."<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=new_member&amp;a=b\" method=\"post\">
<postfield name=\"imya\" value=\"$(imya)\"/></go></anchor><br/>";
}
} 
print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
    break;
  case "del_member":
if($boss==$login)
{
if(!empty($a))
{
$imya=cyr(htmlspecialchars(stripslashes(trim($imya))));
$db=mysql_fetch_array(mysql_query("select id from users where login='".$imya."';"));
if(empty($db['id'])) die($lang['bands_such_man_not_exist']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if(!in_array($imya, $band_members)) die($lang['bands_such_man_not_exist']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
mysql_query("update users set band='' where id='".$db['id']."';");

if($count_members<=1)
{
$members=str_replace("$imya","","$members");
mysql_query("update bands set members='$members' where name='".$band."';");
}
elseif($count_members>1 && $band_members[0]!=$imya)
{
$members=str_replace(".$imya","","$members");
mysql_query("update bands set members='$members' where name='".$band."';");
}
elseif($count_members>1 && $band_members[0]==$imya)
{
$members=str_replace("$imya.","","$members");
mysql_query("update bands set members='$members' where name='".$band."';");
}
print "<b>$imya</b> ".$lang['bands_removed_from_band']."<br/>";

}
else
{
print $lang['bands_enter_nickname_man']."</small><br/>";
print "<input name=\"imya\"/><br/><small>";
print "<anchor>".$lang['ok']."<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=del_member&amp;a=b\" method=\"post\">
<postfield name=\"imya\" value=\"$(imya)\"/></go></anchor><br/>";
}
}

print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
    break;
  case "exit_band":

if(empty($r))
{
print $lang['bands_your_accept_it']."<br/>";
print "[<a href=\"band_panel.php?mode=exit_band&amp;id=$id&amp;pass=$pass&amp;r=y\">".$lang['bands_exit_user']."</a>/";
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['bands_remain_user']."</a>]<br/>";
print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
}
else
{
mysql_query("update users set band='' where id='".$id."';");

if($count_members<=1)
{
$members=str_replace("$login","","$members");
mysql_query("update bands set members='$members' where name='".$band."';");
}
elseif($count_members>1 && $band_members[0]!=$login)
{
$members=str_replace(".$login","","$members");
mysql_query("update bands set members='$members' where name='".$band."';");
}
elseif($count_members>1 && $band_members[0]==$login)
{
$members=str_replace("$login.","","$members");
mysql_query("update bands set members='$members' where name='".$band."';");
}
print $lang['bands_you_exit_from']." <b>$band</b>!<br/>";
}


    break;
  case "common_cars":

if($a=="v")
{
if(empty($tachka))
{
if(!empty($bcars))
{
$cars_count = explode(".", $bcars);
$count_cars=count($cars_count);
print $lang['uv_cars']." <b>($count_cars)</b>:</small><br/>";
print "<select name=\"tachka\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select><br/><small>
<anchor>".$lang['bands_take']."
<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=common_cars\" method=\"post\">
<postfield name=\"tachka\" value=\"$(tachka)\"/>
</go>
</anchor><br/>";
}
else
{
print $lang['bands_no_common_cars']."<br/>";
}
}
else
{
$cars_count = explode(".", $bcars);
$count_cars=count($cars_count);
if(!in_array($tachka,$cars_count)) die($lang['fa_car_false']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(empty($cars)) mysql_query("update users set cars='$tachka' where id='".$id."';");
else mysql_query("update users set cars='$cars.$tachka' where id='".$id."';");

$cars_count = explode(".", $bcars);
$count_cars=count($cars_count);
if($count_cars<=1)
{
$bcars=str_replace("$tachka","","$bcars");
mysql_query("update bands set cars='$bcars' where name='".$band."';");
}
elseif($count_cars>1 && $cars_count[0]!=$tachka)
{
$bcars=str_replace(".$tachka","","$bcars");
mysql_query("update bands set cars='$bcars' where name='".$band."';");
}
elseif($count_cars>1 && $cars_count[0]==$tachka)
{
$bcars=str_replace("$tachka.","","$bcars");
mysql_query("update bands set cars='$bcars' where name='".$band."';");
}
print "<b>$tachka</b> ".$lang['bands_car_now_at_you']."<br/>";
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
print $lang['uv_cars']." <b>($count_cars)</b>:</small><br/>";
print "<select name=\"tachka\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select><br/><small>
<anchor>".$lang['bands_add']."
<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=common_cars\" method=\"post\">
<postfield name=\"tachka\" value=\"$(tachka)\"/>
</go>
</anchor><br/>";
}
else
{
print $lang['bands_user_without_cars']."<br/>";
}
}
else
{
$cars_count = explode(".", $cars);

if(!in_array($tachka,$cars_count)) die($lang['fa_car_false']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(empty($bcars)) mysql_query("update bands set cars='$tachka' where name='".$band."';");
else mysql_query("update bands set cars='$bcars.$tachka' where name='".$band."';");

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
print "<b>$tachka</b> ".$lang['bands_now_in_common']."<br/>";
}
}
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=common_cars\">".$lang['bands_take_car_from_common']."</a><br/>";
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=common_cars\">".$lang['bands_add_car_into_common']."</a><br/>";

print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
    break;
  case "common_guns":

if($a=="v")
{
if(empty($puwka))
{
if(!empty($bguns))
{
$guns_count = explode(".", $bguns);
$count_guns=count($guns_count);
print $lang['bands_guns']." <b>($count_guns)</b>:</small><br/>";
print "<select name=\"puwka\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select><br/><small>
<anchor>".$lang['bands_take']."
<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=common_guns\" method=\"post\">
<postfield name=\"puwka\" value=\"$(puwka)\"/>
</go>
</anchor><br/>";
}
else
{
print $lang['bands_no_common_guns']."<br/>";
}
}
else
{
$guns_count = explode(".", $bguns);
$count_guns=count($guns_count);
if(!in_array($puwka,$guns_count)) die($lang['bands_no_common_guns']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(empty($guns)) mysql_query("update users set guns='$puwka' where id='".$id."';");
else mysql_query("update users set guns='$guns.$puwka' where id='".$id."';");

$guns_count = explode(".", $bguns);
$count_guns=count($guns_count);
if($count_guns<=1)
{
$bguns=str_replace("$puwka","","$bguns");
mysql_query("update bands set guns='$bguns' where name='".$band."';");
}
elseif($count_guns>1 && $guns_count[0]!=$puwka)
{
$bguns=str_replace(".$puwka","","$bguns");
mysql_query("update bands set guns='$bguns' where name='".$band."';");
}
elseif($count_guns>1 && $guns_count[0]==$puwka)
{
$bguns=str_replace("$puwka.","","$bguns");
mysql_query("update bands set guns='$bguns' where name='".$band."';");
}
print "<b>$puwka</b> ".$lang['bands_gun_now_at_you']."<br/>";
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
print $lang['uv_cars']." <b>($count_guns)</b>:</small><br/>";
print "<select name=\"puwka\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select><br/><small>
<anchor>".$lang['bands_add']."
<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=common_guns\" method=\"post\">
<postfield name=\"puwka\" value=\"$(puwka)\"/>
</go>
</anchor><br/>";
}
else
{
print $lang['bands_user_without_guns']."<br/>";
}
}
else
{
$guns_count = explode(".", $guns);
if(!in_array($puwka,$guns_count)) die($lang['bands_user_without_guns']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

if(empty($bguns)) mysql_query("update bands set guns='$puwka' where name='".$band."';");
else mysql_query("update bands set guns='$bguns.$puwka' where name='".$band."';");

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
print "<b>$puwka</b> ".$lang['bands_now_in_common']."<br/>";
}
}

print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=common_guns\">".$lang['bands_take_gun_from_common']."</a><br/>";
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=common_guns\">".$lang['bands_add_gun_into_common']."</a><br/>";

print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
    break;
  case "common_money":

if($a=="v")
{
if(empty($babl))
{
if(empty($bmoney) || $bmoney<=0) print $lang['bands_common_no_money']."<br/>";
else
{
print $lang['bands_in_common']." <b>$bmoney</b>$$.";
print $lang['bands_how_much_money_you_want']."</small><br/>";
print "<input name=\"babl\" format=\"*N\" size=\"3\"/><br/><small>";
print "<anchor>".$lang['ok']."<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=common_money\" method=\"post\">
<postfield name=\"babl\" value=\"$(babl)\"/></go></anchor><br/>";
}
}
else
{
/*if($babl>50) print $lang['bands_common_limit_50']."<br/>";
else
{*/
if(empty($bmoney) || $bmoney<=0) print $lang['bands_common_no_money']."<br/>";
else
{
$babl=cyr(htmlspecialchars(stripslashes(trim($babl))));
$money=$babl+$money;
$babl=$bmoney-$babl;
if(empty($babl) || $babl<=0) print $lang['bands_common_no_money']."<br/>";
else
{
mysql_query("update bands set money='".$babl."' where name='".$band."';");
mysql_query("update users set money='".$money."' where id='".$id."';");
print $lang['bands_you_owned_common_money']." <b>$money</b>$$<br/>";
/*}*/
}
}
}

}
elseif($a=="d")
{

if(empty($babl))
{
if(empty($money) || $money<=0) print $lang['bands_user_without_money_for']."<br/>";
else
{
print $lang['bands_money_at_you']." <b>$money</b>$$.";
print $lang['bands_how_much_money_put']."</small><br/>";
print "<input name=\"babl\" format=\"*N\" size=\"3\"/><br/><small>";
print "<anchor>".$lang['ok']."<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=common_money\" method=\"post\">
<postfield name=\"babl\" value=\"$(babl)\"/></go></anchor><br/>";
}
}
else
{
if(empty($money) || $money<=0) print $lang['bands_user_without_money_for']."<br/>";
else
{
$babl=cyr(htmlspecialchars(stripslashes(trim($babl))));
$money=$money-$babl;
$bmoney=$bmoney+$babl;
if($money<=0) die($lang['bands_user_without_money_for']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
mysql_query("update bands set money='".$bmoney."' where name='".$band."';");
mysql_query("update users set money='".$money."' where id='".$id."';");
print $lang['bands_money_in_common_account']." <b>".$babl."</b>$$<br/>";
}
}
}
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=v&amp;mode=common_money\">".$lang['bands_take_money_from_common']."</a><br/>";
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;a=d&amp;mode=common_money\">".$lang['bands_add_money_into_common']."</a><br/>";

print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
    break;

  case "mes":

if(empty($messaga))
{
    print $lang['bands_mes_title'].":<br/></small>";
    print "<input name=\"messaga\"/><br/>";
    print "<small><anchor>".$lang['ok']."<go href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=mes\" method=\"post\">
<postfield name=\"messaga\" value=\"$(messaga)\"/></go></anchor><br/>";
}
else
{
$messaga2=htmlspecialchars(stripslashes(trim($messaga)));
   for($i=0;$i<$count_members;$i++)
{
$mes_ar=mysql_fetch_array(mysql_query("select id,pass from users where login='".$band_members[$i]."';"));
$messaga="<b>$login-".$lang['bands_boss']." $band:</b><br/>".$messaga2."<br/>[<a href=\"./../mes.php?pass=".$mes_ar['pass']."&amp;id=".$mes_ar['id']."&amp;dbid=$id&amp;mode=reply\">".$lang['mes_reply']."</a>/<a href=\"./../mes.php?pass=".$mes_ar['pass']."&amp;id=".$mes_ar['id']."&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','".$mes_ar['id']."','$messaga');");
}
print $lang['bands_mes_peredan']."<br/>"; 
}
print "&gt;<a href=\"band_panel.php?id=$id&amp;pass=$pass\">".$lang['game_your_band']."</a><br/>";
    break;
  default:

print "<b>".$lang['bands_bandname']."</b>: $name<br/>";

$db=mysql_fetch_array(mysql_query("select id from users where login='".$boss."';"));
$bossid=$db['id'];

if(empty($bossid))
{
srand((double)microtime() *1000000);
$rand_key = array_rand($band_members,2);
print $lang['bands_old_b_new_b']."<br/>";
$new_boss=$band_members[$rand_key[0]];
print $new_boss."<br/>";
mysql_query("update bands set boss='".$new_boss."' where name='".$band."';");
}

print "<b>".$lang['bands_boss']."</b>: <a href=\"./../mes.php?id=$id&amp;pass=$pass&amp;dbid=$bossid&amp;mode=reply\">$boss</a><br/>";
print "<b>".$lang['uv_level']."</b>: $avtoritet<br/>";
print "<b>".$lang['bands_members']."($count_members)</b>:<br/>";

for($i=0;$i<$count_members;$i++)
{
print $band_members[$i].","; 
}
print "<br/>";

if($boss==$login)
{
print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=new_member\">".$lang['bands_new_member_of_gang']."</a><br/>
<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=del_member\">".$lang['bands_del_band_member']."</a><br/>
<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=mes\">".$lang['bands_mes_to_all']."</a><br/>";
}

print "<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=common_cars\">".$lang['bands_common_cars']."</a><br/>
<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=common_guns\">".$lang['bands_common_guns']."</a><br/>
<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=common_money\">".$lang['bands_common_money']."</a><br/>
<a href=\"band_panel.php?id=$id&amp;pass=$pass&amp;mode=exit_band\">".$lang['bands_exit_band']."</a><br/>
";

  break;
}




print "---<br/>&gt;<anchor>".$lang['back']."<prev/></anchor><br/>";
print "&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
include "./../includes/footer.php";
?>