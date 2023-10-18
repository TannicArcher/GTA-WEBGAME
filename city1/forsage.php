<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select level,cars,id,pass,money,golod,health,secur,zav,lsd,ban from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$money=$data['money'];
$cars=$data['cars'];
$level=$data['level'];
$golod=$data['golod'];
$health=$data['health'];
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

mysql_query("delete from forsage where time<('".time()."'-'3600');");

$f_car=mysql_fetch_array(mysql_query("select gonka,car,mods from forsage_cars where userid='".$id."';"));

$gonka=$f_car['gonka'];
$car=$f_car['car'];
$mods=$f_car['mods'];
print "<b>[Зд: $health %][Сыт: $golod %][Зщ: $secur %]</b><br/>";
  
print "<b>".$lang['game_city1']."</b><br/>";

switch ($mode) 
{  
  case "1":

if(mysql_result(mysql_query("SELECT COUNT(id) FROM forsage;"),0)>$limit) die($lang['for_nelzya'].' <b>'.$limit.'</b><br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');


$proverka=mysql_fetch_array(mysql_query("select id from forsage where id='".$gonka."';"));

if($proverka['id']==$gonka && $proverka['id']!='') die($lang['for_uje'].' '.$gonka.'!<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');


if(empty($tachka))
{

if(!empty($cars))
{
print $lang['for_select'];
$cars_count = explode(".", $cars);
$count_cars=count($cars_count);
print $lang['uv_cars']." <b>($count_cars)</b>:</small><br/>";
print "<select name=\"tachka\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select><br/><small>
<anchor>".$lang['ok']."
<go href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=1\" method=\"post\">
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

$cars_win_array=array($lang['car8'],$lang['car2'],$lang['car3'],$lang['car4'],$lang['car5'],$lang['car6'],$lang['car7'],$lang['car1']);
srand((double)microtime() *1000000);
$rand_key = array_rand($cars_win_array,2);

$win_car=$cars_win_array[$rand_key[0]];

mysql_query("insert into forsage values(0,'".$id."','1','".$win_car."','".time()."');");

$f_gonki=mysql_fetch_array(mysql_query("select id from forsage where users='".$id."';"));

$gid=$f_gonki['id'];

if($tachka==$lang['car1']) $mod_power=1;
elseif($tachka==$lang['car2']) $mod_power=2;
elseif($tachka==$lang['car3']) $mod_power=3;
elseif($tachka==$lang['car4']) $mod_power=4;
elseif($tachka==$lang['car5']) $mod_power=5;
elseif($tachka==$lang['car6']) $mod_power=6;
elseif($tachka==$lang['car7']) $mod_power=7;
elseif($tachka==$lang['car8']) $mod_power=8;


if(empty($gonka) || $gonka==0)
mysql_query("insert into forsage_cars values(0,'".$id."','".$gid."','".$tachka."','".$mod_power."');");
else
mysql_query("update forsage_cars set gonka='".$gid."',car='".$tachka."',mods='".$mod_power."' where userid='".$id."'");


print $lang['for_success'];
}


    print "&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass\">".$lang['city1_forsage']."</a><br/>";
    break;
  case "2":

if($car==$lang['car1']) die($lang['for_velik'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

print '<u>['.$lang['for_masters'].']</u><br/>';


if(empty($upd))
{
print $lang['for_upg_mes'];
print $lang['city1_at_you'].' '.$money.'$$. '.$lang['for_plz_sel'].'<br/></small><select name="upd">';
print '<option value="1">'.$lang['for_upg1'].' (20 $$)</option>';
print '<option value="2">'.$lang['for_upg2'].' (40 $$)</option>';
print '<option value="3">'.$lang['for_upg3'].' (50 $$)</option>';
print '<option value="4">'.$lang['for_upg4'].' (70 $$)</option>';
print '<option value="5">'.$lang['for_upg5'].' (100 $$)</option>';
print '<option value="6">'.$lang['for_upg6'].' (120 $$)</option>';
print '<option value="7">'.$lang['for_upg7'].' (140 $$)</option>';
print '<option value="8">'.$lang['for_upg8'].' (150 $$)</option>';
print '</select><br/><small>';
print '<anchor>'.$lang['ok'].'<go href="forsage.php?id='.$id.'&amp;pass='.$pass.'&amp;mode=2" method="post"><postfield name="upd" value="$(upd)"/></go></anchor><br/>';
}
else
{
if(!intval($upd) || ($upd<1 || $upd>8)) die($lang['error'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

$cena=array('20','40','50','70','100','120','140','150');


if($money<$cena[$upd-1]) die($lang['voo_no_money'].'<anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

$mods=$mods+$upd;
mysql_query("update forsage_cars set mods='".$mods."' where userid='".$id."'");
$money=$money-$cena[$upd-1];
mysql_query("update users set money='".$money."' where id='".$id."'");

print $lang['for_your_car_pr'].' '.$upd.' '.$lang['for_ed'].'! '.$lang['for_uroven'].' ('.$car.') '.$mods.' '.$lang['for_ed'].'! '.$lang['city1_at_you'].' '.$money.'$$!<br/>';
print "&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=2\">".$lang['for_update']."</a><br/>";
}

    print "&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass\">".$lang['city1_forsage']."</a><br/>";
    break;

  case "3":
include './../functions/func_pagination.php';

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$base_url="forsage.php?id=$id&amp;pass=$pass&amp;mode=3&amp;start=";
$num_items=mysql_num_rows(mysql_query("select id from forsage;"));

print '<u>['.$lang['for_gonwiki'].']</u><br/>';

$i=0;
$now_q = mysql_query("select id,win,users from forsage order by id desc limit $start,$per_page;"); 
if(mysql_num_rows($now_q)<1) print $lang['for_no_zaezd'];
while($now_arr=mysql_fetch_array($now_q))
{
++$i;
$nom=$i+$start;
$uch=count(explode('.',$now_arr['users']));
print '<u>'.$nom.'</u>. '.$lang['for_gonka'].' <b>'.$now_arr['id'].'</b>, '.$lang['for_u4-kov'].' <b>'.$uch.'</b><br/>'.$lang['for_priz'].' '.$now_arr['win'].'<br/>';
print '[<a href="forsage.php?id='.$id.'&amp;pass='.$pass.'&amp;mode=6&amp;dbid='.$now_arr['id'].'">'.$lang['for_info'].'</a>]<br/>';
if($uch<5 && !in_array($id,explode('.',$now_arr['users']))) print '[<a href="forsage.php?id='.$id.'&amp;pass='.$pass.'&amp;mode=4&amp;dbid='.$now_arr['id'].'">'.$lang['for_enjoy'].'</a>]<br/>';
elseif(in_array($id,explode('.',$now_arr['users']))) print '<b>'.$lang['for_you_in_this_g'].'</b><br/>';
}

$pagination = generate_pagination($base_url, $num_items, $per_page, $start);

if(!empty($pagination))print '---<br/>'.$pagination;
    print "<br/>&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass\">".$lang['city1_forsage']."</a><br/>";
    break;

  case "4":

if(empty($tachka))
{
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));

$now_q = mysql_fetch_array(mysql_query("select users from forsage where id='".$dbid."';"));
if(count(explode('.',$now_q['users']))>=5) die($lang['error'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

$userx=explode('.',$now_q['users']);
if(in_array($id,$userx)) die($lang['for_uje'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');


if(!empty($cars))
{
print $lang['for_select'];
$cars_count = explode(".", $cars);
$count_cars=count($cars_count);
print $lang['uv_cars']." <b>($count_cars)</b>:</small><br/>";
print "<select name=\"tachka\">";
for($i=0;$i<$count_cars;$i++)
{
print "<option value=\"".$cars_count[$i]."\">".$cars_count[$i]."</option>"; 
}
print "</select><br/><small>
<anchor>".$lang['ok']."
<go href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=4\" method=\"post\">
<postfield name=\"tachka\" value=\"$(tachka)\"/>
<postfield name=\"dbid\" value=\"$dbid\"/>
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
$dbid=cyr(htmlspecialchars(stripslashes(trim($_POST[dbid]))));

$now_q = mysql_fetch_array(mysql_query("select users from forsage where id='".$dbid."';"));
if(count(explode('.',$now_q['users']))>=5) die($lang['error'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');

$userx=explode('.',$now_q['users']);
if(in_array($id,$userx)) die($lang['for_uje'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');


$n_us=$now_q['users'];
$new_user="$n_us.$id";
mysql_query("update forsage set users='".$new_user."',time='".time()."' where id='".$dbid."';");

if($tachka==$lang['car1']) $mod_power=1;
elseif($tachka==$lang['car2']) $mod_power=2;
elseif($tachka==$lang['car3']) $mod_power=3;
elseif($tachka==$lang['car4']) $mod_power=4;
elseif($tachka==$lang['car5']) $mod_power=5;
elseif($tachka==$lang['car6']) $mod_power=6;
elseif($tachka==$lang['car7']) $mod_power=7;
elseif($tachka==$lang['car8']) $mod_power=8;
if(empty($gonka) || $gonka==0)
mysql_query("insert into forsage_cars values(0,'".$id."','".$dbid."','".$tachka."','".$mod_power."');");
else
mysql_query("update forsage_cars set gonka='".$dbid."',mods='".$mod_power."',car='".$tachka."' where userid='".$id."'");

print $lang['for_now_at_you'].' <b>'.$dbid.'</b>!<br/>';

}

    print "&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass\">".$lang['city1_forsage']."</a><br/>";
    break;

  case "5":

$f_gonki=mysql_fetch_array(mysql_query("select * from forsage where id='".$gonka."';"));

$gid=$f_gonki['id'];
$users=$f_gonki['users'];
$stage=$f_gonki['stage'];
$win=$f_gonki['win'];
$timeg=$f_gonki['time'];

print '['.$lang['for_zaezd'].' <b>'.$gid.'</b>. '.$lang['for_a-tup'].' <b>'.$stage.'</b>]<br/>';

if(count(explode('.',$users))<5) print $lang['for_poka'].' '.count(explode('.',$users)).' '.$lang['for_naberi'].'<br/>';
else
{


$zaezd_arr=mysql_fetch_array(mysql_query("select users from forsage where id='".$gonka."';"));

$gon_users=$zaezd_arr['users'];
$gon_users=explode('.',$gon_users);

for($i=0;$i<count($gon_users);$i++)
{
$nom=$i+1;
$uchastnik=mysql_fetch_array(mysql_query("select login from users where id='".$gon_users[$i]."';"));

$zaezd_q=mysql_fetch_array(mysql_query("select * from forsage_cars where userid='".$gon_users[$i]."' order by mods desc;"));

print '<u>'.$nom.'</u>.'.$uchastnik['login'].' '.$lang['for_na'].' '.$zaezd_q['car'].'. '.$lang['for_sila'].' <b>'.$zaezd_q['mods'].'</b> '.$lang['for_ed'].'<br/>';

$mods_us[]=$zaezd_q['mods'];

}




$mods_us2=array_count_values($mods_us);

if(($mods_us2[0]>1 || $mods_us2[1]>1 || $mods_us2[2]>1 || $mods_us2[3]>1 || $mods_us2[4]>1 || $mods_us2[5]>1) && $timeg>(time()-$vremya_gonki))
print $lang['for_g_prod'];
else
{
rsort($mods_us);
$win_user_id=mysql_fetch_array(mysql_query("select userid from forsage_cars where mods='".$mods_us[0]."' and gonka='".$gid."';"));
$win_user_login=mysql_fetch_array(mysql_query("select login,money,level,cars from users where id='".$win_user_id['userid']."';"));
++$stage;
mysql_query("update forsage set stage='".$stage."',time='".time()."' where id='".$gonka."';");
print '<b>'.$lang['for_win'].' '.$win_user_login['login'].'!</b><br/>';
if($stage<4)print'<b>'.$lang['for_next_stage'].' <u>'.$stage.'</u>!</b><br/>';

$userx_go=explode('.',$users);
for($i=0;$i<count($userx_go);$i++)
{
/*$rand_mods=rand(1,10);*/
mysql_query("update forsage_cars set mods='' where userid='".$userx_go[$i]."';");
}

}

if($stage>3)
{


$userx_g=explode('.',$users);
for($i=0;$i<count($userx_g);$i++)
{
$us_pass=mysql_fetch_array(mysql_query("select pass from users where id='".$userx_g[$i]."';"));
$messaga=$lang['for_you_loser']." <u>".$gonka."</u>! ".$lang['for_you_loser2']."<br/>[<a href=\"./../mes.php?pass=".$us_pass['pass']."&amp;id=".$userx_g[$i]."&amp;dbid=0&amp;mode=del\">".$lang['mes_del']."</a>]";
if($userx_g[$i]!=$win_user_id['userid'])mysql_query("insert into messagi values(0,'0','".$userx_g[$i]."','".$messaga."');");
mysql_query("delete from forsage_cars where userid='".$userx_g[$i]."';");
}

mysql_query("delete from forsage where id='".$gonka."';");
$win_rand=rand(100,50000);
$win_level=rand(1,5);
mysql_query("update users set money='".$win_user_login[money]."'+'".$win_rand."',cars='".$win_user_login[cars].".".$win."',level='".$win_user_login[level]."'+'".$win_level."' where id='".$win_user_id['userid']."';");
print $lang['for_g_full'].' '.$win_user_login['login'].'!<br/> '.$lang['for_viigran'].' '.$win.'! '.$lang['for_takje'].' '.$win_rand.'$$ '.$lang['for_and'].' '.$win_level.' '.$lang['for_ed_avt'].'<br/>';
$us_pass2=mysql_fetch_array(mysql_query("select pass from users where id='".$win_user_id['userid']."';"));
$messaga=$lang['for_you_win']." <u>".$gonka."</u>! ".$lang['for_viigran']." ".$win."! <br/>[<a href=\"./../mes.php?pass=".$us_pass2['pass']."&amp;id=".$win_user_id['userid']."&amp;dbid=0&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'0','".$win_user_id['userid']."','".$messaga."');");
}
}

    print "&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass\">".$lang['city1_forsage']."</a><br/>";
    break;

  case "6":

$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));

if(!intval($dbid) || empty($dbid)) die($lang['error'].'<br/><anchor>'.$lang['back'].'<prev/></anchor></small></p></card></wml>');


$zaezd_arr=mysql_fetch_array(mysql_query("select users from forsage where id='".$dbid."';"));

$gon_users=$zaezd_arr['users'];
$gon_users=explode('.',$gon_users);

print '['.$lang['for_zaezd'].' <b>'.$dbid.'</b>]<br/>';

for($i=0;$i<count($gon_users);$i++)
{
$nom=$i+1;
$uchastnik=mysql_fetch_array(mysql_query("select login from users where id='".$gon_users[$i]."';"));

$zaezd_q=mysql_fetch_array(mysql_query("select * from forsage_cars where userid='".$gon_users[$i]."' order by mods desc;"));

print '<u>'.$nom.'</u>.'.$uchastnik['login'].' '.$lang['for_na'].' '.$zaezd_q['car'].'. '.$lang['for_sila'].' <b>'.$zaezd_q['mods'].'</b> '.$lang['for_ed'].'<br/>';



}




print '&gt;<anchor>'.$lang['back'].'<prev/></anchor><br/>';
    print "&gt;&gt;<a href=\"forsage.php?id=$id&amp;pass=$pass\">".$lang['city1_forsage']."</a><br/>";
    break;



  default:
print "<u>[".$lang['city1_forsage']."]</u><br/>";
if(!empty($cars))
{
print $lang['for_mes'];
if(mysql_num_rows(mysql_query("select id from forsage where id='".$gonka."';"))<1)
print "-<a href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=1\">".$lang['for_create']."</a><br/>";
else
{
print "-<a href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=5\">".$lang['for_see']."</a><br/>";
print "-<a href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=2\">".$lang['for_update']."</a><br/>";
}
print "-<a href=\"forsage.php?id=$id&amp;pass=$pass&amp;mode=3\">".$lang['for_now_sor']."</a><br/>";
}
else
{
print $lang['for_without_cars'];
}
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