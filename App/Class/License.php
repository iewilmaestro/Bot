<?php

class license {
	
	static function ShortExe($key){
		$link = "https://iewilbot.my.id/raw/?key=".$key;
		$long_url = urlencode($link);
		$api_token = '12c11d8a2bd717fc085c92ebaf6ca4424cea7874';
		$api_url = "https://exe.io/api?api={$api_token}&url={$long_url}";
		$result = @json_decode(file_get_contents($api_url),TRUE);
		if($result["shortenedUrl"]){
			return $result["shortenedUrl"];
		}
	}
	static function ShortOuo($key){
		$link = "https://iewilbot.my.id/raw/?key=".$key;
		return file_get_contents("http://ouo.io/api/wLTrHNBd?s=".$link);
	}
	static function _start(){
		$api = json_decode(file_get_contents("http://ip-api.com/json"),1);
		if($api){
			$tz = $api["timezone"];
			date_default_timezone_set($tz);
		}else{
			date_default_timezone_set("UTC");
		}
		
		if(!file_exists("Data/License")){
			Display::Ban();
			print Display::Error("Ups Please Activasi first!\n");
			Display::Cetak("Channel","https://t.me/MaksaJoin");
			print Display::line();
			$txt = md5(date("c"));
			$key = md5($txt);
			$link = self::ShortExe($txt);
			print "Licensi Link: ".n;
			Display::Menu(1, $link);
			Display::Menu(2, self::ShortOuo($txt));
			print m."Dapatkan lisensi code dari link di atas!".n;
			$x = readline(Display::Isi("License"));
			print Display::line();
			if($x == $key){
				print Display::Sukses("Terimakasih sudah Menggunakan script saya ☺");
				sleep(3);
				file_put_contents("Data/License",$key);
			}else{
				print Display::Error("😤 Ups Lisensi yang anda masukkan salah!\n");
				exit;
			}
		}
	}
}