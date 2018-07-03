<?php
	session_start();
	if(!empty($_POST["acc"]) && !empty($_POST["pw"]))
	{
		$result = mysqli_query($link, "select * from user where acc = '".$_POST["acc"]."'");
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			if($_POST["pw"] == $row["pw"])
			{
				$_SESSION["acc"] = $row["acc"];
				if($row["type"] == "1")	header("location:index.php?do=admin");
				else 	header("location:index.php");
			}
			else echo "<script>alert('密碼錯誤')</script>";
		}
		else	echo "<script>alert('查無帳號')</script>";
	}
	if(!empty($_GET["do"]) && $_GET["do"] == "logout")
	{
		unset($_SESSION["acc"]);
		header("location:index.php");
	}
	if(empty($_SESSION["visit"]))
	{
		$result = mysqli_query($link, "update visit set count = count +1 where time = '".$today."'");
		if(mysqli_affected_rows($link) < 1)
			$result = mysqli_query($link, "insert into visit values(null, '".$today."', '1')");
		
		$_SESSION["visit"] = "123";
	}
?>