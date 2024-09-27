<?php

Class Config {
	
	protected $configFile;
	
	function __construct(){
		$this->configFile = "Data/".nama_file."/config.json";
		
		if(!file_exists("Data/".nama_file)){
			system("mkdir ".nama_file);
			if(PHP_OS_FAMILY == "Windows"){
				system("move ".nama_file." Data");
			}else{
				system("mv ".nama_file." Data");
			}
		}
	}
	public function setConfig($key){
		
		if(!file_exists($this->configFile)){
			$config = [];
		}else{
			$config = json_decode(file_get_contents($this->configFile),1);
		}
		if(isset($config[$key])){
			return $config[$key];
		}else{
			$data = readline(Display::isi($key));
			print n;
			$config[$key] = $data;
			file_put_contents($this->configFile,json_encode($config,JSON_PRETTY_PRINT));
			return $data;
		}
	}
	public function getConfig($key){
		if(!file_exists($this->configFile)){
			$config = [];
		}else{
			$config = json_decode(file_get_contents($this->configFile),1);
		}
		return $config[$key];
	}
	public function removeConfig($key){
		$config = json_decode(file_get_contents($this->configFile),1);
		unset($config[$key]);
		file_put_contents($this->configFile,json_encode($config,JSON_PRETTY_PRINT));
	}
	public function HiddenConfig($key, $data){
		if(!file_exists($this->configFile)){
			$config = [];
		}else{
			$config = json_decode(file_get_contents($this->configFile),1);
		}
		if(!$config[$key]){
			$config[$key] = $data;
			file_put_contents($this->configFile,json_encode($config,JSON_PRETTY_PRINT));
		}
		return $config[$key];
	}
}