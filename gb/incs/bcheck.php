<?php
if(isset($_COOKIE['t2b4y'])){ Header('Location: banned.php'); exit; }
$bf=file('incs/ban.dat');
$cnt=count($bf);
if($cnt){
for($i=0;$i<$cnt;$i++){
 $a=explode('|:|',$bf[$i]);
 switch($a[0]){
  case 0:
   if($_SERVER['HTTP_USER_AGENT'].' IP:'.$_SERVER['REMOTE_ADDR']."\n"==$a[1]){
    Header('Location: banned.php'); exit;
   }
  break;
  case 1:
   if($_SERVER['HTTP_USER_AGENT']."\n"==$a[1]){
    Header('Location: banned.php'); exit;
   }
  break;
  case 2:
   if($_SERVER['REMOTE_ADDR']."\n"==$a[1]){
    Header('Location: banned.php'); exit;
   }
  break;
  case 3:
   if($_SERVER['HTTP_USER_AGENT'].' IP:'.$_SERVER['REMOTE_ADDR']."\n"==$a[1]){
   if(setcookie('t2b4y',true,time()+604800,'/')){
    unset($bf[$i]);
    $f=fopen('incs/ban.dat','w');
    $d=implode('',$bf);
    fputs($f,$d);
    fclose($f); }}
  break;
  case 4:
   if($_SERVER['HTTP_USER_AGENT']."\n"==$a[1]){
   if(setcookie('t2b4y',true,time()+604800,'/')){
    unset($bf[$i]);
    $f=fopen('incs/ban.dat','w');
    $d=implode('',$bf);
    fputs($f,$d);
    fclose($f); }}
  break;
  case 5:
   if($_SERVER['REMOTE_ADDR']."\n"==$a[1]){
   if(setcookie('t2b4y',true,time()+604800,'/')){
    unset($bf[$i]);
    $f=fopen('incs/ban.dat','w');
    $d=implode('',$bf);
    fputs($f,$d);
    fclose($f); }}
  break;
  case 6:
   Header('Location: banned.php'); exit;
  break;
 }
}
}
?>
