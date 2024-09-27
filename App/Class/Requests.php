<?php
Class Requests {
	static function Curl($url, $head =0, $post=0, $data_post=0)
	{
		while(true){
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_COOKIE,TRUE);
			if($post) {
				curl_setopt($ch, CURLOPT_POST, true);
			}
			if($data_post) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
			}
			if($head) {
				curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
			}
			curl_setopt($ch, CURLOPT_HEADER, true);
			$r = curl_exec($ch);
			$c = curl_getinfo($ch);
			if(!$c) return "Curl Error : ".curl_error($ch); else{
				$head = substr($r, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
				$body = substr($r, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
				curl_close($ch);
				if(!$body){
					print "Check your Connection!";
					sleep(2);
					print "\r                         \r";
					continue;
				}
				return array($head,$body);
			}
		}
	}
	static function get($url, $head =0)
	{
		return self::curl($url, $head);
	}
	static function post($url, $head =0, $data_post=0)
	{
		return self::curl($url, $head, 1, $data_post);
	}
}