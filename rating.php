<?php

include "ini.php";
include "includes/header.php";
include "includes/inc_online.php";

$query_users = mysql_query("select id from users;");
$users_rows = mysql_num_rows($query_users);

                print "<p><small>";





print "Лyчшие из лyчших:<br/>";
print "<a href=\"top.php\">Автоpитеты (TОP 15)</a><br/>";
 print "<a href=\"http://globalwap.h2m.ru/gta/top_money.php\">Богачи (TОP 20)</a><br/>";
print "---------------<br/>";

 print "<a href=\"http://globalwap.h2m.ru/gta\">Назад</a><br/>";



mysql_close();
print "</small></p></card></wml>";
?>