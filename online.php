<?php
include "ini3.php";
include "includes/header2.php";


$main_users=0;
$city0_users=0;
$city1_users=0;
$city2_users=0;
$city3_users=0;
$nums=200;
$qqq = mysql_query("select city,login,id from users where last>('".time()."'-'1200');");
while($arr = mysql_fetch_array($qqq)) 
{
$dbid=$arr['id'];
$last_city = $arr['city'];

if($last_city == 0) 
{ 
++$main_users;
}
if($last_city == 0)
{ 
++$city0_users;
$city0_logins_users[] = "".$arr['login']."";
}

if($last_city == 1) 
{ 
++$city1_users; 
$city1_logins_users[] = "".$arr['login']."";
}
if($last_city == 2) 
{ 
++$city2_users; 
$city2_logins_users[] = "".$arr['login']."";
}
if($last_city == 3) 
{
++$city3_users; 
$city3_logins_users[] = "".$arr['login']."";
}

}

include ("includes/inc_on_city.php");

$main_users=$city1_users+$city2_users+$city3_users+$main_users;


echo "</body>
</html>";
?>