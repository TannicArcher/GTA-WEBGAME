<?php
// Компрессия
if(@$_SERVER['HTTP_ACCEPT_ENCODING'])
{$compress = strtolower(@$_SERVER['HTTP_ACCEPT_ENCODING']);}
else
{$compress = strtolower(@$_SERVER['HTTP_TE']);}

if(substr_count($compress,'deflate'))
{
function compress_output_deflate($output)
{return gzdeflate($output,5);}
header('Content-Encoding: deflate');
ob_start('compress_output_deflate');
ob_implicit_flush(0);
}
elseif(substr_count($compress,'gzip'))
{
function compress_output_gzip($output)
{return gzencode($output,5);}
header('Content-Encoding: gzip');
ob_start('compress_output_gzip');
ob_implicit_flush(0);
}
elseif(substr_count($compress,'x-gzip'))
{
function compress_output_x_gzip($output)
{
$x = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
$size = strlen($output);
$crc = crc32($output);
$output = gzcompress($output,5);
$output = substr($output, 0, strlen($output) - 5);
$x.= $output;
$x.= pack('V',$crc);
$x.= pack('V',$size);
return $x;
}

header('Content-Encoding: x-gzip');
ob_start('compress_output_x_gzip');
ob_implicit_flush(0);
}

// IE Отправляем text/html
if(substr_count($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
{header('Content-type: text/html; charset=utf-8');}
else
{header('Content-type: application/xhtml+xml; charset=utf-8');}

header('Cache-control: no-cache');
?>