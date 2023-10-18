<?php

if($golod>0)
{
--$golod;
mysql_query("update users set golod='".$golod."' where id='".$id."';");
}
else
{
--$health;
mysql_query("update users set health='".$health."' where id='".$id."';");
print $lang['golod_warning'];
}

?>