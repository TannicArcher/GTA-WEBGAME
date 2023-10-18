<?php

if($level>=5 && $level<10)
{
mysql_query("update users set status='".$lang['stat1']."' where id='".$id."';");
}
elseif($level>=10 && $level<20)
{
mysql_query("update users set status='".$lang['stat2']."' where id='".$id."';");
}
elseif($level>=20 && $level<30)
{
mysql_query("update users set status='".$lang['stat3']."' where id='".$id."';");
}
elseif($level>=30 && $level<40)
{
mysql_query("update users set status='".$lang['stat4']."' where id='".$id."';");
}
elseif($level>=40 && $level<50)
{
mysql_query("update users set status='".$lang['stat5']."' where id='".$id."';");
}
elseif($level>=50 && $level<60)
{
mysql_query("update users set status='".$lang['stat6']."' where id='".$id."';");
}
elseif($level>=60 && $level<70)
{
mysql_query("update users set status='".$lang['stat7']."' where id='".$id."';");
}
elseif($level>=70 && $level<80)
{
mysql_query("update users set status='".$lang['stat8']."' where id='".$id."';");
}
elseif($level>=80 && $level<90)
{
mysql_query("update users set status='".$lang['stat9']."' where id='".$id."';");
}
elseif($level>=90)
{
mysql_query("update users set status='$status' where id='".$id."';");
} 
elseif($level>=90 && $level<200)
{ 
mysql_query("update users set status='".$lang['stat11']."' where id='".$id."';");
}

?>