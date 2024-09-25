<?php

if($argv[1]){
	if($argv[1] == "error"){
	}else{
		exit("usage: php ".$argv[0]." error \n");
	}
}else{
	error_reporting(0);
}

// autoload class
require "App/autoload.php";

// color
@iewil::start();

// bot
require "App/main.php";
