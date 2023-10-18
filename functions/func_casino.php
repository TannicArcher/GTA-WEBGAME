<?php

function checkfull()
{
global $b;
global $gover;

$gover = 1;
for ($ii = 0; $ii <= 8; $ii++)
{
if ($b[$ii] == '')
{
$gover = 0;
return;
}
}
}

function checkwin()
{
global $b;
global $gwin;
$c=1;
while ($c <= 2)
{
if ($c == 1)
$t='o';
else
$t='x';
if (
($b[0] == $t && $b[1] == $t && $b[2] == $t) || 
($b[3] == $t && $b[4] == $t && $b[5] == $t) || 
($b[6] == $t && $b[7] == $t && $b[8] == $t) || 
($b[0] == $t && $b[3] == $t && $b[6] == $t) || 
($b[1] == $t && $b[4] == $t && $b[7] == $t) ||
($b[2] == $t && $b[5] == $t && $b[8] == $t) ||
($b[0] == $t && $b[4] == $t && $b[8] == $t) ||
($b[2] == $t && $b[4] == $t && $b[6] == $t))
{
$gwin = strtoupper($t);
return;
}
$c++;
}
}

function compmove()
{
global $cmv;
global $b;
for ($c = 0; $c <=1; $c++)
{
if ($c == 0)
$t='o';
else
$t='x';

if ($b[0] == $t && $b[1] == $t && $b[2] == '')
$cmv = 2;
  if ($b[0] == $t && $b[1] == '' && $b[2] == $t)
$cmv = 1;
if ($b[0] == '' && $b[1] == $t && $b[2] == $t)
$cmv = 0;
if ($b[3] == $t && $b[4] == $t && $b[5] == '')
$cmv = 5;
if ($b[3] == $t && $b[4] == '' && $b[5] == $t)
$cmv = 4;
if ($b[3] == '' && $b[4] == $t && $b[5] == $t)
$cmv = 3;

if ($b[6] == $t && $b[7] == $t && $b[8] == '')
$cmv = 8;
if ($b[6] == $t && $b[7] == '' && $b[8] == $t)
$cmv = 7;
if ($b[6] == '' && $b[7] == $t && $b[8] == $t)
$cmv = 6;

if ($b[0] == $t && $b[3] == $t && $b[6] == '')
$cmv = 6;
if ($b[0] == $t && $b[3] == '' && $b[6] == $t)
$cmv = 3;
if ($b[0] == '' && $b[3] == $t && $b[6] == $t)
$cmv = 0;

if ($b[1] == $t && $b[4] == $t && $b[7] == '')
$cmv = 7;
if ($b[1] == $t && $b[4] == '' && $b[7] == $t)
$cmv = 4;
if ($b[1] == '' && $b[4] == $t && $b[7] == $t)
$cmv = 1;
if ($b[2] == $t && $b[5] == $t && $b[8] == '')
$cmv = 8;
if ($b[2] == $t && $b[5] == '' && $b[8] == $t)
$cmv = 5;
if ($b[2] == '' && $b[5] == $t && $b[8] == $t)
$cmv = 2;


if ($b[0] == $t && $b[4] == $t && $b[8] == '')
$cmv = 8;
if ($b[0] == $t && $b[4] == '' && $b[8] == $t)
$cmv = 4;
if ($b[0] == '' && $b[4] == $t && $b[8] == $t)
$cmv = 0;

if ($b[2] == $t && $b[4] == $t && $b[6] == '')
$cmv = 6;
if ($b[2] == $t && $b[4] == '' && $b[6] == $t)
$cmv = 4;
if ($b[2] == '' && $b[4] == $t && $b[6] == $t)
$cmv = 2;
if ($cmv <> '')
break;
}
}
function comprand()
{
global $b;
global $cmv;
srand ((double) microtime() * 1000000);
while (! isset($cmv))
{
$test=rand(0, 8);
if ($b[$test] == '')
$cmv=$test;
}
}
?>