<?php
if($health>-50 && $health<=0)
{
mysql_query("update users set health='100',police='0',money='$money',cars='',guns='' where id='".$id."';");
print $lang['hospital']."<br/><anchor>".$lang['back']."<prev/></anchor></small></p></card></wml>";
exit;
}
?>