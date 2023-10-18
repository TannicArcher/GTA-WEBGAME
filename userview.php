<?php
include "ini3.php";
include "includes/header2.php";
include "includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));

if(!empty($id))
{
$q = mysql_query("select band,guns,id,login,pass,status,reg_data,money,level,police,health,pol from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</body>
</html>");
}

if(!empty($dbid))
{
$qdb = mysql_query("select * from users where id='".$dbid."';");
}
else
{
die ($lang['select_user_false']."</body>
</html>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$status=$data['status'];
$reg_data=$data['reg_data'];
$money=$data['money'];
$level=$data['level'];
$police=$data['police'];
$health=$data['health'];
$guns=$data['guns'];
$band=$data['band'];
$pol=$data['pol'];

$dbdata = mysql_fetch_array($qdb);

$dbid=$dbdata['id'];
$dblogin=$dbdata['login'];
$dbstatus=$dbdata['status'];
$dbreg_data=$dbdata['reg_data'];
$dbmoney=$dbdata['money'];
$dblevel=$dbdata['level'];
$dbpolice=$dbdata['police'];
$dblife=$dbdata['life'];
$dbhealth=$dbdata['health'];
$dbcars=$dbdata['cars'];
$dbguns=$dbdata['guns'];
$dbstatus=$dbdata['status'];
$dbabout=$dbdata['about'];
$dbmobile=$dbdata['mobile'];
$dbemail=$dbdata['email'];
$dbband=$dbdata['band'];
$dbreg_data=$dbdata['reg_data'];
$reg=explode(":",$dbreg_data);
$dbsecur=$dbdata['secur'];
$dbpol=$dbdata['pol'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

include "includes/inc_refs.php";
mysql_query("update users set last='".time()."',city='0' where id='".$id."';");

switch ($mode)
{
  case cars:

if(!empty($dbsecur) && $dbsecur!=0) die ($lang['secur_oblom'])."<br/><anchor>".$lang['back']."<prev/></anchor></body>
</html>";

if($money>=$dbmoney || $level>=$dblevel)
{
if(!empty($guns) && empty($gun_ugnal))
{
echo $lang['uv_which_gun']." $tachki ".$lang['uv_u']." $dblogin?<br/>";
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
echo "</small><select name=\"gun_ugnal\">";
for($i=0;$i<$count_guns;$i++)
{
echo "<option value=\"".$guns_count[$i]."\">".$guns_count[$i]."</option>";
}
echo "</select><br/>";
echo "<anchor>".$lang['uv_try_steal']."
<go href=\"userview.php?id=$id&amp;pass=$pass&amp;dbid=$dbid&amp;mode=cars&amp;tachki=$tachki\" method=\"post\">
<postfield name=\"gun_ugnal\" value=\"$(gun_ugnal)\"/>
</go></anchor><br/>";
}
elseif(!empty($gun_ugnal))
{
$attack_q = mysql_query("select who from attack where userid='$dbid';");
$attack_d=mysql_fetch_array($attack_q);
$who=explode(".",$attack_d['who']);
if($who[0]==$id)
{
echo $lang['patience'];
}
else
{
/*
include "includes/func_gun_power.php";
*/

$gun_ugnal22=$gun_ugnal;
$tachki=cyr($tachki);
if($gun_ugnal==$lang['gun1'])$gun_ugnal=1;
elseif($gun_ugnal==$lang['gun2'])$gun_ugnal=2;
elseif($gun_ugnal==$lang['gun3'])$gun_ugnal=3;
elseif($gun_ugnal==$lang['gun4'])$gun_ugnal=4;
elseif($gun_ugnal==$lang['gun5'])$gun_ugnal=5;
elseif($gun_ugnal==$lang['gun6'])$gun_ugnal=6;
elseif($gun_ugnal==$lang['gun7'])$gun_ugnal=7;
elseif($gun_ugnal==$lang['gun8'])$gun_ugnal=8;
elseif($gun_ugnal==$lang['gun9'])$gun_ugnal=9;
elseif($gun_ugnal==$lang['gun10'])$gun_ugnal=10;
elseif($gun_ugnal==$lang['gun11'])$gun_ugnal=11;
elseif($gun_ugnal==$lang['gun12'])$gun_ugnal=12;
echo $lang['uv_if']." $dblogin ".$lang['uv_wait'];
mysql_query("insert into attack values(0,'$dbid','$id.$login','$login ".$lang['uv_mes1']." $tachki! ".$lang['uv_mes2']." $gun_ugnal22! ".$lang['uv_mes3']."','".$gun_ugnal."','".time()."','$tachki');");
}
}
elseif(empty($guns))
{
echo $lang['uv_without_guns'];
}
}
else
{
echo $lang['uv_not_perm'];
}
    break;

  default:
    echo "<u>[".$lang['uv_head']." $dblogin]</u><br/>";
    if ($pol==1)echo "<span class=\"status\">Пол: Мужской</span><br />\n";
elseif ($pol==0)echo "<span class=\"status\">Пол: Женский</span><br />\n";
echo $lang['regabout'].": $dbabout<br/>";
echo $lang['uv_mobile'].": $dbmobile<br/>";
echo $lang['uv_mail'].": $dbemail<br/>";
echo $lang['uv_regdate1'].": ".$reg[1]." ".$lang['uv_regdate2']." ".$reg[0]." ".$lang['uv_regdate3']."<br/>";
if($id!=$dbid)
{

if(!empty($band)) $boss_q=mysql_fetch_array(mysql_query("select boss from bands where name='".$band."';"));

if(empty($band) && empty($dbband)) echo "<a href=\"bands/predl.php?id=$id&amp;pass=$pass&amp;dbid=$dbid\">[".$lang['uv_make_band']."]</a><br/>";
elseif(!empty($band) && empty($dbband) && $login==$boss_q['boss']) echo "<a href=\"bands/band_panel.php?id=$id&amp;pass=$pass&amp;dbid=$dbid&amp;mode=new_member&amp;a=b\">[".$lang['uv_put_band']."]</a><br/>";
elseif(empty($band) && !empty($dbband)) echo "<a href=\"bands/vstup.php?id=$id&amp;pass=$pass&amp;band=".urlencode($dbband)."\">[".$lang['uv_enter_band']."]</a><br/>";

echo "<a href=\"mes.php?id=$id&amp;pass=$pass&amp;dbid=$dbid&amp;mode=reply\">[".$lang['uv_mes']."]</a><br/>";
echo "<a href=\"fight.php?id=$id&amp;pass=$pass&amp;dbid=$dbid\">[".$lang['uv_fight']."]</a><br/>";
}


echo "<u>[Игровые данные]</u><br/>";

echo $lang['uv_money'].": <b>$dbmoney $$</b><br/>";
echo $lang['uv_health'].": <b>$dbhealth %</b><br/>";
echo $lang['uv_police'].": <b>$dbpolice</b><br/>";
echo $lang['uv_level'].": <b>$dblevel</b><br/>";
if(!empty($dbband)) echo $lang['uv_band'].": <b><a href=\"bands/viewband.php?id=$id&amp;pass=$pass&amp;band=".urlencode($dbband)."\">$dbband</a></b><br/>";
echo $lang['uv_status'].": <b>$dbstatus</b><br/>";

if(!empty($dbcars))
{
$cars_count = explode(".", $dbcars);
$count_cars=count($cars_count);
echo $lang['uv_cars']." <b>($count_cars)</b>:<br/>";
echo "<select name=\"tachki\">";
for($i=0;$i<$count_cars;$i++)
{
echo "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>";
}
echo "</select><br/><anchor>".$lang['uv_try_steal']."
<go href=\"userview.php?id=$id&amp;pass=$pass&amp;dbid=$dbid&amp;mode=cars\" method=\"post\">
<postfield name=\"tachki\" value=\"$(tachki)\"/>
</go>
</anchor><br/>";
}
if(!empty($dbguns))
{
$guns_count = explode(".", $dbguns);
$count_guns=count($guns_count);
echo $lang['uv_guns']." <b>($count_guns)</b>:<br/>";
for($i=0;$i<$count_guns;$i++)
{
echo $guns_count[$i].",";
}
}
break;
}
echo "<a href='javascript:history.back(1)'>".$lang['back']."</a><br/>";
echo "&gt;&gt;<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
echo "</body>
</html>";

?>