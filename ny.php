<?php /*
http://splash.h2m.ru
New Year by _FrEEz_ */
function _freez_ny($tz=0) {
function _freez_sfx($n=0,$t='d') {
$c=substr($n,-1);
$w=substr('0'.$n,-2,1);
if(($c == 1)&&($w != 1)) {
$o['d']='день'; $o['h']='час'; $o['m']='минута'; $o['s']='секунда';
} else if(($c > 1)&&($c < 5)&&($w != 1)) {
$o['d']='дня'; $o['h']='часа'; $o['m']='минуты'; $o['s']='секунды';
} else {
$o['d']='дней'; $o['h']='часов'; $o['m']='минут'; $o['s']='секунд';
}
return $n.' '.$o[$t];
}
$tz=(time()+3599)+3600*intval($tz);
/* - */
$out='';
if(date('n',$tz) == 1) {
if(date('j',$tz) <= 15) {
$out.='<div class="t3">С Новым '.date('Y',$tz).' Годом!
Новому году:
'._freez_sfx(date('z',$tz),'d').',
'._freez_sfx(date('G',$tz),'h').',
'._freez_sfx(date('i',$tz),'m').' и
'._freez_sfx(date('s',$tz),'s').'.</div>';
} }
/* - */
$out.='<div class="t3">До нового года осталось:
'._freez_sfx(364+date('L',$tz)-date('z',$tz),'d').',
'._freez_sfx(23-date('G',$tz),'h').',
'._freez_sfx(59-date('i',$tz),'m').' и
'._freez_sfx(59-date('s',$tz),'s').'.</div>';
return $out;
}
echo nl2br(_freez_ny($_GET['tz']));
?>