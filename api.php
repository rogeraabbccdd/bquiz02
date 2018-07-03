<?php
	include "sql.php";
	if(!empty($_GET["do"]))
	{
		if($_GET["do"]== "reg")
		{
			$result = mysqli_query($link, "select * from user where acc = '".$_POST["acc"]."'");
			if(mysqli_num_rows($result) > 0)	echo "repeat";
			else
			{
				$result = mysqli_query($link, "insert into user values (null, '".$_POST["acc"]."', '".$_POST["pw"]."', '".$_POST["mail"]."', '0')");
				echo "success";
			}
		}
		elseif($_GET["do"]== "like")
		{
			if($_POST["type"] == 1)
			{
				$result = mysqli_query($link, "update article set good = good -1 where id = '".$_POST["id"]."'");
				$result = mysqli_query($link, "delete from good where user = '".$_SESSION["acc"]."' and article = '".$_POST["id"]."'");
			}
			else
			{
				$result = mysqli_query($link, "update article set good = good +1 where id = '".$_POST["id"]."'");
				$result = mysqli_query($link, "insert into good values (null, '".$_SESSION["acc"]."', '".$_POST["id"]."')");
			}
		}
		elseif($_GET["do"]== "vote")
		{
			$result = mysqli_query($link, "update que set vote = vote + 1 where id='".$_POST["vote"]."'");
			header("location:index.php?do=que");
		}
		elseif($_GET["do"]== "delacc")
		{
			$del = $_POST["del"];
			foreach($del as $dell)
			{
				$result = mysqli_query($link, "delete from user where id = '".$dell."'");
			}
			header("location:index.php?do=aacc");
		}
		elseif($_GET["do"]== "anews")
		{
			$del = $_POST["del"];
			foreach($del as $dell)
			{
				$result = mysqli_query($link, "delete from user where id = '".$dell."'");
			}
			
			$id = $_POST["id"];
			foreach($id as $idd)
			{
				$result = mysqli_query($link, "update article set display = 0 where id = '".$idd."'");
			}
			
			$display = $_POST["display"];
			foreach($display as $dis)
			{
				$result = mysqli_query($link, "update article set display = 1 where id = '".$dis."'");
			}
			header("location:index.php?do=anews");
		}
		elseif($_GET["do"]== "aque")
		{
			$name = $_POST["quename"];
			$result = mysqli_query($link, "insert into que values(null, '".$name."', '0', '0')");
			$id = mysqli_insert_id($link);
			
			$sel = $_POST["sel"];
			foreach($sel as $sell)
			{
				if(!empty($sell))
					$result = mysqli_query($link, "insert into que values(null, '".$sell."', '".$id."', '0')");
			}
			header("location:index.php?do=aque");
		}
	}
?>