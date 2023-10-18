<?php

print "<u>[".$lang['in_town']."]</u><br/>";

if(empty($city1_logins_users) || count($city1_logins_users)<$nums)
{
for($i=0;$i<count($city1_logins_users);$i++)
{
print $city1_logins_users[$i].", ";
}
} 
else
{
for($i=0;$i<$nums;$i++)
{
print $city1_logins_users[$i].", ";
}
}


print "<br/>   ";
print "<u>[".$lang['in_town_bot']."]</u>";
print "<br/><a href=\"./../userview.php?id=$id&amp;pass=$pass&amp;dbid=11\"><b>Saint George</b></a>";
print "<br/><a href=\"./../userview.php?id=$id&amp;pass=$pass&amp;dbid=12\"><b>ПетровиЧ</b></a>";
print "<br/>---<br/><a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a><br/>";
print "<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";

print "<br/>---";

?>