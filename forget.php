<p>請輸入信箱以查詢密碼</p>
<form action="" method="post">
<input type="text" name="forgetmail">
<input type="submit" value="尋找">
<br>
<?php
	if(!empty($_POST["forgetmail"]))
	{
		$result = mysqli_query($link, "select * from user where mail = '".$_POST["forgetmail"]."'");
		if(mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_array($result);
			echo "您的密碼為".$row["pw"];
		}
		else echo "查無此資料";
	}
?>
</form>