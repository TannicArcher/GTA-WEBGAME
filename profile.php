<?php
include "ini3.php";
include "includes/header2.php";
include "includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$login=cyr(htmlspecialchars(stripslashes(trim($login))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($login)) 
{  
$q = mysql_query("select pass,id,login,mobile,about,email,pol from users where login='".cyr($login)."';");
}
elseif(!empty($id)) 
{
$q = mysql_query("select pass,id,login,mobile,about,email,pol from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</body>
</html>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$mobile=$data['mobile'];
$about=$data['about'];
$mail=$data['email'];
$pol=$data['pol'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");


switch ($mode) 
{  
  case "save":

if($newpass!=$newpass2)
{
print $lang['reg_error_pass']."<br/>";
echo "<a href='javascript:history.back(1)'>".$lang['back']."</a><br/></body>
</html>";
exit;
}
if (ereg("[а-яА-Я,$,>,<,',;,/,\,&,#,,,.,:,*,@,!,%,^,(,)]","$newpass$login$newpass2"))
{
print $lang['reg_bad_symbols']."<br/>";
echo "<a href='javascript:history.back(1)'>".$lang['back']."</a><br/></body>
</html>";
exit;
}

$newpass=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newpass)))));
$newpass2=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newpass2)))));
$newemail=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newemail)))));
$newmobile=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newmobile)))));
$newabout=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newabout)))));
$newnums=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newnums)))));
$newpol=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newpol)))));

mysql_query("update users set pass='".$newpass."',email='".$newemail."',mobile='".$newmobile."',about='".$newabout."',nums='".$newnums."',pol='".$newpol."' where id='".$id."';");
print $lang['profile_refreshed'];

$pass=$newpass;

    break;
  default:
  echo "<form action=\"profile.php?id=$id&amp;pass=$pass&amp;mode=save\" method=\"post\">

<postfield name=\"newpass\" value=\"$(newpass)\"/>
<postfield name=\"newpass2\" value=\"$(newpass2)\"/>
<postfield name=\"newemail\" value=\"$(newemail)\"/>
<postfield name=\"newmobile\" value=\"$(newmobile)\"/>
<postfield name=\"newstatus\" value=\"$(newstatus)\"/>
<postfield name=\"newabout\" value=\"$(newabout)\"/>
<postfield name=\"newnums\" value=\"$(newnums)\"/>
<postfield name=\"newpol\" value=\"$(newpol)\"/>";
print $lang['profile_pass'].":<br/>";

print "<input name=\"newpass\"  value=\"$pass\" maxlength=\"15\"/><br/>";
print "".$lang['profile_pass2'].":<br/>";
print "<input name=\"newpass2\" value=\"$pass\" maxlength=\"15\"/><br/>";
print "".$lang['reg_mail'].":<br/>";
print "<input name=\"newemail\"  value=\"$mail\"/><br/>";
print "".$lang['regmobile'].":<br/>";
print "<input value=\"$mobile\" name=\"newmobile\"/><br/>";

print "".$lang['regabout'].":<br/>";
print "<input value=\"$about\" name=\"newabout\"/><br/>";
print "".$lang['regonline'].":<br/>";
print "<select name=\"newnums\">
<option value=\"5\">5</option>
<option value=\"10\">10</option>
</select><br/>";
echo "Ваш пол:<br /><select name='newpol'>
<option value='1'>Мужской</option>
<option value='0'>Женский</option>
</select><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/>";
    echo "</form>";
  break;
}


print "<br/><a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
echo "</body>
</html>";
?>