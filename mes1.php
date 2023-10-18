<?php
include "ini3.php";
include "includes/header2.php";
include "includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET[dbid]))));


if(!empty($id)) 
{
$q = mysql_query("select id,login,pass from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</body>
</html>");
}

if($dbid!=0)
{
if(!empty($dbid)) 
{
$qdb = mysql_query("select id,login,pass from users where id='".$dbid."';");
}
else
{
die ($lang['select_user_false']."</body>
</html>");
}
}
$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];

if($dbid!=0)
{
$dbdata = mysql_fetch_array($qdb);
$dblogin=$dbdata['login'];
$dbpass=$dbdata['pass'];
}

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}



mysql_query("update users set last='".time()."',city='0' where id='".$id."';");


switch ($mode)
{




  case "del":

  	mysql_query("delete from messagi where kto='".$dbid."' and komu='".$id."' limit 1;");
    print $lang['mes_deleted']."<br/>";
    break;

  case "reply":

    mysql_query("DELETE FROM messagi WHERE kto='".$dbid."' and komu='".$id."' limit 1;");


    if(!empty($a))
{ $id=cyr(htmlspecialchars(stripslashes(trim($_GET['id']))));
$pass=cyr(htmlspecialchars(stripslashes(trim($_GET['pass']))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_GET['dbid']))));
$mode=htmlspecialchars($_POST['mode']);

if(empty($messaga)) print $lang['mes_empty']."<br/>";
else
{
$predl_que=mysql_query("select komu from messagi where kto='$id' and komu='$dbid';");
$predl_data = mysql_fetch_array($predl_que);
if(!empty($predl_data['komu'])) print $lang['patience']."<br/>";
else
{
print $lang['mes_succes1']." $dblogin ".$lang['mes_succes2']."<br/>";

$messaga=htmlspecialchars(stripslashes(trim($_POST['messaga'])));
$messaga="<b>".$lang['mes_mes1']." $login:</b><br/>".$messaga."<br/>[<a href=\"./../mes1.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=reply\">".$lang['mes_reply']."</a>/<a href=\"./../mes1.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
}
}
}
else
{
echo "<form action=\"mes.php?id=$id&amp;dbid=$dbid&amp;pass=$pass&amp;mode=save\" method=\"post\">
<postfield name=\"messaga\" value=\"$(messaga)\"/>";
print $lang['mes_for']." <b>$dblogin</b>:";
print "<br/>";
print "<input name=\"messaga\" type=\"text\"/><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/>";
echo "</form>";
}
    break;
  default:
    print $lang['mes_empty']."<br/></body>
</html>";
    exit;
  break;
case "save":
if ($_POST['messaga'] != "" && $_POST['dbid'] != "")
{
$id=cyr(htmlspecialchars(stripslashes(trim($_POST['id']))));
$pass=cyr(htmlspecialchars(stripslashes(trim($_POST['pass']))));
$dbid=cyr(htmlspecialchars(stripslashes(trim($_POST['dbid']))));
$mode=htmlspecialchars($_POST['mode']);
// Если все норм сохраняем в базе!
// Чтобы злоумышленик херней не страдал!
if (isset($_POST['messaga']))
{
$messaga = htmlspecialchars(stripslashes($_POST['messaga']));
}

print $lang['mes_succes1']." $dblogin ".$lang['mes_succes2']."<br/>";

$messaga="<b>".$lang['mes_mes1']." $login:</b><br/>".$messaga."<br/>[<a href=\"./../mes1.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=reply\">".$lang['mes_reply']."</a>/<a href=\"./../mes1.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
}


else
{


print $lang['mes_succes1']." $dblogin ".$lang['mes_succes2']."<br/>";

$messaga="<b>".$lang['mes_mes1']." $login:</b><br/>".$messaga."<br/>[<a href=\"./../mes1.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=reply\">".$lang['mes_reply']."</a>/<a href=\"./../mes1.php?pass=$dbpass&amp;id=$dbid&amp;dbid=$id&amp;mode=del\">".$lang['mes_del']."</a>]";
mysql_query("insert into messagi values(0,'$id','$dbid','$messaga');");
}


}






echo "<a href='javascript:history.back(1)'>".$lang['back']."</a><br/>";

print "&gt;&gt;<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a><br/>";

mysql_close();
print "</body>
</html>";
?>