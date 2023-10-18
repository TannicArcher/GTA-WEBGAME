<?php
if($health<=-50)
{
mysql_query("delete from users where id='".$id."';");
print $lang['died']."<br/></small></p></card></wml>";
exit;
}
?>