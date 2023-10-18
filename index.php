<?php

include "ini3.php";
include "includes/header2.php";
include "includes/inc_online.php";

$query_users = mysql_query("select id from users;");
$users_rows = mysql_num_rows($query_users);



print "<u>".$lang['version']."</u><b>: 4.0 </b><br/>";
print "<u>".$lang['forum']."</u><br/>";
print "<u>".$lang['head']."</u><br/>";

print "-----<br/>";



                echo "<form action=\"game.php\" method=\"post\">";

           echo "Логин: <br/>";
           echo "<input name=\"login\" maxlength=\"12\" title=\"Text\"/><br/>";
           
           echo "Пароль: <br/>";
           echo "<input name=\"pass\" maxlength=\"20\" type=\"password\"/><br/><br/>";
           echo "<input class=\"ibutton\" type=\"submit\" value=\"Войти\"/>";
           echo "</form>";
                        
print "-------<br/>";
 print "<a href=\"reg.php\">Регистрация</a><br/>";
print "<a href=\"top.php\">Рейтинг Авторитетов</a><br/>";
print "<a href=\"top_money.php\">Рейтинг Толстосумов</a><br/>";
print "<a href=\"online.php\">Онлайн:</a> ".$main_users."<br/>";
print "Регистраций: ".$users_rows."<br/>";
print "-------<br/>";
print "<a href=\"http://wenz.net.ru\">Главная</a>";


mysql_close();
echo "</body></html>";
?>