<?php
include "./../ini3.php";
include "./../includes/header2.php";
include "./../includes/inc_online.php";


$id=cyr(htmlspecialchars(stripslashes(trim($id))));
$pass=cyr(htmlspecialchars(stripslashes(trim($pass))));

if(!empty($id))
{
$q = mysql_query("select secur,golod,voodoo,nums,guns,cars,id,login,pass,money,level,police,health from users where id='".$id."';");
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
$golod=$data['golod'];
$secur=$data['secur'];

if($pass!=$data['pass'])
{
die ($lang['empty_login']."</body>
</html>");
}

mysql_query("update users set last='".time()."',city='1' where id='".$id."';");

/**/
$st = 50;
/**/
include "./../includes/inc_secur.php";
include "./../includes/inc_golod.php";
include "./../includes/inc_hospital.php";
include "./../includes/inc_police.php";
include "./../includes/inc_die.php";
include "./../includes/inc_voodoo.php";
include "./../includes/inc_attack.php";
include "./../includes/inc_mes.php";
print "<b>".$lang['game_city1']."</b><br/>";
print "<u>[".$lang['area_ag']."]</u><br/>";

if (empty($key))
{       echo '<form action="agentstvo.php?id='.$id.'&amp;pass='.$pass.'" method="post">
<postfield name="key" value="$('.key.')"/>';
        print ''.$lang['ag_about'].'<b>$$'.$st.'</b>'.$lang['ag_about2'].'<br/>'.$lang['ag_word'].':<br/>
        <input title="Word" name="key"/><br/>';

        echo "<input class=\"ibutton\" type=\"submit\" value=\"".$lang['ag_search']."\"/>";
           echo "</form>";
}
else
{
        $money = $money-$st;
        mysql_query("update users set money='".$money."' where id='".$id."'");
        $key = htmlspecialchars(stripslashes(trim(str_replace("$", "$$", $key))));
        $query = "SELECT * FROM users WHERE login = '".$key."'";
        $result = mysql_query($query);
        if (mysql_num_rows($result) > 0)
        {
                while ($r = mysql_fetch_array($result))
                {
                        $reg = explode(":",$r['reg_data']);
                        print ''.$lang['ag_results'].'<br/>';
                        if (time()-$last > 1200) { $v = ''.$lang['no'].''; }
                        else { $v=''.$lang['yes'].''; }
                        $p = date("H:i j.m.Y",$r['last']);
                        $msg = '<u>['.$r['login'].']</u>:<br/>';
                        $msg .= '<a href="../mes.php?id='.$id.'&amp;pass='.$pass.'&amp;dbid='.$r['id'].'&amp;mode=reply">['.$lang['uv_mes'].']</a><br/>';
                        $msg .= 'ID: '.$r['id'].'<br/>';
                        $msg .= ''.$lang['uv_status'].': <b>'.$r['status'].'</b><br/>';
                        $msg .= ''.$lang['ag_now'].': '.$v.'<br/>';
                        $msg .= ''.$lang['uv_regdate1'].':'.$reg[1].' '.$lang['uv_regdate2'].' '.$reg[0].' '.$lang['uv_regdate3'].'<br/>';
                        $msg .= ''.$lang['uv_money'].': $$'.$r['money'].'<br/>';
                        $msg .= ''.$lang['uv_level'].': '.$r['level'].'<br/>';
                        $msg .= ''.$lang['uv_police'].': '.$r['police'].'<br/>';
                        if ($r['cars'] != "")
                        {
                                $msg .= ''.$lang['uv_cars'].': '.str_replace(".", ",", $r['cars']).'<br/>';
                        }
                        if ($r['guns'] != "")
                        {
                                $msg .= ''.$lang['uv_guns'].': '.str_replace(".", ",", $r['guns']).'<br/>';
                        }
                        if ($r['secur'] != "")
                        {
                                $msg .= ''.$lang['uv_secur'].': '.$r['secur'].'<br/>';
                        }
                        $msg .= ''.$lang['uv_health'].': '.$r['health'].'%<br/>';
                        $msg .= ''.$lang['uv_golod'].': '.$r['golod'].'%<br/>';
                        $msg .= ''.$lang['ag_last'].': '.$p.'<br/>';
                        $msg .= '';
                        if ($r['band'] != "")
                        {
                                $msg .= ''.$lang['uv_band'].': <b><a href="../bands/viewband.php?id='.$id.'&amp;pass='.$pass.'&amp;band='.urlencode($r['band']).'">'.$r['band'].'</a></b><br/>';
                        }
                        if ($r['mobile'] != "")
                        {
                                $msg .= ''.$lang['uv_mobile'].': '.$r['mobile'].'<br/>';
                        }
                        if ($r['about'] != "")
                        {
                                $msg .= ''.$lang['regabout'].': '.$r['about'].'<br/>';
                        }
                        if ($r['email'] != "")
                        {
                                $msg .= 'E-mail: '.$r['email'].'<br/>';
                        }
                        $msg .= '&gt;<a href="agentstvo.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['area_ag'].'</a><br/>';

                        print '
                        '.$msg.'
                        ';
                }
        }
        else
        {
                print ''.$lang['ag_no_results'].'<br/>';
                print '&gt;<a href="agentstvo.php?id='.$id.'&amp;pass='.$pass.'">'.$lang['area_ag'].'</a><br/>';
        }
}

print "---<br/>&gt;<a href=\"index.php?id=$id&amp;pass=$pass\">".$lang['in_city']."</a>";
print "<br/>&gt;&gt;<a href=\"./../game.php?id=$id&amp;pass=$pass\">".$lang['menu']."</a>";
print "<br/>---";

mysql_close();
include "./../includes/footer2.php";
?>