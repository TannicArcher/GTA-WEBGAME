<?php
if(!empty($secur) && $secur>=0)
{
--$secur;
mysql_query("update users set secur='".$secur."' where id='".$id."';");
}
?>