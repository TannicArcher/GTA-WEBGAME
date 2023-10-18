<?php

print "<u>[".$lang['in_town']."]</u><br/>";

if(empty($city3_logins_users) || count($city3_logins_users)<$nums)
{
for($i=0;$i<count($city3_logins_users);$i++)
{
print $city3_logins_users[$i].", ";
}
}
else
{
for($i=0;$i<$nums;$i++)
{
print $city3_logins_users[$i].", ";
}
}

print "<br/>---<br/><a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/><a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";

?>