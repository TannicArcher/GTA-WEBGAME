<?php

print "<u>[".$lang['in_town']."]</u><br/>";

if(empty($city2_logins_users) || count($city2_logins_users)<$nums)
{
for($i=0;$i<count($city2_logins_users);$i++)
{
print $city2_logins_users[$i].", ";
}
}
else
{
for($i=0;$i<$nums;$i++)
{
print $city2_logins_users[$i].", ";
}
}

print "<br/>";
print "<u>[".$lang['in_town_bot']."]</u><br/>";
print "<a href=\"./../userview.php?id=$id&amp;pass=$pass&amp;dbid=86\"><b>Татьяна Петровна</b></a>";
print "<br/>---<br/><a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/><a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";

print "<a href=\"./../taksi.php?id=$id&amp;pass=$pass\">".$lang['taxi']."</a>";
?>