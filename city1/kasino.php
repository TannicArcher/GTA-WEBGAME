<?php

include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</body>
</html>");
}

$data = mysql_fetch_array($q);

$id=$data['id'];
$login=$data['login'];
$money=$data['money'];
$level=$data['level'];
$police=$data['police'];
$stage=$data['stage'];
$health=$data['health'];
$cars=$data['cars'];
$guns=$data['guns'];
$nums=$data['nums'];
$voo_por=$data['voodoo'];
$golod=$data['golod'];
$secur=$data['secur'];
$zav=$data['zav'];
$lsd=$data['lsd'];
$ban=$data['ban'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");
if($ban==0)
{


include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
print "<b>[Зд: $health %][Сыт: $golod %][Зщ: $secur %]</b><br/>";
print "<b>".$lang['game_city1']."</b><br/>";
print "<u>[".$lang['area_kasino']."]</u><br/>";

switch ($mode)
{
  case "k0":


global $b;
global $gwin;
global $gover;
$cdiff = 'Normal';

if (isset($new))
{
        unset($b);
        unset($turn);
        mysql_query("delete from kasino where userid='".$id."';");
}

if (!isset($turn)) $turn=1;

if(!empty($h))
{
$h=base64_decode($h);
$b=explode(".",$h);
}

include "./../functions/func_casino.php";

print "</small><table columns=\"3\" align=\"LL\">";

if (isset($mv))
        $b[$mv]='x';

checkwin();
checkfull();



if ($gover <> 1 && $gwin == '' && $mv <> '')
{
$what=rand(1,2);
                if($what==1)
                {
                compmove();

                if ($cmv == '')
                {
                        comprand();
                }
                }
                else
                {
                compmove();
                if ($cmv == '')
                {
                        if ($b[4] == '')
                                $cmv=4;
                        elseif ($b[0] == '')
                                $cmv=0;
                        elseif ($b[2] == '')
                                $cmv=2;
                        elseif ($b[6] == '')
                                $cmv=6;
                        elseif ($b[8] == '')
                                $cmv=8;
                        if ($cmv == '')
                                comprand();
                }
                }

        $b[$cmv] = 'o';
}

checkwin();
checkfull();



for ($i = 0; $i <= 8; $i++)
{
        if ($i == 0 || $i == 3 || $i == 6)
                print '<tr>';
        print '<td>';

        if ($b[$i] == 'x')
                print 'X';
        elseif ($b[$i] == 'o')
                print '0';
        elseif ($gwin == '')
                {

print "<anchor>".$i."
<go href=\"kasino.php?mv=$i&amp;id=$id&amp;pass=$pass&amp;mode=k0\" method=\"post\">
<postfield name=\"h\" value=\"".base64_encode("$b[0].$b[1].$b[2].$b[3].$b[4].$b[5].$b[6].$b[7].$b[8]")."\"/></go></anchor>";
                }

        print '</td>';
        if ($i == 2 || $i == 5 || $i == 8)
                print '</tr>';
}


print "</table><small>";


if ($gwin == 'X')
        {
        $k_db=mysql_fetch_array(mysql_query("select combo from kasino where userid='".$id."' and combo='".$h."';"));

                if($k_db['combo']!=$h)
                {
        mysql_query("insert into kasino values(0,'".$id."','".$h."');");
        $val=rand(1,100);
        $money=$money+$val;
        mysql_query("update users set money='".$money."' where id='".$id."'");
        print "<b>".$lang['kasino_you_win']." ".$val."$$</b><br/>";
                }
        else
                {
        mysql_query("delete from kasino where userid='".$id."';");
        $new=$lang['kasino_new_game'];
        $money=$money-300;
        if($money<=0) $money=0;
        mysql_query("update users set money='".$money."' where id='".$id."'");
        print "<b>".$lang['kasino_you_lose']." 300$$</b><br/>";
                }

        }
elseif ($gwin == 'O')
        {
        $h='';
        $val=rand(1,100);
        $money=$money-$val;
        if($money<=0) $money=0;
        mysql_query("update users set money='".$money."' where id='".$id."'");
        print "<b>".$lang['kasino_you_lose']." ".$val."$$</b><br/>";
        }
elseif ($gover == 1)
        {
        print "<b>".$lang['kasino_nichya']."</b><br/>";
        }

print "<anchor>".$lang['kasino_new_game']."<go href=\"".$PHP_SELF."?id=$id&amp;pass=$pass&amp;mode=k0\" method=\"post\">
<postfield name=\"new\" value=\"".$lang['kasino_new_game']."\"/>
</go></anchor><br/>";
print "&gt;<a href=\"kasino.php?id=$id&amp;pass=$pass\">".$lang['area_kasino']."</a><br/>";
    break;
  default:

  

 print '<a href="play.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['area_play'].'</a><br/>';

  break;
}

print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer2.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</body>
</html>");

}
?>