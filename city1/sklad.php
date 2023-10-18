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
print "<b>".$lang['game_city1']."</b><br/>";
print "<u>[".$lang['skl_naz']."]</u><br/>";

switch ($mode) 
{  
  case "1":

if(empty($select)) 
{
print $lang['skl_you_want'];
print '<a href="sklad.php?id='.$id.'&amp;pass='.$pass.'&amp;select=t&amp;mode=1">'.$lang['uv_cars'].'</a><br/>';
print '<a href="sklad.php?id='.$id.'&amp;pass='.$pass.'&amp;select=o&amp;mode=1">'.$lang['uv_guns'].'</a><br/>';
print '<a href="sklad.php?id='.$id.'&amp;pass='.$pass.'&amp;select=b&amp;mode=1">'.$lang['uv_money'].'</a><br/>';
}
elseif($select=='t')
{

if(empty($tachka) || empty($komu))
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
print "</select><br/>
<small>".$lang['uh_mes_whom']."</small><br/>
<input name=\"komu\"/><br/><small>
<anchor>".$lang['bands_add']."
<go href=\"sklad.php?id=$id&amp;pass=$pass&amp;select=t&amp;mode=1\" method=\"post\">
<postfield name=\"tachka\" value=\"$(tachka)\"/>
<postfield name=\"komu\" value=\"$(komu)\"/>
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

$komu_arr=mysql_fetch_array(mysql_query("select id from users where login='".$komu."';"));

$dbid=$komu_arr['id'];
if(empty($dbid)) die($lang['voo_sel_us_err'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

mysql_query("insert into sklad values(0,'".$id."','".$dbid."','".$tachka."','1');");

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
print "<b>".$tachka."</b> ".$lang['skl_now_at_skl']."<br/>";
}


}
elseif($select=='o')
{
if(empty($puwka) || empty($komu))
{
if(!empty($guns))
{
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
print $lang['uv_guns']." <b>($count_guns)</b>:</small><br/>";
print "<select name=\"puwka\">";
for($i=0;$i<$count_guns;$i++)
{
print "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>"; 
}
print "</select><br/>
<small>".$lang['uh_mes_whom']."</small><br/>
<input name=\"komu\"/><br/><small>
<anchor>".$lang['bands_add']."
<go href=\"sklad.php?id=$id&amp;pass=$pass&amp;select=o&amp;mode=1\" method=\"post\">
<postfield name=\"puwka\" value=\"$(puwka)\"/>
<postfield name=\"komu\" value=\"$(komu)\"/>
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

if(!in_array($puwka,$guns_count)) die($lang['error']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

$komu_arr=mysql_fetch_array(mysql_query("select id from users where login='".$komu."';"));

$dbid=$komu_arr['id'];
if(empty($dbid)) die($lang['voo_sel_us_err'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

mysql_query("insert into sklad values(0,'".$id."','".$dbid."','".$puwka."','2');");

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
print "<b>".$puwka."</b> ".$lang['skl_now_at_skl']."<br/>";
}

}
elseif($select=='b')
{

if(empty($bablo) || empty($komu))
{
if(!empty($money))
{
print $lang['city1_at_you'].' '.$money.'$$.<br/>'.$lang['skl_ostav'].':</small><br/>';
print "<input name=\"bablo\" format=\"*N\" size=\"5\"/>$$<br/>
<small>".$lang['uh_mes_whom']."</small><br/>
<input name=\"komu\"/><br/><small>
<anchor>".$lang['bands_add']."
<go href=\"sklad.php?id=$id&amp;pass=$pass&amp;select=b&amp;mode=1\" method=\"post\">
<postfield name=\"bablo\" value=\"$(bablo)\"/>
<postfield name=\"komu\" value=\"$(komu)\"/>
</go>
</anchor><br/>";
}
else
{
print $lang['voo_no_money'];
}
}
else
{

if(!intval($bablo) || empty($bablo) || ($money-$bablo)<0) die($lang['voo_no_money']."<anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");

$komu_arr=mysql_fetch_array(mysql_query("select id from users where login='".$komu."';"));

$dbid=$komu_arr['id'];
if(empty($dbid)) die($lang['voo_sel_us_err'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

mysql_query("insert into sklad values(0,'".$id."','".$dbid."','".$bablo."','3');");
mysql_query("update users set money='".$money."'-'".$bablo."' where id='".$id."';");

print "<b>".$bablo."</b>$$ ".$lang['skl_now_at_skl']."<br/>";
}


}
else
{
print $lang['error'].'!<br/>';
}

print "&gt;<a href=\"sklad.php?id=$id&amp;pass=$pass\">".$lang['skl_naz']."</a><br/>";
    break;
  case "2":


if(!empty($_GET[chto]) && !empty($_GET[t]))
{

$t=base64_decode($_GET[t]);
$chto=urldecode($_GET[chto]);

if(mysql_num_rows(mysql_query("select id from sklad where (komu='".$id."' or kto='".$id."') and chto='".$chto."' and type='".$t."';"))<1) die($lang['error'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

if($t==1) mysql_query("update users set cars='".$cars.".".$chto."' where id='".$id."';");
elseif($t==2) mysql_query("update users set guns='".$guns.".".$chto."' where id='".$id."';");
elseif($t==3) mysql_query("update users set money='".$money."'+'".$chto."' where id='".$id."';");

mysql_query("delete from sklad where (komu='".$id."' or kto='".$id."') and chto='".$chto."' and type='".$t."' limit 1;");

if($t==3) print $chto.'$$ '.$lang['uh_now_at_you'].'!<br/>';
else print $chto.' '.$lang['uh_now_at_you'].'!<br/>';
}

$th_q = mysql_query("select * from sklad where komu='".$id."' or kto='".$id."' order by id desc limit 5;"); 
if(mysql_num_rows($th_q)<1) print $lang['skl_no_th'];
while($arrth=mysql_fetch_array($th_q))
{
$nick=mysql_fetch_array(mysql_query("select login from users where id='".$arrth['kto']."';"));
if($login!=$nick['login'])
{
if($arrth[type]==3) 
print $arrth['chto']."$$ ".$lang['skl_ot']." ".$nick['login']."<br/>"; 
else
print $arrth['chto']." ".$lang['skl_ot']." ".$nick['login']."<br/>";
}
else
{
if($arrth[type]==3) 
print $arrth['chto']."$$ (".$lang['skl_your_th'].")<br/>"; 
else
print $arrth['chto']." (".$lang['skl_your_th'].")<br/>";
}
print '<a href="sklad.php?id='.$id.'&amp;pass='.$pass.'&amp;mode=2&amp;chto='.urlencode($arrth['chto']).'&amp;t='.base64_encode($arrth['type']).'">'.$lang['skl_zabr'].'</a><br/>';
}

print "&gt;<a href=\"sklad.php?id=$id&amp;pass=$pass\">".$lang['skl_naz']."</a><br/>";
    break;
  default:
    print $lang['skl_enter'];
    print "<a href=\"sklad.php?id=$id&amp;pass=$pass&amp;mode=2\">".$lang['skl_zabr']."</a><br/>";
    print "<a href=\"sklad.php?id=$id&amp;pass=$pass&amp;mode=1\">".$lang['skl_put']."</a><br/>";
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