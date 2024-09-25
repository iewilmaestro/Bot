<?php

class sqlServer {
	
	protected $host, $user, $password, $server, $conn;
	
	function __construct()
	{
		$this->host = "iewilbot.my.id";
		$this->user = "iewilbot_view";
		$this->password = "o;}uyd3Xr6*y";
		$this->server = "iewilbot_lib";
		$this->conn = mysqli_connect($this->host, $this->user, $this->password, $this->server);
	}
	private function query($query) 
	{
		$result = mysqli_query($this->conn, $query);
		$rows = [];
		while( $row = mysqli_fetch_assoc($result) ) {
			$rows[] = $row;
		}
		return $rows;
	}
	public function ShowList()
	{
		$query = "SELECT * FROM `List`
		ORDER BY `title` ASC";
		return $this->query($query);
	}
	public function Search($category, $captcha)
	{
		$query = "SELECT * FROM `List` 
		WHERE `category` = '".$category."'
		AND `captcha` = '".$captcha."'
		ORDER BY `title` ASC";
		return $this->query($query);
	}
}