<?php



//START TIMER
list($msec, $sec) = explode(chr(32), microtime());
$headtime = $sec + $msec;

//ERROR REPORTING LEVEL
error_reporting(0);

//MySQL
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";
include("cfg.php");
echo '<small>';

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</small></body></html>");
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
die ($lang['empty_login']."</small></body></html>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

//TITLE


@$dbid = intval($_GET['dbid']);
@$mod = $_GET['mod'];

///////////////////////////////////////////////////////
//WML VERSION
///////////////////////////////////////////////////////



echo "<b>Рейтинг кандидатов:</b><br/><br/>";
$sql2 = mysql_query("SELECT * FROM `".$opros."` ORDER BY `golos` DESC;");

if(mysql_affected_rows() == 0)
{
echo "Кандидатов нет!<br/>\n";
}
$sql3 = mysql_query("SELECT SUM(`golos`) FROM `".$opros."`;");
$a = mysql_result($sql3, 0);
while($opr2 = mysql_fetch_array($sql2))
{
$name = $opr2['name'];
$gl = $opr2['golos'];
@$pro = $gl/$a*100;
@$pro = round($pro, 1);

echo "<u>".$name."</u>: <b>".$gl."</b> / <b>".$pro."%</b><br/>";
}
echo "- - -<br/><a href=\"./index.php?id=$id&amp;pass=$pass\">Назад</a><br/>";


//STOP TIMER
list($msec, $sec) = explode(chr(32), microtime());
echo "<small>[".round(($sec + $msec) - $headtime, 5)."]</small><br/>\n";
echo "</small></body></html>";
?>
