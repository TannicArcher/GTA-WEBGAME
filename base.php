<?php
/*
ver 0.3
������ ��� WapBrouser (http://mag.su/game/java.php)
Blade, blade17@rambler.ru

���������: ������ ���������� ���� ���� �� ����� �������, �������������� PHP, � � ������� WapBrouser ������� ��� ����� ����� (���� "PHP Gate").

0.3: ��������� POST, SELECT � FORM ��� HTML, ��������� �� ����� 15��
*/

$tmp=$QUERY_STRING;if($tmp=='') $tmp=$_SERVER["QUERY_STRING"];
$tmp=urldecode($tmp);
$s="";
ini_set("default_socket_timeout",120);
$fp = @fopen($tmp, "r");
if($fp) {
	stream_set_timeout($fp, 6);
    	$s=fread($fp, 15000);	//max 15��
	fclose ($fp);
	} else $s="������ �� ������:<br/>".$tmp;
if(!$s) $s="������ �� ��������:<br/>".$tmp;
if(strpos($s,"<card")===false) $s="<card>".$s."</card>";
die(w2w($s));

// ��������� ����� "43d" �� "&#x043d;" � windows-1251
function unicode2win($s) {if($s=="401") return "�"; else if($s=="451") return "�"; else return(chr(hexdec($s)-848));} 
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
	$data="- ���� -\n";
	for ($i=0;$i<$xF;$i++) {	// ��
		$label="";
		$href="";
		preg_replace("/label=\"(.*?)\"/e",'$label="\\1"',$regF[1][$i]);
		preg_replace("/href=\"(.*?)\"/e",'$href="\\1"',$regF[2][$i]);
		if ($label && $href) {
			// ��������� � � ������ ������ � �����
			$links[]=array("title"=>$label,"link"=>$href,"from"=>strlen($data),"len"=>strlen($label));
			$data.=$label."\n";
			}
		}
	if ($xF>0) {$pages[]=array("id"=>"m123d","title"=>"����","links"=>$links,"data"=>$data);}

	// ��� ����
	$xF = preg_match_all("/<(\/?[^>]*)>([^<]*)/",$s,$regF);
	$links=array();
	$data="";
	for ($i=0;$i<$xF;$i++) {
		if(strtolower(substr($regF[1][$i],0,2))=="br" || substr($regF[1][$i],0,1)=="p") $data.="\n";
		if(substr($regF[1][$i],0,5)=="/card") {	// ����� ���������, ������� � ������ ����
			$pages[]=array("id"=>$id,"title"=>$title,"links"=>$links,"data"=>$data);
			$links=array();
			$data="";
			} else
		if(substr($regF[1][$i],0,4)=="card") {
			// ������ title � id
			$title="";
			$id="";
			preg_replace("/title=\"(.*?)\"/e",'$title="- \\1 -"',$regF[1][$i]);
			preg_replace("/id=\"(.*?)\"/e",'$id="\\1"',$regF[1][$i]);
			$data.=$title.$regF[2][$i];
			} else
		if (substr($regF[1][$i],0,6)=="anchor") { 	// ������. ������ <a (!)
			$set="";
			$st="";
			while($i<$xF && substr($regF[1][$i],0,7)!="/anchor") {$st.="<".$regF[1][$i].">".$regF[2][$i]; $i++;}
			// ��� setvar
			$xV = preg_match_all("/setvar\s*name=\"(.*?)\"\s*value=\"(.*?)\"/",$st,$regV);
			for ($j=0;$j<$xV;$j++) {
				if(!isset($vars[$regV[1][$j]])) $vars[$regV[1][$j]]="";	// ��������� � ������ ����������, ���� ��� ���
				$set.="&".$regV[1][$j]."=".$regV[2][$j];
				}
			// go href
			$href="";
			preg_replace("/href=\"(.*?)\"/e",'$href="\\1"',$st);
			// �������� POST �� GET
			$xV = preg_match_all("/postfield\s*name=\"(.*?)\"\s*value=\"(.*?)\"/",$st,$regV);
			if ($xV>0 && strpos($href,"?")!==false) $href.="?";
			for ($j=0;$j<$xV;$j++) {
				$href.="&".$regV[1][$j]."=".$regV[2][$j];
				}
			$href=str_replace("?&","?",$href);
			if ($set) $href="set".$set.":set:".$href;
			// title ��� �����
			$title=preg_replace("'<[\/\!]*?[^<>]*?>'si","",$st);
			$links[]=array("title"=>$title,"link"=>$href,"from"=>strlen($data),"len"=>strlen($title));
			$data.=$title;
			} else
		if (strtolower(substr($regF[1][$i],0,6))=="select") { // ��� option �� ������ �� set&name=val:set:# � ������ [�����] � ��������� � ����������
			$name="";
			preg_replace("/name=\"(.*?)\"/e",'$name="\\1"',$regF[1][$i]);
			if(!isset($vars[$name])) $vars[$name]="";			// ��������� � ������ ����������, ���� ��� ���
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
		if (strtolower(substr($regF[1][$i],0,1))=="a") { 	// ������ <a
			$href="";
			preg_replace("/href=\"(.*?)\"/e",'$href="\\1"',$regF[1][$i]);
			$title=$regF[2][$i];
			$st="";
			while($i<$xF && strtolower(substr($regF[1][$i],0,7))!="/a") {$st.=$regF[2][$i]; $i++;}
			$links[]=array("title"=>$title,"link"=>$href,"from"=>strlen($data),"len"=>strlen($st));
			$data.=$st;
			} else

		if (strtolower(substr($regF[1][$i],0,4))=="form") { 	// HTML �����
			$action="";
			preg_replace("/action=\"(.*?)\"/e",'$action="\\1"',$regF[1][$i]);
			if (strpos($action,"?")===false) $action.="?";
			// ������ ��� ���������� �����
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
			$title="���������";
			$data.="[";
			$links[]=array("title"=>$title,"link"=>$action,"from"=>strlen($data),"len"=>strlen($title));
			$data.=$title."]";
			} else

		if (strtolower(substr($regF[1][$i],0,5))=="input") { 	// <input
			$name="";
			$value="";
			preg_replace("/name=\"(.*?)\"/e",'$name="\\1"',$regF[1][$i]);
			preg_replace("/value=\"(.*?)\"/e",'$value="\\1"',$regF[1][$i]);
			$title="��������";
			$vars[$name]=$value;
			$data.="[";
			$links[]=array("title"=>$title,"link"=>"%".$name,"from"=>strlen($data),"len"=>strlen($title));
			$data.=$title;
			$data.=$regF[2][$i]."]";
			} else $data.=$regF[2][$i];
			
		}

	// �������������� ����
	$wml=pack("C",17);	// ����, ������������ ������ WapBrouser'� 
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

