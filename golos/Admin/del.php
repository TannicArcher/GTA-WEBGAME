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

//REPORTING LEVEL
error_reporting(0);

//CONNECTION
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
define("TITLE", "Удаление");

header("Content-type: text/vnd.wap.wml; charset=utf-8");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-relative");

echo "<?xml version='1.0' encoding='UTF-8'?>\n";
echo "<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.3//EN' 'http://www.wapforum.org/DTD/wml13.dtd'><wml>\n";
echo "<head><meta http-equiv='Cache-Control' content='no-cache' forua='true'/></head>\n";
echo "<card id='del_news' title='".TITLE."'><p align='left'>\n";

$sql = mysql_query("DELETE FROM `".$opros."` WHERE `dbid` = ".intval($_GET['dbid']).";");

if(mysql_affected_rows() == 0)
{
echo "Контендент не найден!<br />\n";
}
else
{
mysql_query("DELETE FROM `".$gols."` WHERE `dbid` = ".intval($_GET['dbid']).";");
echo "Контендент удалён!<br />\n";
}

echo "<a href='./index.php?id=$id&amp;pass=$pass'>Админ-панель</a><br/>\n";
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
