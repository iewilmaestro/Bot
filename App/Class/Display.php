<?php

class Display {
	static function Menu($no, $title){print h."---[".p."$no".h."] ".k."$title\n";}
	static function Error($except){return m."---[".p."!".m."] ".p.$except;}
	static function Sukses($msg){return h."---[".p."✓".h."] ".p.$msg.n;}
	static function Cetak($label, $msg = "[No Content]"){$len = 9;$lenstr = $len-strlen($label);print h."[".p.$label.h.str_repeat(" ",$lenstr)."]─> ".p.$msg.n;}
	static function Isi($msg){return m."╭[".p."Input ".$msg.m."]".n.m."╰> ".h;}
	static function Title($activitas){print bp.str_pad(strtoupper($activitas),44, " ", STR_PAD_BOTH).d.n;}
	static function authBan($title, $str){$title_len_s = 8;$strlen_s = 19;$title_len = $title_len_s - strlen($title);$strlen = $strlen_s - strlen($str);return bp." ".$title.str_repeat(" ",$title_len).d.pb." ".$str.str_repeat(" ",$strlen).d.n;}
	static function clean($extensi){return str_replace(".php","",$extensi);}
	static function Ban($sc = 0){
		system("clear");
		print hp.str_pad("V".Iewil::Env()['VERSI'],44, " ", STR_PAD_BOTH).d.n;
		$line = c;
		print c."──────────────┬".str_repeat("─",29).n;
		print m."<?╔╦╗╔═╗╔═╗".p."╦  ".$line."│".self::authBan("Author", "@fat9ght");
		print m."   ║ ║ ║║ ".p."║║  ".$line."│".self::authBan("Channel", "t.me/MaksaJoin");
		print m."   ╩ ╚═╝╚".p."═╝╩═╝".$line."│".self::authBan("Youtube", "youtube.com/@iewil");
		print m."  ╔═╗╦ ".p."╦╔═╗   ".$line."│".mp.str_pad("!--- 2022 REBORN >", 29, " ", STR_PAD_BOTH).d.n;
		print m."  ╠═╝╠".p."═╣╠═╝   ".$line."│".up.str_pad("@PetapaGenit2, @Zhy_08", 29, " ", STR_PAD_BOTH).d.n;
		print m."  ╩  ".p."╩ ╩╩  ?> ".$line."│".up.str_pad("@IPeop, @MetalFrogs", 29, " ", STR_PAD_BOTH).d.n;
		print c."──────────────┴".str_repeat("─",29).n;
		if($sc){
			print hp.str_pad(strtoupper(nama_file),44, " ", STR_PAD_BOTH).d.n;
			print c.str_repeat('─',44).n;
		}
	}
	static function Line(){return c.str_repeat('─',44).n;}
}