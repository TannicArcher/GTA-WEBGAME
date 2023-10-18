<?php

$refer=getenv(HTTP_REFERER);
if(!empty($refer))
{
mysql_query("delete from refers where userid='".$id."';");
mysql_query("insert into refers values(0,'".$id."','".$refer."');");
}
?>