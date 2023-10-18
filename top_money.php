<?php

/* by Neo (c) wapp.ru */

include "./ini.php";
include "./includes/header.php";
/* чтоб не было левых попыток сортировки */
if (($s != 'money') && ($s != 'money'))
{
        $s = 'money';
}
/* выцепляем */
$q = mysql_query ("SELECT * FROM users ORDER BY $s DESC LIMIT 20");
print '
<p align="center"><small>
'.$lang['top_users'].'<br/>
';
/* и печатаем */
for ($i = 1; $i < 20; $i++)
{
        $r = mysql_fetch_array($q);
        $name = $r['login'];
        $res = $r[$s];
        /* а вдруг 15 юзеров еще нет? */
        if ($name != "" AND $res != "")
        {
                print ''.$name.' - <b>('.$res.')</b><br/>';
        }
}
/* конец типа.. мускул рулит!!!! )))*/
print '
<anchor>'.$lang['back'].'<prev/></anchor>
';
mysql_close();

print "</small></p></card></wml>";

?>