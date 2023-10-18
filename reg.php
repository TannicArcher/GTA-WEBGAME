<?
Error_Reporting(E_ALL & ~E_NOTICE);
include "ini3.php";
include "includes/header2.php";


if(empty($login) || empty($pass) || empty($pass2))
{
echo "<form action=\"reg.php\" method=\"post\">
<postfield name=\"login\" value=\"$(login)\"/>
<postfield name=\"pass\" value=\"$(pass)\"/>
<postfield name=\"pass2\" value=\"$(pass2)\"/>
<postfield name=\"email\" value=\"$(email)\"/>
<postfield name=\"mobile\" value=\"$(mobile)\"/>
<postfield name=\"about\" value=\"$(about)\"/>
<postfield name=\"nums\" value=\"$(nums)\"/>
<postfield name=\"pol\" value=\"$(pol)\"/>";
print $lang['regheader']."<br/>";
print $lang['regimportant']."!<br/>";
print $lang['regname']."*:<br/>";
print "<input name=\"login\" value=\"$login\" maxlength=\"15\"/><br/>";
print "".$lang['regpass']."*:<br/>";
print "<input name=\"pass\"  value=\"$pass\" maxlength=\"15\"/><br/>";
print "".$lang['reg_confirm_pass']."*:<br/>";
print "<input name=\"pass2\" value=\"$pass2\" maxlength=\"15\"/><br/>";
print "".$lang['reg_mail'].":<br/>";
print "<input name=\"email\"  value=\"$mail\"/><br/>";
print "".$lang['regmobile'].":<br/>";
print "<input value=\"$mobile\" name=\"mobile\"/><br/>";
print "".$lang['regabout'].":<br/>";
print "<input value=\"$about\" name=\"about\"/><br/>";
print "".$lang['regonline'].":<br/>";
print "<select name=\"nums\">
<option value=\"5\">5</option>
<option value=\"10\">10</option>
</select><br/>";
echo "Ваш пол:<br /><select name='pol'>  <option value='1'>Мужской</option>  <option value='0'>Женский</option>  </select><br/>";
echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ok']."\"/></form>";
}
else
{
if($pass!=$pass2)
{
print $lang['reg_error_pass']."<br/>";
print "<a href=\"reg.php\">".$lang['again']."</a></body>
</html>";
exit;
}
elseif (strlen($login)<4)
{
print $lang['reg_error_log']."<br/>";
print "<a href=\"reg.php\">".$lang['again']."</a></body>
</html>";
exit;
}
elseif (strlen($pass)<5)
{
print $lang['reg_error_pas']."<br/>";
print "<a href=\"reg.php\">".$lang['again']."</a></body>
</html>";
exit;
}
if (ereg("[�-��-�,А,Б,В,$,>,<,',;,/,\,&,#,,,.,:,*,@,!,%,^,(,)]","$pass$login$pass2"))
{
print $lang['already_reg']."<br/>";
print "<a href=\"reg.php\">".$lang['again']."</a></body>
</html>";
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
$pol=cyr(htmlspecialchars(stripslashes(trim(str_replace('$','$$',$pol)))));

$query_users_login_reg = mysql_query("select login,pass from users where login='".$login."';");
$users_login_reg = mysql_fetch_array($query_users_login_reg);

if(!empty($users_login_reg['login']))
{
die
($lang['already_reg']."<br/>
<a href=\"reg.php\">".$lang['again']."</a>
</body>
</html>");
}
else
{
$reg_data=date("G:j.n.y");
mysql_query("insert into users values(0,'$login','$pass','$mobile','$email','$about','".$lang['reg_default_status']."','$reg_data','300','','','150','','".time().".0','','','".$nums."','','150','','0','0','0','0','0','0','','','$pol');");
$query_users = mysql_query("select id,pass from users where login='".$login."';");
$users_login = mysql_fetch_array($query_users);
$id = $users_login['id'];
$pass = $users_login['pass'];
print "Регистрация прошла успешно!<br/> Ваш логин: <b>$login</b><br/>Пароль: <b>$pass</b><br/>";
print "<a href=\"game.php?id=$id&amp;pass=$pass\">".$lang['reg_in_game']."</a>";
}
}

print "</body>
</html>";

?>