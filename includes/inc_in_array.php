<?php
if(!empty($gun))
{
$guns_array=explode(".", $guns);
if(in_array($gun, $guns_array)) 
{
print $lang['in_array_thing']."<br/><a href='javascript:history.back(1)'>".$lang['back']."</a><br/></body>
</html>";
exit;
}
}
if(!empty($car))
{
$cars_array=explode(".", $cars);
if(in_array($car, $cars_array)) 
{
print $lang['in_array_car']."<br/><a href='javascript:history.back(1)'>".$lang['back']."</a><br/></body>
</html>";
exit;
}
}
?>