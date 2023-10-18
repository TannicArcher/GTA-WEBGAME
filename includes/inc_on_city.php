<?php

print "[".$lang['in_town0']."]<br/>";


if(empty($city0_logins_users) || count($city0_logins_users)<$nums)
{
for($i=0;$i<count($city0_logins_users);$i++)
{
print $city0_logins_users[$i].", ";
}
} 
else
{
for($i=0;$i<$nums;$i++)
{
print $city0_logins_users[$i].", ";
}
}

print "<br/>[".$lang['in_town1']."]<br/>";


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

print "<br/>[".$lang['in_town2']."]<br/>";


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

print "<br/>[".$lang['in_town3']."]<br/>";


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
print $city1_logins_users[$i].", ";
}
}


print "---<br/><a href=\"index.php\">".$lang['in_gam']."</a>";


print "<br/>---";



?>