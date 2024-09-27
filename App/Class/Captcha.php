<?php

class Captcha {
	private $url,$key,$provider, $function;
	
	public function __construct(){
		$this->function = new Config();
		if(empty($this->function->getConfig('type'))){
			print "Select Apikey\n";
			Display::Menu(1, "Multibot");
			Display::Menu(2, "Xevil");
            print "Please input number only\n";
            $this->function->setConfig("type");
			print Display::Line();
		}
		if($this->function->getConfig("type") == 1){
            $this->url = 'http://api.multibot.in/';
			Display::Cetak("Register","http://api.multibot.in");
			$this->key = $this->function->setConfig("multibot_apikey");
			$this->provider = $this->function->HiddenConfig("provider", "Multibot");
        }
        else{
            $this->url = 'https://sctg.xyz/';
			Display::Cetak("Register","t.me/Xevil_check_bot?start=1204538927");
			$this->key = $this->function->setConfig("xevil_apikey")."|SOFTID1204538927";
			$this->provider = $this->function->HiddenConfig("provider", "Xevil");
        }
	}
	private function in_api($content, $method, $header = 0){$param = "key=".$this->key."&json=1&".$content;if($method == "GET")return json_decode(file_get_contents($this->url.'in.php?'.$param),1);$opts['http']['method'] = $method;if($header) $opts['http']['header'] = $header;$opts['http']['content'] = $param;return file_get_contents($this->url.'in.php', false, stream_context_create($opts));}
	private function res_api($api_id){$params = "?key=".$this->key."&action=get&id=".$api_id."&json=1";return json_decode(file_get_contents($this->url."res.php".$params),1);}
	private function solvingProgress($xr,$tmr, $cap){if($xr < 50){$wr=h;}elseif($xr >= 50 && $xr < 80){$wr=k;}else{$wr=m;}$xwr = [$wr,p,$wr,p];$sym = [' ─ ',' / ',' │ ',' \ ',];$a = 0;for($i=$tmr*4;$i>0;$i--){print $xwr[$a % 4]." Bypass $cap $xr%".$sym[$a % 4]." \r";usleep(100000);if($xr < 99)$xr+=1;$a++;}return $xr;}
	private function getResult($data ,$method, $header = 0){$cap = $this->filter(explode('&',explode("method=",$data)[1])[0]);$get_res = $this->in_api($data ,$method, $header);if(is_array($get_res)){$get_in = $get_res;}else{$get_in = json_decode($get_res,1);}if(!$get_in["status"]){$msg = $get_in["request"];if($msg){print Display::Error($msg.n);}elseif($get_res){print Display::Error($get_res.n);}else{print Display::Error("in_api @".$this->provider." something wrong\n");}return 0;}$a = 0;while(true){echo " Bypass $cap $a% |   \r";$get_res = $this->res_api($get_in["request"]);if($get_res["request"] == "CAPCHA_NOT_READY"){$ran = rand(5,10);$a+=$ran;if($a>99)$a=99;echo " Bypass $cap $a% ─ \r";$a = $this->solvingProgress($a,5, $cap);continue;}if($get_res["status"]){echo " Bypass $cap 100%";sleep(1);print "\r                              \r";print h."[".p."√".h."] Bypass $cap success";sleep(2);print "\r                              \r";return $get_res["request"];}print m."[".p."!".m."] Bypass $cap failed";sleep(2);print "\r                              \r";print Display::Error($cap." @".$this->provider." Error\n");return 0;}}
	private function filter($method){if($method == "userrecaptcha")return "RecaptchaV2";if($method == "hcaptcha")return "Hcaptcha";if($method == "turnstile")return "Turnstile";if($method == "universal" || $method == "base64")return "Ocr";if($method == "antibot")return "Antibot";if($method == "authkong")return "Authkong";if($method == "teaserfast")return "Teaserfast";}
	
	public function getBalance(){$res =  json_decode(file_get_contents($this->url."res.php?action=userinfo&key=".$this->key),1);return $res["balance"];}
	public function RecaptchaV2($sitekey, $pageurl){$data = http_build_query(["method" => "userrecaptcha","sitekey" => $sitekey,"pageurl" => $pageurl]);return $this->getResult($data, "GET");}
	public function Hcaptcha($sitekey, $pageurl ){$data = http_build_query(["method" => "hcaptcha","sitekey" => $sitekey,"pageurl" => $pageurl]);return $this->getResult($data, "GET");}
	public function Turnstile($sitekey, $pageurl){$data = http_build_query(["method" => "turnstile","sitekey" => $sitekey,"pageurl" => $pageurl]);return $this->getResult($data, "GET");}
	public function Authkong($sitekey, $pageurl){$data = http_build_query(["method" => "authkong","sitekey" => $sitekey,"pageurl" => $pageurl]);return $this->getResult($data, "GET");}
	public function Ocr($img){if($this->provider == "Xevil"){$data = "method=base64&body=".$img;}else{$data = http_build_query(["method" => "universal","body" => $img]);}return $this->getResult($data, "POST");}
	public function AntiBot($source){$main = explode('"',explode('data:image/png;base64,',explode('Bot links',$source)[1])[1])[0];if(!$main)return 0;if($this->provider == "Xevil"){$data = "method=antibot&main=$main";}else{$data["method"] = "antibot";$data["main"] = $main;}$src = explode('rel=\"',$source);foreach($src as $x => $sour){if($x == 0)continue;$no = explode('\"',$sour)[0];if($this->provider == "Xevil"){$img = explode('\"',explode('data:image/png;base64,',$sour)[1])[0];$data .= "&$no=$img";}else{$img = explode('\"',explode('src=\"',$sour)[1])[0];$data[$no] = $img;}}if($this->provider == "Xevil"){$res = $this->getResult($data, "POST");}else{$data = http_build_query($data);$ua = "Content-type: application/x-www-form-urlencoded";$res = $this->getResult($data, "POST", $ua);}if($res)return "+".str_replace(",","+",$res);return 0;}
	public function Teaserfast($main, $small){if($this->provider == "Multibot"){return ["error"=> true, "msg" => "not support key!"];}$data = http_build_query(["method" => "teaserfast","main_photo" => $main,"task" => $small]);$ua = "Content-type: application/x-www-form-urlencoded";return $this->getResult($data, "POST",$ua);}
}