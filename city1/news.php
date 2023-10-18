<?php
error_reporting(0);
include "./../ini2.php";
include "./../includes/inc_online.php";
print "<p><small>";

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
die ($lang['empty_login']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$status=$data['status'];
$reg_data=$data['reg_data'];
$money=$data['money'];
$level=$data['level'];
$admin=$data['admin'];
if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");


echo "<div class=\"pt\"><center>Газета Gangsters-Times</center></div>";
echo "<div class=\"main\"><div class=\"in\">";
$all = mysql_num_rows(mysql_query("SELECT * FROM rnews"));
if(isset($_GET['s'])){$s=intval($_GET['s']);}else{$s=0;}
if($s<0) $s=0;
if($s>$all) $s=0;
$c=$s+1;
$asd = mysql_query("SELECT title, login, text, time FROM rnews ORDER BY id DESC LIMIT ".$s.", 10");
while($dsa = mysql_fetch_array($asd))
{
$i2 = $i++;
$title = strip_tags($dsa['title']);
$text = strip_tags($dsa['text']);
$login = strip_tags($dsa['login']);
$time = strip_tags($dsa['time']);

echo "<b>$title</b><small>[".($time)."]</b></small><br/>$text<br/>Добавил: <b>$login</b><br/>------<br/>";
}
if($all>0)
{
$ba=ceil($all/10);
$ba2=$ba*10-10;
echo "Страницы:";
$asd=$s-(10*3);
$asd2=$s+(10*4);
if($asd<$all && $asd>0){echo ' <a href="news.php?id='.$id.'&amp;pass='.$pass.'&amp;start=0&r='.$rand.'">1</a> .. ';}
for($i=$asd; $i<$asd2;)
{
if($i<$all && $i>=0)
{
$ii=floor(1+$i/10);
if($s==$i)
{
echo ' '.$ii;
}
else
{
echo ' <a href="news.php?id='.$id.'&amp;pass='.$pass.'&amp;s='.$i.'&r='.$rand.'">'.$ii.'</a>';
}
}
$i=$i+10;
}
if($asd2<$all){echo ' .. <a href="news.php?id='.$id.'&amp;pass='.$pass.'&amp;s='.$ba2.'&r='.$rand.'">'.$ba.'</a>';}
}
echo "<br><a href=\"index.php?id=$id&pass=$pass\">В город</a>";

$set['title']='Новости'; 





mysql_close();

?>