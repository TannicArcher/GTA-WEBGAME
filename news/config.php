<?php
$dblocation='localhost';
$dbname='';
$dbuser='';
$dbpasswd='';
$dbcnx=mysql_connect($dblocation,$dbuser,$dbpasswd);
if(!$dbcnx)
die(mysql_error());
mysql_select_db($dbname,$dbcnx);
mysql_unbuffered_query("SET `character_set_client` = 'utf8';");
mysql_unbuffered_query("SET `character_set_results` = 'utf8';");
mysql_unbuffered_query("SET `collation_connection` = 'utf8_general_ci';");


?>