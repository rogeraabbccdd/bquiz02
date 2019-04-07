<?php
	$pdo = new PDO("mysql:host=localhost;dbname=dbxx2;charset=utf8", "root", "");
	session_start();
	
	$today = strtotime('today GMT+8');

	function All($sql)
	{
		global $pdo;
		return $pdo->query($sql)->fetchAll();
	}

	function lo($l)
	{
		return header("location:".$l);
	}

	if(empty($_SESSION["v"]))
	{
		$_SESSION["v"] = "123";
		$num = $pdo->exec("update visit set count = count + 1 where time = '".$today."'");
		if($num < 1)
			$result = All("insert into visit values(null, '".$today."', '1')");
	}
?>