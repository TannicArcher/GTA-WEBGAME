<?php

$r=rand(10000,1000000);

$file='./../data/dp.dat';
if (file_exists($file))
{
$fp = fopen($file, "r");
$dp = fread($fp, 20);
fclose($fp);
}
else
{
$fp = fopen($file, "w");
chmod($file, 0666);
fwrite($file, 1000);
fclose($fp);
}

include "./../ini.php";
include "./../includes/header.php";
include "./../includes/inc_online.php";
print "<p><small>";

$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health,zav,lsd,ban from users where id='".$id."';");
}
else
{
die ($lang['empty_login']."</small></p></card></wml>");
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
die ($lang['empty_login']."</small></p></card></wml>");
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
print "<u>[".$lang['area_play']."]</u><br/>";


include "./../includes/inc_play.php";
if (isset($stavka))
{
        if ($money < $stavka)
        {
                print ''.$lang['pl_no_money'].'<br/>
                &gt;<a href="play.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['area_play'].'</a><br/>';
        }
        else
        {
        /*     */
        if ($stavka == $st[0])
        {
                $c1 = charGenerator("0178",1);
                $c2 = charGenerator("3567",1);
                $c3 = charGenerator("2497",1);

        }
        /*   ,     ..) */
        elseif ($stavka == $st[1])
        {
                $c1 = charGenerator("01356789",1);
                $c2 = charGenerator("01356789",1);
                $c3 = charGenerator("01356789",1);

        }
        /*   ,       */
        elseif ($stavka == $st[2])
        {
                $c1 = charGenerator("0125689",1);
                $c2 = charGenerator("0125689",1);
                $c3 = charGenerator("0125689",1);
        }
        /*     */
        elseif ($stavka == $st[3])
        {
                $c1 = charGenerator("02479",1);
                $c2 = charGenerator("02479",1);
                $c3 = charGenerator("02479",1);
        }
        /*      ) */
        elseif ($stavka == $st[4])
        {
                $c1 = charGenerator("2579",1);
                $c2 = charGenerator("2579",1);
                $c3 = charGenerator("2579",1);

        }
        else
        {
                print $lang['error'];
                $err=1;
        }
        if ($err != 1)
        {
                if ($c1 == $c2 and $c2 != $c3)
                {
                $money = $money + $two;
                mysql_query("update users set money='".$money."' where id='".$id."'");
                print "".$lang['pl_pr']." $two</b><br/>
                <b>$c1-$c2</b>-$c3<br/>";
                }
                elseif ($c2 == $c3 and $c2 != $c1)
                {
                $money = $money + $two;
                mysql_query("update users set money='".$money."' where id='".$id."'");
                print "".$lang['pl_pr']." $two</b><br/>
                $c1-<b>$c2-$c3</b><br/>";
                }
                elseif ($c1 == $c2 and $c2 == $c3)
                {
                if ($c1 != 7)
                {
                $m2 = what_money($c1);
                $money = $money + $m2;
                mysql_query("update users set money='".$money."' where id='".$id."'");
                print "".$lang['pl_pr']."".$m2."</b><br/>";
                }
                else
                {
                $money = $money + $dp;
                print "".$lang['pl_cool']."<br/><b>$$".$dp." </b> ".$lang['pl_your']."<br/>";
                mysql_query("update users set money='".$money."' where id='".$id."'");
                $fp = fopen($file, "w");
                fwrite($fp, 1000);
                fclose($fp);
                }
                print "<b>$c1-$c2-$c3</b><br/>";
                }
                else
                {
                $money = $money - $stavka;
                $dp = $dp + $stavka;
                $fp = fopen($file, "w");
                fwrite($fp, $dp);
                fclose($fp);
                mysql_query("update users set money='".$money."' where id='".$id."'");
                print "".$lang['pl_no']."<br/>$c1-$c2-$c3<br/>";
                }

        }

        print '<anchor>'.$lang['pl_al'].'
        <go href="play.php?id='.$id.'&amp;pass='.$pass.'&amp;r='.$r.'" method="post">
        <postfield name="stavka" value="'.$stavka.'"/>
        </go></anchor><br/>
        &gt;<a href="play.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['area_play'].'</a><br/>';
}
}
/*   */
else
{
        print ''.$lang['pl_dp'].' <b>'.$dp.'</b><br/>'.$lang['pl_your_money'].''.$money.'</b><br/>['.$lang['pl_stavka'].']<br/>
                       </small><select name="stavka" title="'.$lang['pl_stavka'].'">
        ';
        for ($i=0; $i < count($st); $i++)
        {
                print '<option value="'.$st[$i].'">'.$st[$i].'$$</option>';
        }
        print '
        </select><small><br/>
        <anchor>'.$lang['ok'].'
        <go href="play.php?id='.$id.'&amp;pass='.$pass.'&amp;r='.$r.'" method="post">
        <postfield name="stavka" value="$('.stavka.')"/>
        </go></anchor><br/>
        &gt;<a href="kasino.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['area_kasino'].'</a><br/>
        ';
}

print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer.php";
}

elseif($ban==1)
{
die ($lang['empty_login']."</small></p></card></wml>");

}
?>