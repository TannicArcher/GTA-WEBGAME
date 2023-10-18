<?
Error_Reporting(E_ALL & ~E_NOTICE);
include "ini.php";
include "includes/header.php";

print "<p><small>";

if(empty($login) || empty($pass) || empty($pass2))
{
print $lang['regheader']."<br/>";
print $lang['regimportant']."!<br/>";
print $lang['regname']."*:</small><br/>";
print "<input name=\"login\" value=\"$login\" maxlength=\"15\"/><br/>";
print "<small>".$lang['regpass']."*:</small><br/>";
print "<input name=\"pass\"  value=\"$pass\" maxlength=\"15\"/><br/>";
print "<small>".$lang['reg_confirm_pass']."*:</small><br/>";
print "<input name=\"pass2\" value=\"$pass2\" maxlength=\"15\"/><br/>";
print "<small>".$lang['reg_mail'].":</small><br/>";
print "<input name=\"email\"  value=\"$mail\"/><br/>";
print "<small>".$lang['regmobile'].":</small><br/>";
$_SERVER["HTTP_USER_AGENT"];
print "<small>".$lang['regabout'].":</small><br/>";
print "<input value=\"$about\" name=\"about\"/><br/>";
print "<small>".$lang['regonline'].":</small><br/>";
print "<select name=\"nums\">
<option value=\"10\">10</option>
<option value=\"15\">15</option>
<option value=\"20\">20</option>
<option value=\"25\">25</option>
<option value=\"30\">30</option>
</select><br/>";
print "<small><anchor>".$lang['ok']."
<go href=\"reg.php\" method=\"post\">
        <postfield name=\"login\" value=\"$(login)\"/>
<postfield name=\"pass\" value=\"$(pass)\"/>
<postfield name=\"pass2\" value=\"$(pass2)\"/>
<postfield name=\"email\" value=\"$(email)\"/>
<postfield name=\"mobile\" value=\"$(mobile)\"/>
<postfield name=\"about\" value=\"$(about)\"/>
<postfield name=\"nums\" value=\"$(nums)\"/>
</go>
</anchor>";
}
else
{
if($pass!=$pass2)
{
print $lang['reg_error_pass']."<br/>";
print "<anchor>".$lang['again']."<prev/></anchor></small></p></card></wml>";
exit;
}
if (ereg("[�-��-�,А,Б,В,$,>,<,',;,/,\,&,#,,,.,:,*,@,!,%,^,(,)]","$pass$login$pass2"))
{
print $lang['reg_bad_symbols']."<br/>";
print "<anchor>".$lang['again']."<prev/></anchor></small></p></card></wml>";
exit;
}

$login=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$login)))));
$login=substr($login,0,20);
$pass=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$pass)))));
$pass2=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$pass2)))));
$email=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$email)))));
$mobile=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$mobile)))));
$about=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$about)))));
$nums=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$nums)))));

$query_users_login_reg = mysql_query("select login,pass from users where login='".$login."';");
$users_login_reg = mysql_fetch_array($query_users_login_reg);

if(!empty($users_login_reg['login']))
{
die
($lang['already_reg']."<br/>
<anchor>".$lang['again']."<prev/></anchor>
</small></p></card></wml>");
}
else
{
$reg_data=date("G:j.n.y");
mysql_query("insert into users values(0,'$login','$pass','$mobile','$email','$about','".$lang['reg_default_status']."','$reg_data','100','','','100','','".time().".0','','','".$nums."','','100','','0');");
$query_users = mysql_query("select id,pass from users where login='".$login."';");
$users_login = mysql_fetch_array($query_users);
$id = $users_login['id'];
$pass = $users_login['pass'];
print "Регистрация прошла успешно!<br/> Ваш логин: <b>$login</b><br/>Пароль: <b>$pass</b><br/>";
print "<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['reg_in_game']."</a>";
}
}

print "</small></p></card></wml>";

?>