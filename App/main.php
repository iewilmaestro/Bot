<?php

if (!file_exists(".git"))
{
	print "How to install tool".n;
	print '$ pkg install git'.n.n;
	print '$ git clone https://github.com/iewilmaestro/Bot'.n;
	print '$ cd Bot'.n;
	print '$ php run.php'.n;
	exit("please install the tool correctly\n");
}

if (!file_exists("Data")) 
{
	system("mkdir Data");
}

@license::_start();

$sqlServer = new sqlServer();
$list = $sqlServer->ShowList();

$key = 1;
$result = [];
foreach($list as $value){
	if(!in_array($value['category'], $result)){
		$result[$key] = $value['category'];
		Display::Menu($key, $value['category']);
		$key++;
	}
}

$pil = readline(Display::Isi("Number"));
print Display::Line();

$category = $result[$pil];

Display::Menu(1, "Apikey");
Display::Menu(2, "Free");
$pil = readline(Display::Isi("Number"));
print Display::Line();
$captcha = ($pil==1)? "true":"false";

$num = 1;
$list = $sqlServer->Search($category, $captcha);
foreach($list as $value){
	$title[$num] = $value;
	Display::Menu($num, $value['title']);
	$num++;
}
$pil = readline(Display::Isi("Number"));
print Display::Line();
$final = $title[$pil];

Define("title",$final['title']);
Define("register",$final['regis']);
Define("youtube",$final['youtube']);
Define("versi",$final['version']);
Define("status",$final['status']);
Define("lastupdate",$final['timestamp']);

eval(base64_decode($final['bot']));