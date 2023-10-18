<?php

include "ini3.php";
include "includes/header2.php";
include "includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$login=cyr(htmlspecialchars(stripslashes(trim($login))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($login)) 
{  
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd from users where login='".cyr($login)."';");
}
elseif(!empty($id)) 
{
$q = mysql_query("select secur,golod,admin,band,guns,cars,id,login,pass,status,reg_data,money,level,police,health,ban,zav,lsd from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</body></html>");
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
$cars=$data['cars'];
$guns=$data['guns'];
$band=$data['band'];
$golod=$data['golod'];
$secur=$data['secur'];
$admin=$data['admin'];
$ban=$data['ban'];
$lsd=$data['lsd'];
$zav=$data['zav'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body></html>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");
$asp = mysql_query("SELECT date FROM news ORDER BY dbid DESC LIMIT 1");
$news = mysql_fetch_array($asp);

print "<a href=\"news/index.php?id=$id&amp;pass=$pass\">Новости</a>[".($news['date'])."]<br/>";
$asd = mysql_query("SELECT date FROM gb ORDER BY dbid DESC LIMIT 1");
$gb = mysql_fetch_array($asd);
print "<a href=\"gb/index.php?id=$id&amp;pass=$pass\">Общение по игpe</a>[".($gb['date'])."]<br/>";
print "<a href=\"adminy.php?id=$id&amp;pass=$pass\">Администрация Игры</a><br/><br/>";
if($admin==7)
{
print "<a href=\"cpan/admina.php?id=$id&amp;pass=$pass\">АДМИНКА</a><br/>";
}
elseif($admin==6)
{
print "<a href=\"cpan/moder.php?id=$id&amp;pass=$pass\">Модерка</a><br/>";
}
if($zav==1)
{
print "<a href=\"cpan/mer.php?id=$id&amp;pass=$pass\">Мэр понель</a><br/>";
}
print "<u>".$lang['header']."</u><br/>";
print "<b>---------------</b><br/>";
if($ban==0)
{
print $lang['game_hello1'].", $login! ".$lang['game_hello2']."<br/>";




print "<b>[".$lang['game_towns']."]</b><br/>";
if($level>=0&& $level<35)
{
print "<a href=\"city1/index.wml?id=$id&amp;pass=$pass\">".$lang['game_city1']."</a><br/>";
print $lang['game_city2']."<br/>".$lang['game_city3']."<br/>";
}
elseif($level>=35 && $level<60)
{
print "<a href=\"city1/index.wml?id=$id&amp;pass=$pass\">".$lang['game_city1']."</a><br/>";
print "<a href=\"city2/index.wml?id=$id&amp;pass=$pass\">".$lang['game_city2']."</a><br/>";
print $lang['game_city3']."<br/>";
}
elseif($level>=60)
{
print "<a href=\"city1/index.wml?id=$id&amp;pass=$pass\">".$lang['game_city1']."</a><br/>";
print "<a href=\"city2/index.wml?id=$id&amp;pass=$pass\">".$lang['game_city2']."</a><br/>";
print "<a href=\"city3/index.wml?id=$id&amp;pass=$pass\">".$lang['game_city3']."</a><br/>";
}
if(!empty($band))
{
$band_q=mysql_query("select members from bands where name='".$band."';");
$band_array=mysql_fetch_array($band_q);
$members=$band_array['members'];
$band_members = explode(".", $members);
if(empty($members) || !in_array($login,$band_members))
mysql_query("update users set band='' where id='".$id."';");
else
{
print "<b>[".$lang['game_your_band']."]</b><br/>";
print "<a href=\"bands/band_panel.php?id=$id&amp;pass=$pass\">$band</a><br/>";
}
}

include("includes/inc_statusy.php");

print "<b>[".$lang['game_stats']."]</b><br/>";

print $lang['uv_money'].": <b>$money $$</b><br/>";
print $lang['uv_health'].": <b>$health %</b><br/>";
print $lang['uv_golod'].": <b>$golod %</b><br/>";
print $lang['uv_police'].": <b>$police</b><br/>";
print $lang['uv_level'].": <b>$level</b><br/>";
print $lang['uv_status'].": <b>$status</b><br/>";
print $lang['uv_secur'].": <b>$secur</b><br/>";



if(!empty($cars))
{
$cars_count = explode(".", $cars);
$count_cars=count($cars_count);
print "<br/>".$lang['game_cars']." <b>($count_cars)</b>:<br/>";
for($i=0;$i<$count_cars;$i++)
{
print $cars_count[$i].","; 
}
}
if(!empty($guns))
{
$guns_count = explode(".", $guns);
$count_guns=count($guns_count);
print "<br/>".$lang['game_guns']." <b>($count_guns)</b>:<br/>";
for($i=0;$i<$count_guns;$i++)
{
print $guns_count[$i].","; 
}




}

}

elseif($ban==1)
{
echo'<a href="http://aleshka.h2m.ru/gta">вы отбываете cpок в тюpьме.Попpобyйте ввеcти данные еще paз.</a><br/>';

}
print "         <br/>";
print "<a href=\"profile.php?id=$id&amp;pass=$pass\">Изменение пpофиля</a><br/>";
print "<a href=\"exit.php?id=$id&amp;pass=$pass\">Выход</a><br/>";


mysql_close();
print "</body></html>";
?>