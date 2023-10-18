<?php
$main_users=$main_users;
$city1_users=$city1_users;
$city2_users=$city2_users;
$city3_users=$city3_users;
$qqq = mysql_query("select city,login,id from users where last>('".time()."'-'1200');");
while($arr = mysql_fetch_array($qqq)) 
{
$dbid=$arr['id'];
$last_city = $arr['city'];

if($last_city == 0) 
{ 
++$main_users; 
}
if($last_city == 1) 
{ 
++$city1_users; 
$city1_logins_users[] = "<a href=\"./../userview.php?id=$id&amp;pass=$pass&amp;dbid=".$dbid."\">".$arr['login']."</a>"; 
}
if($last_city == 2) 
{ 
++$city2_users; 
$city2_logins_users[] = "<a href=\"./../userview.php?id=$id&amp;pass=$pass&amp;dbid=".$dbid."\">".$arr['login']."</a>"; 
}
if($last_city == 3) 
{ 
++$city3_users; 
$city3_logins_users[] = "<a href=\"./../userview.php?id=$id&amp;pass=$pass&amp;dbid=".$dbid."\">".$arr['login']."</a>"; 
}

}
$main_users=$city1_users+$city2_users+$city3_users+$main_users;
?>