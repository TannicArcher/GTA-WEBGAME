<?php
if(!empty($voo_por))
{
--$health;
mysql_query("update users set health='".$health."' where id='".$id."';");
print $lang['voo_nasl_por']." ".$health."%<br/>";
}
?>