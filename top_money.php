<?php

/* by Neo (c) wapp.ru */

include "./ini.php";
include "./includes/header.php";
/* ���� �� ���� ����� ������� ���������� */
if (($s != 'money') && ($s != 'money'))
{
        $s = 'money';
}
/* ��������� */
$q = mysql_query ("SELECT * FROM users ORDER BY $s DESC LIMIT 20");
print '
<p align="center"><small>
'.$lang['top_users'].'<br/>
';
/* � �������� */
for ($i = 1; $i < 20; $i++)
{
        $r = mysql_fetch_array($q);
        $name = $r['login'];
        $res = $r[$s];
        /* � ����� 15 ������ ��� ���? */
        if ($name != "" AND $res != "")
        {
                print ''.$name.' - <b>('.$res.')</b><br/>';
        }
}
/* ����� ����.. ������ �����!!!! )))*/
print '
<anchor>'.$lang['back'].'<prev/></anchor>
';
mysql_close();

print "</small></p></card></wml>";

?>