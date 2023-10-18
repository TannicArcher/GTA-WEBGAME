<?php
/*
ver 0.3
Скрипт для WapBrouser (http://mag.su/game/java.php)
Blade, blade17@rambler.ru

Установка: просто скопируйте этот файл на любой хостинг, поддерживающий PHP, а в мидлете WapBrouser укажите его новый адрес (меню "PHP Gate").

0.3: добавлены POST, SELECT и FORM для HTML, загружает не более 15кб
*/

$tmp=$QUERY_STRING;if($tmp=='') $tmp=$_SERVER["QUERY_STRING"];
$tmp=urldecode($tmp);
$s="";
ini_set("default_socket_timeout",120);
$fp = @fopen($tmp, "r");
if($fp) {
	stream_set_timeout($fp, 6);
    	$s=fread($fp, 15000);	//max 15кб
	fclose ($fp);
	} else $s="Сервер не найден:<br/>".$tmp;
if(!$s) $s="Сервер не отвечает:<br/>".$tmp;
if(strpos($s,"<card")===false) $s="<card>".$s."</card>";
die(w2w($s));

// переводит часть "43d" из "&#x043d;" в windows-1251
function unicode2win($s) {if($s=="401") return "Ё"; else if($s=="451") return "ё"; else return(chr(hexdec($s)-848));} 
function w2w($s) {
	$vars=array();
	$pages=array();
	$s = str_replace(":escape)",")",$s);
	$s = str_replace(":noesc)",")",$s);
	$s = preg_replace("/\n|\r/"," ",$s);
	$s = preg_replace("/\s{2,}/"," ",$s);
	$s = str_replace("> <","><",$s);
	$s = str_replace("&amp;","&",$s);
	$s = preg_replace("/&#x(?:0)?(\w\w\w);/e","unicode2win('\\0');",$s);
	$s = preg_replace("/&(\w+);/","-",$s);

	$xF = preg_match_all("/<do([^>]*)>((?:.|\n)*?)<\/do>/",$s,$regF);
	$links=array();
	$data="- Меню -\n";
	for ($i=0;$i<$xF;$i++) {	// по
		$label="";
		$href="";
		preg_replace("/label=\"(.*?)\"/e",'$label="\\1"',$regF[1][$i]);
		preg_replace("/href=\"(.*?)\"/e",'$href="\\1"',$regF[2][$i]);
		if ($label && $href) {
			// добавляем у в список ссылок и карту
			$links[]=array("title"=>$label,"link"=>$href,"from"=>strlen($data),"len"=>strlen($label));
			$data.=$label."\n";
			}
		}
	if ($xF>0) {$pages[]=array("id"=>"m123d","title"=>"Меню","links"=>$links,"data"=>$data);}

	// все тэги
	$xF = preg_match_all("/<(\/?[^>]*)>([^<]*)/",$s,$regF);
	$links=array();
	$data="";
	for ($i=0;$i<$xF;$i++) {
		if(strtolower(substr($regF[1][$i],0,2))=="br" || substr($regF[1][$i],0,1)=="p") $data.="\n";
		if(substr($regF[1][$i],0,5)=="/card") {	// карта кончилась, добавим в список карт
			$pages[]=array("id"=>$id,"title"=>$title,"links"=>$links,"data"=>$data);
			$links=array();
			$data="";
			} else
		if(substr($regF[1][$i],0,4)=="card") {
			// найдем title и id
			$title="";
			$id="";
			preg_replace("/title=\"(.*?)\"/e",'$title="- \\1 -"',$regF[1][$i]);
			preg_replace("/id=\"(.*?)\"/e",'$id="\\1"',$regF[1][$i]);
			$data.=$title.$regF[2][$i];
			} else
		if (substr($regF[1][$i],0,6)=="anchor") { 	// обязат. раньше <a (!)
			$set="";
			$st="";
			while($i<$xF && substr($regF[1][$i],0,7)!="/anchor") {$st.="<".$regF[1][$i].">".$regF[2][$i]; $i++;}
			// все setvar
			$xV = preg_match_all("/setvar\s*name=\"(.*?)\"\s*value=\"(.*?)\"/",$st,$regV);
			for ($j=0;$j<$xV;$j++) {
				if(!isset($vars[$regV[1][$j]])) $vars[$regV[1][$j]]="";	// добавляем в список переменных, если там нет
				$set.="&".$regV[1][$j]."=".$regV[2][$j];
				}
			// go href
			$href="";
			preg_replace("/href=\"(.*?)\"/e",'$href="\\1"',$st);
			// заменяем POST на GET
			$xV = preg_match_all("/postfield\s*name=\"(.*?)\"\s*value=\"(.*?)\"/",$st,$regV);
			if ($xV>0 && strpos($href,"?")!==false) $href.="?";
			for ($j=0;$j<$xV;$j++) {
				$href.="&".$regV[1][$j]."=".$regV[2][$j];
				}
			$href=str_replace("?&","?",$href);
			if ($set) $href="set".$set.":set:".$href;
			// title без тэгов
			$title=preg_replace("'<[\/\!]*?[^<>]*?>'si","",$st);
			$links[]=array("title"=>$title,"link"=>$href,"from"=>strlen($data),"len"=>strlen($title));
			$data.=$title;
			} else
		if (strtolower(substr($regF[1][$i],0,6))=="select") { // все option на ссылки на set&name=val:set:# и именем [текст] и добавляем в переменные
			$name="";
			preg_replace("/name=\"(.*?)\"/e",'$name="\\1"',$regF[1][$i]);
			if(!isset($vars[$name])) $vars[$name]="";			// добавляем в список переменных, если там нет
			while($i<$xF && substr($regF[1][$i],0,7)!="/select") {
				if(strtolower(substr($regF[1][$i],0,6))=="option") {
					$value="";
					preg_replace("/value=\"(.*?)\"/e",'$value="\\1"',$regF[1][$i]);
					$data.="[";
					$links[]=array("title"=>$regF[2][$i],"link"=>"set&".$name."=".$value.":set:#","from"=>strlen($data),"len"=>strlen($regF[2][$i]));
					$data.=$regF[2][$i]."]\n";
					}
				$i++;
				}
			} else
		if (strtolower(substr($regF[1][$i],0,1))=="a") { 	// парные <a
			$href="";
			preg_replace("/href=\"(.*?)\"/e",'$href="\\1"',$regF[1][$i]);
			$title=$regF[2][$i];
			$st="";
			while($i<$xF && strtolower(substr($regF[1][$i],0,7))!="/a") {$st.=$regF[2][$i]; $i++;}
			$links[]=array("title"=>$title,"link"=>$href,"from"=>strlen($data),"len"=>strlen($st));
			$data.=$st;
			} else

		if (strtolower(substr($regF[1][$i],0,4))=="form") { 	// HTML формы
			$action="";
			preg_replace("/action=\"(.*?)\"/e",'$action="\\1"',$regF[1][$i]);
			if (strpos($action,"?")===false) $action.="?";
			// найдем все переменные формы
			$j=0;
			while($j<$xF && strtolower(substr($regF[1][$j],0,5))!="/form") {
				$name="";
				preg_replace("/name=\"(.*?)\"/e",'$name="\\1"',$regF[1][$j]);
				if ($name) {
					$value="";
					preg_replace("/value=\"(.*?)\"/e",'$value="\\1"',$regF[1][$j]);
					$action.="&".$name."=".$value;
					}
				$j++;
				}
			$action=str_replace("?&","?",$action);
			$title="Отправить";
			$data.="[";
			$links[]=array("title"=>$title,"link"=>$action,"from"=>strlen($data),"len"=>strlen($title));
			$data.=$title."]";
			} else

		if (strtolower(substr($regF[1][$i],0,5))=="input") { 	// <input
			$name="";
			$value="";
			preg_replace("/name=\"(.*?)\"/e",'$name="\\1"',$regF[1][$i]);
			preg_replace("/value=\"(.*?)\"/e",'$value="\\1"',$regF[1][$i]);
			$title="изменить";
			$vars[$name]=$value;
			$data.="[";
			$links[]=array("title"=>$title,"link"=>"%".$name,"from"=>strlen($data),"len"=>strlen($title));
			$data.=$title;
			$data.=$regF[2][$i]."]";
			} else $data.=$regF[2][$i];
			
		}

	// подготавливаем файл
	$wml=pack("C",17);	// байт, обозначающий формат WapBrouser'а 
	$wml.=pack("C",count($vars));
	foreach($vars as $name=>$val) $wml.=pack("C",strlen($name)).$name.pack("C",strlen($val)).$val;
	$wml.=pack("C",count($pages));
	foreach($pages as $page) {
		$wml.=pack("C",count($page["links"]));
		foreach($page["links"] as $link) $wml.=pack("n",$link["from"]).pack("C",$link["len"]).pack("C",strlen($link["link"])).$link["link"];
		$wml.=pack("C",strlen($page["id"])).$page["id"];//.pack("C",strlen($page["title"])).$page["title"];
		$wml.=pack("n",strlen($page["data"])).$page["data"];
		} 
	return $wml;
	}

