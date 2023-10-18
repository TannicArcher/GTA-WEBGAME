<?php
include "ini.php";
include "includes/header.php";
include "includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$login=cyr(htmlspecialchars(stripslashes(trim($login))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($login)) 
{  
$q = mysql_query("select pass,id,login,mobile,about,email from users where login='".cyr($login)."';"); 
}
elseif(!empty($id)) 
{
$q = mysql_query("select pass,id,login,mobile,about,email from users where id='".$id."';"); 
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$mobile=$data['mobile'];
$about=$data['about'];
$mail=$data['email'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</small></p></card></wml>");
}

mysql_query("update users set last='".time()."',city='0' where id='".$id."';");


switch ($mode) 
{  
  case "save":

if($newpass!=$newpass2)
{
print $lang['reg_error_pass']."<br/>";
print "<anchor>".$lang['again']."<prev/></anchor></small></p></card></wml>";
exit;
}
if (ereg("[à-ÿÀ-ß,$,>,<,',;,/,\,&,#,,,.,:,*,@,!,%,^,(,)]","$newpass$login$newpass2"))
{
print $lang['reg_bad_symbols']."<br/>";
print "<anchor>".$lang['again']."<prev/></anchor></small></p></card></wml>";
exit;
}

$newpass=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newpass)))));
$newpass2=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newpass2)))));
$newemail=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newemail)))));
$newmobile=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newmobile)))));
$newabout=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newabout)))));
$newnums=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$newnums)))));

mysql_query("update users set pass='".$newpass."',email='".$newemail."',mobile='".$newmobile."',about='".$newabout."',nums='".$newnums."' where id='".$id."';");
print $lang['profile_refreshed'];

$pass=$newpass;

    break;
  default:
print $lang['profile_pass'].":</small><br/>";
print "<input name=\"newpass\"  value=\"$pass\" maxlength=\"15\"/><br/>";
print "<small>".$lang['profile_pass2'].":</small><br/>";
print "<input name=\"newpass2\" value=\"$pass\" maxlength=\"15\"/><br/>";
print "<small>".$lang['reg_mail'].":</small><br/>";
print "<input name=\"newemail\"  value=\"$mail\"/><br/>";
print "<small>".$lang['regmobile'].":</small><br/>";
print "<input value=\"$mobile\" name=\"newmobile\"/><br/>";

print "<small>".$lang['regabout'].":</small><br/>";
print "<input value=\"$about\" name=\"newabout\"/><br/>";
print "<small>".$lang['regonline'].":</small><br/>";
print "<select name=\"newnums\">
<option value=\"5\">5</option>
<option value=\"10\">10</option>
<option value=\"15\">15</option>
<option value=\"20\">20</option>
<option value=\"25\">25</option>
<option value=\"30\">30</option>
<option value=\"50\">50</option>
</select><br/>";
print "<small><anchor>".$lang['ok']."
<go href=\"profile.php?id=$id&amp;pass=$pass\" method=\"post\">
        <postfield name=\"mode\" value=\"save\"/>
<postfield name=\"newpass\" value=\"$(newpass)\"/>
<postfield name=\"newpass2\" value=\"$(newpass2)\"/>
<postfield name=\"newemail\" value=\"$(newemail)\"/>
<postfield name=\"newmobile\" value=\"$(newmobile)\"/>
<postfield name=\"newstatus\" value=\"$(newstatus)\"/>
<postfield name=\"newabout\" value=\"$(newabout)\"/>
<postfield name=\"newnums\" value=\"$(newnums)\"/>
</go>
</anchor>";
  break;
}


print "<br/><a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
print "</small></p></card></wml>";
?>