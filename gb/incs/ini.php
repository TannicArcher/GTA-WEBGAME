<?php
// - - - Настройки - - -
// Пароль админа:
$CONF['admp'] = '79619539132';
// Ник админа:
$CONF['admin'] = 'Lesnik';
// Сообщений на страницу:
$CONF['ns'] = 6;
// Количество сохраняемых в файле постов:
$CONF['np'] = 5000;
// Объявление наверху гостевой:
$CONF['zag'] = 'Привет гость..';
// включить подтверждение текстом? kod или false(нет)
$CONF['kod'] = 'kod'; // лучше использовать
// Использовать CAPTCHA (подтверждение по картинке) или нет?:
// какое нить одно из потверждений
$CONF['captcha'] = false;
// ПОказывать скока сообщений в гостевой? yes или no
$CONF['skoka'] = 'yes'; // если будет дохрена сообщений, то гостя подвисать будет, нужно чистить
// ваш сайт без http://
$CONF['saiteg'] = 'wenz.org.ru';
// ваш сайт с http://     
$CONF['home'] = 'http://wenz.org.ru/gta';
// рекламная ссылка
$CONF['rek'] = '';   
// ваш счетчик
$CONF['schetchik'] = '';
// антиреклама))  напишите, на  что заменять рекламную ссылку..
$CONF['anti'] = '|облом бу га га!!!|';
##############################################################################################3
// то, что ниже  не трогать , носа не сувать))))))
//это  матопреграда йопт..   // если знаете ещё нехорошие слова, то напишите их через |                            
function mat($text){                 
return preg_replace('/(\S*)(сука|пизда|охуеть|нахуй|дебил|пидор|пидар|жоп|жаба|распиз|бля|ёбаный|тупой|урод|ёбаная|ебаная|бычара|бык|козёл|идиот|олень|быдло|лох|лошара|нахую|осёл|писька)(\S*)/isu', 'гг', $text);
}

//  насчёт защиты 
function clean($text){
return str_replace(array(chr(0),chr(1),chr(2),chr(3),chr(4),chr(5),chr(6),chr(7),chr(8),chr(9),chr(10),chr(11),chr(12),chr(14),chr(15),chr(16),chr(17),chr(18),chr(19),chr(20),chr(21),chr(22),chr(23),chr(24),chr(25),chr(26),chr(27),chr(28),chr(29),chr(30),chr(31)),null,$text);
}

//замена марок телефонов  
function brauzer($br) { 
$br = str_replace('Opera/', 'ОпЕра/', $br); 
$br = str_replace('(OperaMini)SonyEricssonK750i', 'ОпЕрА-Мини_СонЭрик-K750ай', $br);
$br = str_replace('SonyEricssonK750i/R1CA', 'СонЭрик-K750ай', $br);
$br = str_replace('Mozilla', 'МозиЛЛа', $br);
$br = str_replace('Nokia', 'НоКиА', $br);
$br = str_replace('(OperaMini)SonyEricssonK310i/R4EA', 'ОпЕрА-Мини_СонЭрик-K310ай', $br);
$br = str_replace('(OperaMini)Nokia', 'ОпЕрА-Мини_НоКиА', $br);
$br = str_replace('Nokia', 'НоКиА', $br);
$br = str_replace('(OperaMini)SIE', 'ОпЕрА-Мини_СиМеНс', $br);
$br = str_replace('SonyEricssonK300i/R2BA', 'СонЭрик-K300ай', $br);
return $br; 
}

//от  козлов фсяких
if(substr($_SERVER['SCRIPT_NAME'],-7)=='ini.php') exit('Пшлo нaх :P');


//онлайн счётчик
class online {
 var $count;
 var $arr;
 var $indata;
 var $path='incs/online.dat'; // путь к файлу  //  на нём чмод стоять должен 666
 function online(){
  $this->indata[0]=strtok($_SERVER['HTTP_USER_AGENT'],' ');
  $this->indata[1]=$_SERVER['REMOTE_ADDR'];
  $this->indata[2]=time();
  $this->arr=file($this->path);
  $this->cnt=count($this->arr);
  $t=time() - 360; // время жизни данных в онлайне (сек)
  for($i=0;$i<$this->cnt;$i++){
   $a=unserialize($this->arr[$i]);
   if($a[2] < $t){
    unset($this->arr[$i]);
    $this->cnt--;
   }
  }
 }
 function add(){
  foreach($this->arr as $key=>$val){
   $a=unserialize($val);
   if($a[0]==$this->indata[0] && $a[1]==$this->indata[1]){
    unset($this->arr[$key]);
    $this->cnt--;
    break;
   }
  }
  $f=fopen($this->path,'w');
  fputs($f,serialize($this->indata)."\n".implode('',$this->arr));
  fclose($f);
  $this->cnt++;
 }
}

// Маленькая "косметическая" функция для некоторых ссылок
function psid(){
 return (SID) ? ('?'.SID) : null;
}

// Функция для фильтрации переменных
function safe_var($str,$brl=false){
 $str=trim(stripslashes(htmlspecialchars($str))); 
 if($brl) $str=nl2br($str);
 $str=strtr($str,array("\r"=>' ',"\n"=>' '));
 return $str;
}

// для определения модели телефона с оперы-мини:
if(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])) $_SERVER['HTTP_USER_AGENT']='(OperaMini)'.$_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];
if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $_SERVER['REMOTE_ADDR']=$_SERVER['HTTP_X_FORWARDED_FOR'];

session_start();
?>