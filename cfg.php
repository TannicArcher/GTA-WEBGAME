<?
###########################
#  Данная версия скрипта принадлежит       # 
#       LiraS aka Артур Лукин Иванович          #
#   Вносить свои изменения крайне               #
#                 запрещенно!                                    #
###########################
require 'functions.php';
if (isset($_GET['usr']))
{
$_GET['usr'] = stringg($_GET['usr']);
}
if (isset($_GET['pwd']))
{
$_GET['pwd'] = stringg($_GET['pwd']);
}
if (isset($_GET['v']))
{
$_GET['v'] = htmlspecialchars(stripslashes(trim($_GET['v'])));
}
function vremya($time)
{
$tim = date("d.m.y", $time);

return $tim;
}
function news_time($time)
{
$tim = date("d.m.y H:i", $time);
return $tim;
}
function chat($time)
{
$tim = date("d.m H:i",$time);
return $tim;
}

function vremja($time=NULL,$times=NULL)
{
global $set;
$timesdvig=$set['timesdvig'];
if ($time==NULL)$time=time();
if ($times==NULL)$time=$time+$timesdvig;
else $time=$time+intval($times);
$timep="".date("j M Y в H:i", $time)."";
$time_p[0]=date("j n Y", $time);
$time_p[1]=date("H:i", $time);
if ($time_p[0]==date("j n Y", time()+$timesdvig))$timep="сегодня в $time_p[1]";
if ($time_p[0]==date("j n Y", time()+$timesdvig-86400))$timep="вчера в $time_p[1]";
$timep=str_replace("Jan","01",$timep);
$timep=str_replace("Feb","02",$timep);
$timep=str_replace("Mar","03",$timep);
$timep=str_replace("May","04",$timep);
$timep=str_replace("Apr","05",$timep);
$timep=str_replace("Jun","06",$timep);
$timep=str_replace("Jul","07",$timep);
$timep=str_replace("Aug","08",$timep);
$timep=str_replace("Sep","09",$timep);
$timep=str_replace("Oct","10",$timep);
$timep=str_replace("Nov","11",$timep);
$timep=str_replace("Dec","12",$timep);
return $timep;
}
function otdih($time)
{
$timeo = date("i|s", $time);
$tim = explode("|", $timeo);
$t = "$tim[0] минут $tim[1] секунд";
return $t;
}
function pochta()
{
$q = mysql_query("SELECT COUNT(*) FROM `msg_r` WHERE `user_to` = '".mysql_real_escape_string($_GET['usr'])."' AND `read` = '1';");
$new_mail = mysql_result($q, 0);
if ($new_mail>0)
{
echo "<font color=\"green\"><big><b><a href=\"msg.php?usr=$_GET[usr]&amp;pwd=$_GET[pwd]&amp;id=read\">У вас сообщение!</a>[$new_mail]</b></big></font><br/>";
}
}

function head($title=NULL)
{
# Глобал set
global $set,$exist;
if ($title==NULL) $title=$set['title'];
if (empty($_GET['usr']))
{
if (isset($_GET['v']) && $_GET['v'] == 'xhtml' || isset($_GET['v']) && $_GET['v'] != 'web')
{
require 'themes/1/head.php';
} elseif (isset($_GET['v']) && $_GET['v'] == 'web')
{
require 'themes/2/head.php';
}
} elseif ($exist == 1)
{
$u = mysql_fetch_array(mysql_query("SELECT `id` FROM `users` WHERE `usr` = '".mysql_real_escape_string($_GET['usr'])."'"));
$id = strip_tags($u['id']);
$d = mysql_fetch_array(mysql_query("SELECT `design` FROM `settings` WHERE `u_id` = '".mysql_real_escape_string($id)."'"));
$design = strip_tags($d['design']);
###################################
if ($design == 0 or $design == null)
{
require 'themes/1/head.php';
} elseif ($design != 0 and is_file("themes/".$design."/head.php"))
{
require "themes/".$design."/head.php";
}
} else
{
require 'themes/1/head.php';
}
}
function foot()
{

global $usr,$exist;

if (empty($usr) or $exist == 0)
{
if (isset($_GET['v']))
{
if ($_GET['v'] == '' OR $_GET[v] == 'xhtml' || isset($_GET['v']))
{
require "themes/1/foot.php";
}
elseif ($_GET['v'] == 'web')
{
require "themes/2/foot.php";
}
} else
{
require "themes/1/foot.php";
}
}elseif (isset($usr) && $diz > 0)
{
$u = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE usr = '".mysql_real_escape_string($_GET['usr'])."'"));
$id = $u['id'];
$diz = mysql_num_rows(mysql_query("SELECT * FROM settings WHERE u_id = '".mysql_real_escape_string($id)."'"));
$t = mysql_fetch_array(mysql_query("SELECT design FROM settings WHERE u_id = '".mysql_real_escape_string($id)."'"));
require "themes/$t[design]/foot.php";
}
}
function foot_main()
{
$diz = mysql_num_rows(mysql_query("SELECT * FROM users WHERE usr = '".mysql_real_escape_string($_GET['usr'])."'"));
if (empty($_GET['usr']))
{
if (isset($_GET['v']))
{
if ($_GET['v'] == '' OR $_GET['v'] == 'xhtml')
{
require "themes/1/foot_main.php";
}
elseif ($_GET['v'] == 'web')
{
require "themes/2/foot_main.php";
}
} else
{
require "themes/1/foot_main.php";
}
}elseif (isset($_GET['usr']) && $diz > 0)
{
$t = mysql_fetch_array(mysql_query("SELECT design FROM settings WHERE user = '".mysql_real_escape_string($_GET['usr'])."'"));
require "themes/$t[design]/foot_main.php";
}
}
function title($msg = NULL,$img = NULL) // Загловок страницы
{
if (!isset($_SESSION['web']) || $_SESSION['web']==0)
{
global $set;
if ($msg=='no' || $msg=='notitle' || $msg=='not')$msg=NULL;
elseif ($msg==NULL || $msg=='default' || $msg=='DEFAULT')$msg=$set['welcome'];


if ($img!=NULL && $msg!=NULL)$img.="<br />\n";

echo "<div class=\"title\"></div>";
}
}
function ban()
{
$u = mysql_fetch_array(mysql_query("SELECT id FROM users WHERE usr = '".mysql_real_escape_string($_GET['usr'])."'"));
$ban = mysql_num_rows(mysql_query("SELECT * FROM ban WHERE user_id = '".mysql_real_escape_string($u['id'])."'"));
$bn = mysql_fetch_array(mysql_query("SELECT * FROM ban WHERE user_id = '".mysql_real_escape_string($u['id'])."'"));
$times = time();
echo "<div class=\"main\"><div class=\"in\">";
if ($ban > 0 && $times<$bn['time'])
{
echo "Вы в бане!<br/>\n";
$who = iconv("windows-1251","utf-8",$bn['who']);
$why = iconv("windows-1251","utf-8",$bn['why']);
echo "Забанил: $who <br/>\n";
echo "Причина: $why <br/>\n";
echo "До: ".vremja($bn[time])." <br/>\n";
$r = rand(10000,999999);
echo "<a href=\"main.php?usr=$_GET[usr]&amp;pwd=$_GET[pwd]&amp;rand=$r\">назад</a><br/>\n"; 
}
elseif ($times >= $bn['time'])
{
mysql_query("DELETE FROM ban WHERE user_id = '$u[id]'");
echo "Вы успешно вышли из бана<br/>\n<a href=\"main.php?usr=$_GET[usr]&amp;pwd=$_GET[pwd]\">в игру</a>";
}
foot();
exit();
}

?>