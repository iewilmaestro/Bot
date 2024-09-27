<?php

if(@iewil::Env()['VERSI'] < @iewil::Envx())
{
	print Display::Error("Progres update Script\npliss dont stop this progres\n");
	system("git reset --hard");
	system("git pull");
	print Display::Line();
	exit(Display::Sukses("re run script if return succes"));
}

if (!file_exists(".git"))
{
	print "How to install tool".n;
	print '$ pkg install git'.n.n;
	print '$ git clone https://github.com/iewilmaestro/Bot'.n;
	print '$ cd Bot'.n;
	print '$ php run.php'.n;
	exit(Display::Error("please install the tool correctly\n"));
}

if (!file_exists("Data")) 
{
	system("mkdir Data");
}

@license::_start();
Display::Ban();

menu_pertama:
print mp.str_pad(strtoupper("menu"),44, " ", STR_PAD_BOTH).d.n;
print Display::Line();
$r = scandir("App/Bot");$a = 0;
foreach($r as $act){
	if($act == '.' || $act == '..') continue;
	$menu[$a] =  $act;
	Display::Menu($a, $act);
	$a++;
}
$pil = readline(Display::Isi("Nomor"));
print Display::Line();
if($pil == '' || $pil >= Count($menu))exit(Display::Error("Tolol"));

menu_kedua:
print mp.str_pad(strtoupper("menu -> ".$menu[$pil]),44, " ", STR_PAD_BOTH).d.n;
print Display::Line();
$r = scandir("App/Bot/".$menu[$pil]);$a = 0;
foreach($r as $act){
	if($act == '.' || $act == '..') continue;
	$menu2[$a] =  $act;
	Display::Menu($a, $act);
	$a++;
}
Display::Menu($a, m.'<< Back');
$pil2 = readline(Display::Isi("Nomor"));
print Display::Line();
if($pil2 == '' || $pil2 > Count($menu2))exit(Display::Error("Tolol"));
if($pil2 == Count($menu2))goto menu_pertama;
if(isset(explode('-',$menu2[$pil2])[1]))exit(Display::Error("Tolol"));

print mp.str_pad(strtoupper('menu -> '.$menu[$pil].' -> '.$menu2[$pil2]),44, " ", STR_PAD_BOTH).d.n;
print Display::Line();
$r = scandir("App/Bot/".$menu[$pil]."/".$menu2[$pil2]);$a=0;
foreach($r as $act){
	if($act == '.' || $act == '..') continue;
	$menu3[$a] =  $act;
	Display::Menu($a, Display::Clean($act));
	$a++;
}
Display::Menu($a, m.'<< Back');
$pil3 = readline(Display::Isi("Nomor"));
print Display::Line();
if(isset($menu3) == null)exit(Display::Error("No content\n"));
if($pil3 == '' || $pil3 > Count($menu3))exit(Display::Error("Tolol"));
if($pil3 == Count($menu3))goto menu_kedua;
if(isset(explode('-',$menu3[$pil3])[1]))exit(Display::Error("Tolol"));

define("nama_file",Display::clean($menu3[$pil3]));
require "App/Bot/".$menu[$pil]."/".$menu2[$pil2]."/".$menu3[$pil3];