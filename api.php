<?php
	include("sql.php");
	
	switch($_GET["do"])
	{
		case "reg":
			$row = All("select * from user where acc = '".$_POST["acc"]."'")[0];
			if(!empty($row["acc"]))	echo "<script>alert('不可重複'); window.history.back();</script>";
			else 
			{
				All("insert into user value(null, '".$_POST["acc"]."', '".$_POST["pw"]."', '".$_POST["mail"]."')");
				echo "<script>alert('註冊完成，歡迎加入'); window.location='index.php';</script>";
			}
			break;
		
		case "mail":
			$row = All("select * from user where mail = '".$_POST["mail"]."'")[0];
			if(!empty($row["pw"])) $mail = "您的密碼為：".$row["pw"];
			else $mail = "查無此資料";

			lo("index.php?do=forget&mail=".$mail);
			break;

		case "login":
			$row = All("select * from user where acc = '".$_POST["acc"]."'")[0];
			if(!empty($row["acc"]))
			{
				if($row["pw"] != $_POST["pw"])
				{
					?>
					<script>
						alert("密碼錯誤");
						window.location = "index.php?do=login";
					</script>
					<?php
				}
				else
				{
					$_SESSION["acc"] = $row["acc"];
					$_SESSION["id"] = $row["id"];
					lo("index.php");
				}
			}
			else 
			{
				?>
				<script>
					alert("查無帳號");
					window.location = "index.php?do=login";
				</script>
				<?php
			}
			break;
	
		case "logout":
			session_unset();
			session_destroy();
			lo("index.php");
			break;

		case "good":
			// 收回讚
			if($_GET["type"] == "2")
			{
				All("update article set good = good -1 where id = '".$_POST["id"]."'");
				All("delete from good where user = '".$_SESSION["id"]."' and article = '".$_POST["id"]."'");
			}
			// 讚
			else
			{
				All("update article set good = good +1 where id = '".$_POST["id"]."'");
				All("insert into good values (null, '".$_SESSION["id"]."', '".$_POST["id"]."')");
			}
			break;

		case "vote":
			All("update que set vote = vote + 1 where id='".$_POST["vote"]."'");
			lo("index.php?do=que");
			break;

		case "delacc":
			foreach($_POST["del"] as $del)
			{
				All("delete from user where id = '".$del."'");
			}
			lo("index.php?do=aacc");
			break;

		case "anews":
			All("update article set display = 0");
			foreach($_POST["display"] as $dis){
				All("update article set display = 1 where id = '".$dis."'");
			}
			foreach($_POST["del"] as $del){
				All("delete from article where id = '".$dis."'");
			}
			lo("index.php?do=anews");
			break;

		case "aque":
			$result = All("insert into que values(null, '".$_POST["quename"]."', '0', '0')");
			$id = $pdo->lastInsertId();
			foreach($_POST["sel"] as $sell)
			{
				$result = All("insert into que values(null, '".$sell."', '".$id."', '0')");
			}
			lo("index.php?do=aque");
			break;
	}
?>