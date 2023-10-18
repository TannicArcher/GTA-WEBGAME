<?php
$attack_q = mysql_query("select * from attack where userid='$id' order by id desc limit 1;"); 
if(!empty($attack_q))
{
while($arr=mysql_fetch_array($attack_q))
{
print $arr['msg']."<br/><anchor>[".$lang['reflect']."]<go href=\"./../fuck_attack.php?id=$id&amp;pass=$pass\" method=\"post\"><postfield name=\"ud_what\" value=\"".base64_encode($arr['what'])."\"/><postfield name=\"power\" value=\"".base64_encode($arr['power'])."\"/><postfield name=\"who\" value=\"".base64_encode($arr['who'])."\"/></go></anchor><br/>"; 
}
}
?>