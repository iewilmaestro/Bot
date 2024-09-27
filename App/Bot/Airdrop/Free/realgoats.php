<?php
const
host = "https://api-me.goatsbot.xyz/",
register_link = "https://t.me/realgoats_bot/run?startapp=7d995a63-6faf-48d5-a3d7-eb77bd1bc110",
youtube = "https://youtube.com/@iewil";

date_default_timezone_set("UTC");

Display::Ban(1);
cookie:
$config = new Config();

if(empty($config->getConfig('Autorization'))){
	Display::Cetak("Register",register_link);
	print Display::Line();
}
//$cookie = $config->setConfig("cookie");
//$uagent = $config->setConfig("user_agent");
//$captcha = new Captcha();

ulang:
$token = $config->setConfig("Autorization");
if(!preg_match('/Bearer/', $token)){
	$config->removeConfig('Autorization');
	print Display::Error("isi Authorization dengan awal Bearer\n");
	goto ulang;
}
Display::Ban(1);


function spasi($string, $spasi){
	return $string.str_repeat(" ",$spasi-strlen($string))."| ";
}
function kolom($urutan, $wl, $wr, $bal){
	$spasi = strlen($bal)+2;
	$urutan = spasi($urutan, $spasi);
	$wl = spasi($wl, $spasi);
	$wr = spasi($wr, $spasi);
	$bal = spasi($bal, $spasi);
	return $urutan.$wl.$wr.$bal;
}
$h = [
	'Accept: application/json, text/plain, */*',
	'Content-Type: application/json',
	'origin: https://dev.goatsbot.xyz',
	'Authorization: '.$token,
	'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0'
];

$r = json_decode(Requests::get(host.'users/me', $h)[1],1);
if($r['banned']){
	print Display::Error("Account has been Banned\n");
	$config->removeConfig('Autorization');
	exit;
}
$bal = $r['balance'];
$user = $r['user_name'];
if(!$user){
	print Display::Error("Autorization expired\n");
	$config->removeConfig('Autorization');
	goto ulang;
}
Display::Cetak("Username", $user);
Display::Cetak("Balance", $bal);
print Display::Line();

Display::Menu(1,"special mission");
Display::Menu(2,"mission");
Display::Menu(3,"dice");
print Display::Line();

$switch = readline(Display::Isi("Number"));
print Display::Line();

if($switch == 1){
	while(true){
		$r = json_decode(Requests::get('https://api-mission.goatsbot.xyz/missions/user', $h)[1],1);
		$special_mision = $r["SPECIAL MISSION"][0];
		$id = $special_mision["_id"];
		if(!$id)goto ulang;
		$time = $special_mision["next_time_execute"];
		$tmr=$time-time();
		if($tmr>0){
			for($i=$tmr+rand(2,5); $i>0; $i--){
				print $i."\r";
				sleep(1);
			}
		}
		$r = json_decode(Requests::post('https://dev-api.goatsbot.xyz/missions/action/'.$id, $h)[1],1);
		if($r['status'] == "success"){
			print Display::Sukses("success");
		}
		$bal = json_decode(Requests::get('https://api-me.goatsbot.xyz/users/me', $h)[1],1)['balance'];
		Display::Cetak("Balance",$bal);
		print Display::Line();
	}
	exit;
}elseif($switch == 2){
	$r = json_decode(Requests::get('https://api-mission.goatsbot.xyz/missions/user', $h)[1],1);
	unset($r["SPECIAL MISSION"]);
	foreach($r as $label){
		foreach($label as $mission){
			if($mission['status'])continue;
			$id = $mission["_id"];
			if(!$id)continue;
			$r = json_decode(Requests::post('https://dev-api.goatsbot.xyz/missions/action/'.$id, $h)[1],1);
			if($r['status'] == "success"){
				print "success\n";
			}
			$bal = json_decode(Requests::get('https://api-me.goatsbot.xyz/users/me', $h)[1],1)['balance'];
			print "Balance : $bal\n";
			print str_repeat('~', 50)."\n";
			sleep(2);
		}
	}
	exit;
}elseif($switch == 3){
	
	$maxwin = 1000;//1000x bet
	$progress = 0;
	
	$putaran = 0;
	$putaran_win = 0;
	$putaran_lose = 0;
	
	isi_bet:
	print "isi Bet dengan angka min 1 = 1 Goats\n";
	print "win chance 49% | iflose: 2x bet | ifwin: normal bet\n";
	print "stop after win X$maxwin bet total\n";
	if($config->getConfig('Bet')){
		$confirm = readline("apakah mau ganti bet? (y/n):");
		if(strtolower($confirm[0]) == "y"){
			$config->removeConfig('Bet');
		}
	}

	$betawal = $config->setConfig("Bet");
	if(is_numeric($betawal)){
		print Display::Line();
	}else{
		$config->removeConfig('Bet');
		print "isi angka woy!!";
		print Display::Line();
		goto isi_bet;
	}

	if($betawal > $bal){
		$config->removeConfig('Bet');
		print "Bet lebih besar dari saldo njer\n";
		goto isi_bet;
	}
	//setting
	$bet = $betawal;
	$maxwin = $bet*$maxwin;
	
	//exsekusi
	while(true){
		$data = '{"point_milestone":49,"is_upper":false,"bet_amount":'.$bet.'}';
		$r = json_decode(Requests::post('https://api-dice.goatsbot.xyz/dice/action', $h, $data)[1],1);
		$reward = $r['dice']['reward'];
		if(!$r['dice'])goto ulang;
		$balance = $r['user']['balance'];
		if($reward){
			$putaran_win++;
			$progress = $progress+$bet;
			print kolom($putaran, "Win", "+".$bet, $balance)."\n";
			$bet = $betawal;
		}else{
			$putaran_lose++;
			$progress = $progress-$bet;
			print kolom($putaran, "Lose", "-".$bet, $balance)."\n";
			//print $putaran."| Lose | - ".$bet." | ".$balance."\n";
			$bet = $bet*2;
		}
		sleep(1);
		if($bet > $balance)exit("bankrut\n");
		if($progress >= $maxwin){
			print Display::Line();
			print "Balance awal: $bal\n";
			print "Total putaran: ".($putaran+1)."\n";
			print "Putaran Win: $putaran_win\n";
			print "Putaran Lose: $putaran_lose\n";
			print "Balance akhir: $balance\n";
			exit;
		}
		$putaran++;
	}
}else{
	exit("Tolol!\n");
}