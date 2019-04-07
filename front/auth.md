---
description: 編輯登入、註冊和忘記密碼
---

# 登入、註冊和忘記密碼

編輯`login.php`、`reg.php` 和 `forget.php`

## 登入
製作登入功能  

### 製作版面
開新檔 `login.php`，完成登入表單
```html
<fieldset>
	<legend>會員登入</legend>
	<form action="api.php?do=login" method="post">
	<table>
		<tr>
			<td>帳號</td>
			<td><input type="text" name="acc"></td>
		</tr>
		<tr>
			<td>密碼</td>
			<td><input type="password" name="pw"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="登入"><input type="reset" name="reset" value="清除"></td>
			<td><a href="index.php?do=forget">忘記密碼</a>&emsp;|&emsp;<a href="index.php?do=reg">尚未註冊</a></td>
		</tr>
	</table>
	</form>
</fieldset>
```

### 處理表單
在 `api.php`， 加入處理表單的程式碼  
```php
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
```

## 註冊
製作註冊功能  

### 製作版面
開新檔 `reg.php`，完成註冊表單  
```html
<p style="color:#F00">*請設定您要註冊的帳號及密碼(最長12個字元)</p>
<form action="api.php?do=reg" method="post" id="regform">
	<table>
		<tr>
			<td>Step1:登入帳號</td>
			<td><input type="text" name="acc"></td>
		</tr>
		<tr>
			<td>Step2:登入密碼</td>
			<td><input type="password" name="pw"></td>
		</tr>
		<tr>
			<td>Step3:再次確認密碼</td>
			<td><input type="password" name="pw2"></td>
		</tr>
		<tr>
			<td>Step4:信箱(忘記密碼時使用)</td>
			<td><input type="text" name="mail"></td>
		</tr>
	</table>
	<input type="button" value="註冊" id="reg">
	<input type="reset" value="清除">
</form>
<script>
	// 當點註冊時
	$("#reg").on("click", function(e){
		
		// 檢查空白
		var empty = false;
		$("form input").each(function(){
			if($(this).val() == "")	empty = true;
		})

		// 如果空白跳出提示，否則送出表單
		if(empty)	alert("不可空白");
		else $("#regform").submit();
	})
</script>
```

### 處理表單
在 `api.php`， 加入處理表單的程式碼  
```php
case "reg":
	// 檢查帳號是否重複
	$row = All("select * from user where acc = '".$_POST["acc"]."'")[0];
	// 帳號重複，跳出訊息後返回上一頁
	if(!empty($row["acc"]))	echo "<script>alert('不可重複'); window.history.back();</script>";
	// 帳號可用，寫入資料庫後跳出訊息，返回首頁
	else 
	{
		All("insert into user value(null, '".$_POST["acc"]."', '".$_POST["pw"]."', '".$_POST["mail"]."')");
		echo "<script>alert('註冊完成，歡迎加入'); window.location='index.php';</script>";
	}
	break;
```

## 忘記密碼
製作忘記密碼功能  

### 製作版面
開新檔 `forget.php`，完成忘記密碼表單  
```php
<p>請輸入信箱以查詢密碼</p>
<form action="api.php?do=mail" method="post">
	<input type="text" name="mail">
	<input type="submit" value="尋找">
	<br>
	<?php
		if(!empty($_GET["mail"]))	echo $_GET["mail"];
	?>
</form>
```

### 處理表單
在 `forget.php` 加入處理表單的程式碼  
```php
case "mail":
	$row = All("select * from user where mail = '".$_POST["mail"]."'")[0];
	if(!empty($row["pw"])) $mail = "您的密碼為：".$row["pw"];
	else $mail = "查無此資料";

	lo("index.php?do=forget&mail=".$mail);
	break;
```