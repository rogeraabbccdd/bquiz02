<p>請輸入信箱以查詢密碼</p>
<form action="api.php?do=mail" method="post">
	<input type="text" name="mail">
	<input type="submit" value="尋找">
	<br>
	<?php
		if(!empty($_GET["mail"]))	echo $_GET["mail"];
	?>
</form>