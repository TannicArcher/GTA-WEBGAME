<?php
/*���������*/
function charGenerator($chars,$int)
{
$str=null;
$size=strLen($chars)-1;

        for($i=0;$i<$int;$i++)
        $str.=$chars[rand(0,$size)];

return $str;
}
/* ������ */
$st[] = 10;
$st[] = 50;
$st[] = 100;
$st[] = 250;
$st[] = 350;

/* �������� */
# ���� ������� 2 �����
$two = 50;
#���� ��� 3 ����� ����������
function what_money($char)
{
        global $m;
        if ($char==1 or $char==2 or $char==3 or $char==4 or $char==8)
        {
                $m = 3000;
        }
        elseif ($char==5)
        {
                $m = 4500;
        }
        elseif ($char==6)
        {
                $m = 3666;
        }
        elseif ($char==9)
        {
                $m = 4000;
        }

        return $m;
}

?>