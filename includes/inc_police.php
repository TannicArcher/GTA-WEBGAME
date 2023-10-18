<?php
if($police==1)
{
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes1']."<br/>";
}
elseif($police==2)
{
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes2']."<br/>";
}
elseif($police==3)
{
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes3']."<br/>";
print "<a href=\"./../cops.php?id=$id&amp;pass=$pass\">".$lang['ip_say']."</a><br/>";
}
elseif($police==4)
{
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes4']."<br/>";
print "<a href=\"./../cops.php?id=$id&amp;pass=$pass\">".$lang['ip_say']."</a><br/>";
}
elseif($police==5)
{
++$police;
mysql_query("update users set police='".$police."' where id='".$id."';");
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes5']."<br/>";
}
elseif($police==6)
{
--$health;
mysql_query("update users set health='".$health."' where id='".$id."';");
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes6']."<br/>";
}
elseif($police==7)
{
$health=$health-3;
mysql_query("update users set health='".$health."' where id='".$id."';");
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['ip_mes7']." ".$health."%<br/>";
}
elseif($police>7)
{
mysql_query("update users set cars='',guns='',money='50',police='' where id='".$id."';");
print $lang['ip_your_level']." <b>".$police."</b>! ".$lang['arrested']."<br/>";
}
?>