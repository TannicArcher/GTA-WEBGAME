<?php
include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select login,band,level,cars,id,pass,money,zav,lsd,ban from users where id='".$id."';");
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
$band=$data['band'];
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


  
print "<b>".$lang['game_city1']."</b><br/>";

switch ($mode) 
{  
  case "kup":
if(mysql_num_rows(mysql_query("select id from osobnyaki where bandname='".$band."';"))>=1) die ($lang['os_uje']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
list($members,$bname,$bmoney)=mysql_fetch_array(mysql_query("select members,name,money from bands where name='".$band."';"));
if(empty($type))
{
print '[<u>'.$lang['area_ag'].'</u>]<br/>';
if(empty($band)) print $lang['os_neuch'];
else
{
if(mysql_num_rows(mysql_query("select id from osobnyaki where bandname='".$band."';"))>=1) die ($lang['os_uje']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
if ($bmoney<=50000) die ($lang['os_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
print $lang['os_from_you_band'].' '.$bname.' '.$bmoney.'$$<br/>';
print $lang['os_predl'];
if($bmoney>50000 && $bmoney<=250000) 
{
print $lang['os_1'];
print "[<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=kup&amp;type=1\">".$lang['ph_kup']."</a>] (50.000 $$)<br/>";
}
if($bmoney>250000 && $bmoney<=750000)
{
print $lang['os_2'];
print "[<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=kup&amp;type=2\">".$lang['ph_kup']."</a>] (250.000 $$)<br/>";
}
if($bmoney>750000)
{
print $lang['os_3'];
print "[<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=kup&amp;type=3\">".$lang['ph_kup']."</a>] (750.000 $$)<br/>";
}
}
}
else
{
if(!intval($type)) die ($lang['error']."</small></p></card></wml>");
if($type==1)
{
if(($bmoney-50000)<=0) die ($lang['os_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
mysql_query("update bands set money='".$bmoney."'-'50000' where name='".$bname."';");
mysql_query("insert into osobnyaki values('','".$bname."','1');");
print $lang['os_yeah'].' 50.000$$!<br/>';

$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
$level_ar=mysql_fetch_array(mysql_query("select level from users where login='".$band_members[$i]."';"));
mysql_query("update users set level='".$level_ar['level']."'+'2' where login='".$band_members[$i]."';");
}

}
elseif($type==2)
{
if(($bmoney-250000)<=0) die ($lang['os_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
mysql_query("update bands set money='".$bmoney."'-'250000' where name='".$bname."';");
mysql_query("insert into osobnyaki values('','".$bname."','2');");
print $lang['os_yeah'].' 250.000$$!<br/>';

$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
$level_ar=mysql_fetch_array(mysql_query("select level from users where login='".$band_members[$i]."';"));
mysql_query("update users set level='".$level_ar['level']."'+'5' where login='".$band_members[$i]."';");
}

}
elseif($type==3)
{
if(($bmoney-750000)<=0) die ($lang['os_no_money']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>");
mysql_query("update bands set money='".$bmoney."'-'750000' where name='".$bname."';");
mysql_query("insert into osobnyaki values('','".$bname."','3');");
print $lang['os_yeah'].' 750.000$$!<br/>';

$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
$level_ar=mysql_fetch_array(mysql_query("select level from users where login='".$band_members[$i]."';"));
mysql_query("update users set level='".$level_ar['level']."'+'10' where login='".$band_members[$i]."';");
}

}
else die ($lang['error']."</small></p></card></wml>");
}

    print "&gt;<a href=\"osobnyaki.php?id=$id&amp;pass=$pass\">".$lang['el_2avenu']."</a><br/>";
    break;


  case "see":

include './../functions/func_pagination.php';

$start = ( isset($HTTP_GET_VARS['start']) ) ? intval($HTTP_GET_VARS['start']) : 0;
$base_url="osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=see&amp;start=";
$num_items=mysql_num_rows(mysql_query("select id from osobnyaki;"));

print '<u>['.$lang['os_obnyaki'].']</u><br/>';

if(mysql_num_rows(mysql_query("select id from osobnyaki where bandname='".$band."';"))>=1) 
print str_replace('$','$$','<a href="osobnyaki.php?id='.$id.'&amp;pass='.$pass.'&amp;mode=my">'.$lang['os_obnyak'].' '.$band.'</a><br/>');


$i=0;
$now_q = mysql_query("select bandname,type from osobnyaki order by id desc limit $start,$per_page_o;"); 
if(mysql_num_rows($now_q)<1) print $lang['os_no_os'];
while($now_arr=mysql_fetch_array($now_q))
{
++$i;
$nom=$i+$start;
if($now_arr['type']==1) $znak='<b>+</b>';
elseif($now_arr['type']==2) $znak='<b>*</b>';
elseif($now_arr['type']==3) $znak='<b>!</b>';
print str_replace('$','$$','<u>'.$nom.'</u>.<a href="../bands/viewband.php?id='.$id.'&amp;pass='.$pass.'&amp;band='.urlencode($now_arr['bandname']).'">'.$now_arr['bandname'].'</a> '.$znak.'<br/>');

}

$pagination = generate_pagination($base_url, $num_items, $per_page_o, $start);

if(!empty($pagination))print '---<br/>'.$pagination;
    print "<br/>&gt;<a href=\"osobnyaki.php?id=$id&amp;pass=$pass\">".$lang['el_2avenu']."</a><br/>";
    break;

  case "my":

list($bname,$type)=mysql_fetch_array(mysql_query("select bandname,type from osobnyaki where bandname='".$band."';"));
list($members,$bname,$boss,$bmoney)=mysql_fetch_array(mysql_query("select members,name,boss,money from bands where name='".$band."';"));

if(empty($type))die ($lang['error']."</small></p></card></wml>");

if($type==1) $znak='<b>+</b>';
elseif($type==2) $znak='<b>*</b>';
elseif($type==3) $znak='<b>!</b>';

print '[<u>'.$bname.'</u> '.$znak.']<br/>';

print $lang['os_mes'];

if(!empty($obed))
{
$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
mysql_query("update users set golod='150' where login='".$band_members[$i]."';");
}
print $lang['os_golod'];

$rand=rand(1,500);
if(($bmoney-$rand)<=0) $rand=$bmoney;
mysql_query("update bands set money='".$bmoney."'-'".$rand."' where name='".$band."';");
print '<b>'.$lang['os_nalog'].' '.$rand.'$$</b><br/>';
}
if(!empty($vrach))
{
if($type!=2 && $type!=3)die ($lang['error']."</small></p></card></wml>");
$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
mysql_query("update users set health='150' where login='".$band_members[$i]."';");
}
print $lang['os_health'];

$rand=rand(1,500);
if(($bmoney-$rand)<=0) $rand=$bmoney;
mysql_query("update bands set money='".$bmoney."'-'".$rand."' where name='".$band."';");
print '<b>'.$lang['os_nalog'].' '.$rand.'$$</b><br/>';

}
if(!empty($grim))
{
if($type!=3)die ($lang['error']."</small></p></card></wml>");
$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
mysql_query("update users set police='0' where login='".$band_members[$i]."';");
}
print $lang['os_police'];

$rand=rand(1,500);
if(($bmoney-$rand)<=0) $rand=$bmoney;
mysql_query("update bands set money='".$bmoney."'-'".$rand."' where name='".$band."';");
print '<b>'.$lang['os_nalog'].' '.$rand.'$$</b><br/>';

}
if(!empty($voodoo))
{
if($type!=3)die ($lang['error']."</small></p></card></wml>");
$band_members = explode(".", $members);
$count_members=count($band_members);
for($i=0;$i<$count_members;$i++)
{
mysql_query("update users set voodoo='' where login='".$band_members[$i]."';");
}
print $lang['os_voodoo'];

$rand=rand(1,500);
if(($bmoney-$rand)<=0) $rand=$bmoney;
mysql_query("update bands set money='".$bmoney."'-'".$rand."' where name='".$band."';");
print '<b>'.$lang['os_nalog'].' '.$rand.'$$</b><br/>';

}
if(!empty($sale))
{
if($boss!=$login) die ($lang['error']."</small></p></card></wml>");

$rand=rand(1000,50000);
mysql_query("update bands set money='".$bmoney."'+'".$rand."' where name='".$band."';");

mysql_query("delete from osobnyaki where bandname='".$band."';");
print $lang['os_saled'].' '.$rand.'$$!<br/>';
}

    print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=my&amp;obed=1\">".$lang['os_obed']."</a><br/>";
    if($type==2 || $type==3)
    print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=my&amp;vrach=1\">".$lang['os_vrach']."</a><br/>";
    if($type==3)
{
    print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=my&amp;grim=1\">".$lang['os_grim']."</a><br/>";
    print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=my&amp;voodoo=1\">".$lang['os_prokl']."</a><br/>";
}
    if($boss==$login)
print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=my&amp;sale=1\">".$lang['os_sale_boss']."</a><br/>";
   
 print "&gt;<a href=\"osobnyaki.php?id=$id&amp;pass=$pass\">".$lang['el_2avenu']."</a><br/>";
    break;



  default:
print "<u>[".$lang['el_2avenu']."]</u><br/>";
print $lang['os_enter'];
print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=kup\">".$lang['os_nedvij']."</a><br/>";
print "-<a href=\"osobnyaki.php?id=$id&amp;pass=$pass&amp;mode=see\">".$lang['os_obnyaki']."</a><br/>";

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