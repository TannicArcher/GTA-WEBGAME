<?php
$mess_q = mysql_query("select * from messagi where komu='$id' order by id desc limit 1;"); 
if(!empty($mess_q))
{
while($arrm=mysql_fetch_array($mess_q))
{
print str_replace('$$(','$(',str_replace('$','$$',$arrm['msg']))."<br/>"; 
}
}
?>

