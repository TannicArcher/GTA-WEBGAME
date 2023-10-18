<?php
###########################################################################
##                         -=Lesnik=-                                    ##
##                       ---------------                                 ##
##                   http://wenz.net.ru                                  ##
##                           *-*-*-*                                     ##
##                                                                       ##
##                      ICQ: 366-244-181                                 ##
##                          - - - - -                                    ##
##                 Скрипт: Голосований для игры ГТА                      ##
##                          - - - - -                                    ##
###########################################################################

//START TIMER
list($msec, $sec) = explode(chr(32), microtime());
$headtime = $sec + $msec;

//ERROR REPORTING LEVEL


//MySQL
include "./../../ini.php";

include "./../../includes/inc_online.php";
include("./../cfg.php");
$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id)) 
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban,admin from users where id='".$id."';");
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
$admin=$data['admin'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");
if($admin==7)
{

//TITLE
$title = "Админка";

///////////////////////////////////////////////////////
//WML VERSION
///////////////////////////////////////////////////////

header("Content-type: text/vnd.wap.wml; charset=utf-8");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-relative");

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.3//EN' 'http://www.wapforum.org/DTD/wml13.dtd'><wml>\n";
echo "<head><meta http-equiv='Cache-Control' content='no-cache' forua='true'/></head>\n";
echo "<card id='catalogue' title='".$title."'>\n<p align='left'><small>\n";

	
$sql2 = mysql_query("SELECT * FROM `".$opros."` ORDER BY `golos` DESC;");
if(mysql_affected_rows() == 0)
{
echo "Контендентов нет!<br/>\n";
}
$sql3 = mysql_query("SELECT SUM(`golos`) FROM `".$opros."`;");
$a = mysql_result($sql3, 0);
while($opr2 = mysql_fetch_array($sql2))
{
$id=$data['id'];
$dbid = $opr2['dbid'];
$name = $opr2['name'];
$gl = $opr2['golos'];
@$pro = $gl/$a*100;
@$pro = round($pro, 1);

echo "<u>".$name."</u>: <b><a href=\"./edit_golos.php?id=$id&amp;pass=$pass&amp;dbid=".$dbid."\">".$gl."</a></b> / <b>".$pro."%</b> <a href=\"./del.php?id=$id&amp;pass=$pass&amp;dbid=".$dbid."\">X</a><br/>";
}

echo "- - -<br/><a href=\"./add.php?id=$id&amp;pass=$pass\">Добавить кондидата</a><br/>";
echo "<a href=\"./clear.php?id=$id&amp;pass=$pass\">Очистить голоса</a><br/>";

//STOP TIMER
list($msec, $sec) = explode(chr(32), microtime());
echo "<small>[".round(($sec + $msec) - $headtime, 5)."]</small><br/>\n";
}
if($admin!=7)
{
$title = "Админка";

///////////////////////////////////////////////////////
//WML VERSION
///////////////////////////////////////////////////////

header("Content-type: text/vnd.wap.wml; charset=utf-8");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-relative");

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.3//EN' 'http://www.wapforum.org/DTD/wml13.dtd'><wml>\n";
echo "<head><meta http-equiv='Cache-Control' content='no-cache' forua='true'/></head>\n";
echo "<card id='catalogue' title='".$title."'>\n<p align='left'><small>\n";

echo "Ты не админ!<br/>\n";	
}
echo "</small></p></card></wml>";

?>
