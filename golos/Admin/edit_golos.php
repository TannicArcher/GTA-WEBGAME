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
error_reporting(0);

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
$title = "Edit";

@$dbid = intval($_GET['dbid']);
@$mod = $_GET['mod'];
///////////////////////////////////////////////////////
//WML VERSION
///////////////////////////////////////////////////////

header("Content-type: text/vnd.wap.wml; charset=utf-8");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-relative");

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.3//EN' 'http://www.wapforum.org/DTD/wml13.dtd'><wml>\n";
echo "<head><meta http-equiv='Cache-Control' content='no-cache' forua='true'/></head>\n";
echo "<card id='catalogue' title='".$title."'>\n<p align='left'>\n";
if (empty($mod)) $mod="index";
switch ($mod) {
case "index";

$sql = mysql_query("SELECT `name`, `golos` FROM `".$opros."` WHERE `dbid` = '".$dbid."';");
if(mysql_affected_rows() == 0) echo "<b>Ошибка!</b><br />\n";
while($sa = mysql_fetch_row($sql)) {

echo "<u>".$sa[0]."</u><br/>- - -<br/>\n";
echo "Голосов: ".$sa[1]."<br/>\n";
echo '<input type="text" name="golos" maxlength="10" value="'.$sa[1].'"/><br/>';
echo "<anchor title=\"send\">Сохранить<go href=\"./edit_golos.php?id=$id&amp;pass=$pass&amp;mod=edit&amp;dbid=".$dbid."\" method=\"post\">";
echo "<postfield name=\"golos\" value=\"$(golos)\"/>";
echo "</go></anchor><br/>";
}

break;

case "edit";

$golos = intval($_POST['golos']);

$sql = mysql_query("UPDATE `".$opros."` SET `golos` = '".$golos."' WHERE `dbid` = '".$dbid."';");
if(mysql_affected_rows() == 0)
{
echo "Кондидат не найден!<br />\n";
}
else
{
echo "Изменено!Мухлюем?=)<br />\n";
}
break;
}
echo "- - -<br/><a href='./index.php?id=$id&amp;pass=$pass'>Админ-панель</a><br/>\n";
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
echo "</p></card></wml>";
?>
