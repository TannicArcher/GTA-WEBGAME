<?php
###########################################################################
##                         -=Lesnik=-                                    ##
##                       ---------------                                 ##
##                   http://wenz.net.ru                                  ##
##                           *-*-*-*                                     ##
##                                                                       ##
##                      ICQ: 366-244-181                                 ##
##                          - - - - -                                    ##
##                 ������: ����������� ��� ���� ���                      ##
##                          - - - - -                                    ##
###########################################################################

$mysqlhost = "localhost"; // ���� �.�.
$database = ""; // ��� �.�.
$mysqluser = ""; // ��� ����� �.�.
$password = ""; // ������ ����� �.�.
$opros = "opros"; // �� �������
$gols = "clicks"; // �� �������
$site = ""; // ��� ����
$vopros = "��������� �� ���� ����.��������!"; // ������ ������
//////////////////////////////////////////
@$connection = mysql_connect($mysqlhost, $mysqluser, $password);
if(!$connection)
{
header("Content-type: text/vnd.wap.wml; charset=utf-8");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-relative");
$error = mysql_error();
echo <<< END
<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.3//EN' 'http://www.wapforum.org/DTD/wml13.dtd'><wml>
<card id='error' title='Error'>
<p align='left'>
��� ���������� � MySQL.<br/>
<a href='http://$site'>[$site]</a><br/>
</p>
</card>
</wml>
END;
exit();
}
if(!mysql_select_db($database, $connection))
{
header("Content-type: text/vnd.wap.wml; charset=utf-8");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-relative");
$error = mysql_error();
echo <<< END
<?xml version='1.0' encoding='UTF-8'?>
<!DOCTYPE wml PUBLIC '-//WAPFORUM//DTD WML 1.3//EN' 'http://www.wapforum.org/DTD/wml13.dtd'><wml>
<card id='error' title='Error'>
<p align='left'>
��� ���������� � �.�.<br/>
<a href='http://$site'>[$site]</a><br/>
</p>
</card>
</wml>
END;
exit();
}
//////////////////////////////////////////
?>
