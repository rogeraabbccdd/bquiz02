---
description: 編輯首頁index.php
---

# 首頁

編輯首頁index.php

## 頁面大小
版型大小超出題目規定的1024x768，所以必須調整版面大小  
找到 `<div id="all">`，加入題目規定的版面尺寸
```html
<div id="all" style="height:768px; width:1024px">
```

## 標題區

先在頁首引用必要程式碼
```php
<?php
	include("sql.php");

	// 今天日期
	$m = date("m 月 d 號 l", $today);

	// 總共訪客
	$totalvis = All("select sum(count) as count from visit")[0][0];
	
	// 今日訪客
	$todayvis = All("select * from visit where time = '".$today."'")[0]["count"];
?>
```
然後找到 `<div id="title">`，代入日期、訪客數和回首頁按鈕
```php
<div id="title">
	<?=$m?> | 今日瀏覽: <?=$todayvis?> | 累積瀏覽: <?=$totalvis?> 
	<a href="index.php" style="float:right">回首頁</a>
</div>
```
最後找到`<div id="title2">`，顯示標題圖片
```html
<div id="title2">
    <img src="./home_files/02B01.jpg" width="100%" height="100%" alt="健康促進網 - 回首頁" title="健康促進網 - 回首頁">
</div>
```

## 主選單區
找到 `<div class="hal" id="lef">` 主選單區  
這題前台後台的版型都一樣，只有選單和內容不同  
> 我的解法是先複製一個前台選單，修改為後台的項目後，在每個do前面加一個 `a` 代表後台頁，再以do開頭第一個字是不是 `a` 來判斷應該顯示哪組選單  

```php
<div class="hal" id="lef">
	<?php
		// 如果有 $_GET["do"] ，且開頭第一個字為a，顯示後台選單
		if(!empty($_GET["do"]) && mb_substr($_GET["do"], 0, 1) == "a")
		{
			?>
			<a class="blo" href="?do=aacc">帳號管理</a>
			<a class="blo" href="?do=apo">分類網誌</a>
			<a class="blo" href="?do=anews">最新文章管理</a>
			<a class="blo" href="?do=aknow">講座管理</a>
			<a class="blo" href="?do=aque">問卷管理</a>
			<?php
		}
		// 若不是則顯示前台選單
		else
		{
			?>
			<a class="blo" href="?do=po">分類網誌</a>
			<a class="blo" href="?do=news">最新文章</a>
			<a class="blo" href="?do=pop">人氣文章</a>
			<a class="blo" href="?do=know">講座訊息</a>
			<a class="blo" href="?do=que">問卷調查</a>
			<?php
		}
	?>
</div>
```

## 動態文字廣告
找到 `<div class="hal" id="main">` 內容區  
在 `span` 標籤前面加入動態文字廣告
```html
<div class="hal" id="main">
	<div>
	<!-- 
		動態文字廣告放這裡 
		如果動態文字廣告和下面span標籤的寬度和是100%時，span標籤的字會跑到下一行，所以設80就好
	-->
	<marquee width="80%">請民眾踴躍投稿電子報，讓電子報成為大家相互交流、分享的園地！詳見最新文章</marquee>
	<span style="width:18%; display:inline-block;">
		<a href="?do=login">會員登入</a>
	</span>
```

## 登入登出區
編輯會員登入`span`標籤的內容  
之後製作登入登出頁面時再處理session
```php
<span style="width:18%; display:inline-block;">
	<?php
		// 如果沒有登入session
		if(empty($_SESSION["id"]))
		{
			?>
			<a href="?do=login">會員登入</a>
			<?php
		}
		// 如果有登入
		else
		{
			// 顯示登出按鈕，導到api.php處理資料
			// 資料處理的程式碼到下一步做登入註冊時再寫
			echo "歡迎，".$_SESSION["acc"]."<a href='api.php?do=logout'>登出</a>";
			
			// 如果帳號的id為1，代表是管理者，顯示管理按鈕
			// do的admin剛好為a開頭，所以選單區會顯示後台選單
			if($_SESSION["id"] == 1)	echo "<a href='?do=admin'>管理</a>";
		}
	?>
</span>
```

## 處理登出
開心檔 `api.php`，處理登出  
以 `$_GET["do"]` 判斷要執行什麼動作  
```php
<?php
	include("sql.php");
	
	switch($_GET["do"])
	{
		case "logout":
			session_unset();
			session_destroy();
			lo("index.php");
			break;
	}
?>
```

## 內容區
在上面登入登出區下面有個 `<div class="">`，為網頁內容區
```php
<div class="">
	<?php
		// 如果有do
		if(!empty($_GET["do"])){
			// 管理後台首頁只有一行字，直接echo就好
			if($_GET["do"] == "admin") echo "請選擇管理項目";
			// include檔名為do變數的php
			// 前台最新消息和一些後台不用做，如果怕空白的話也可以寫判斷
			// 不寫也沒關係，評審時不小心點到看到錯誤也不能扣分
			else	include($_GET["do"].".php");
		}
		// 沒有do，顯示主題內容(四個標籤頁)
		else	include("main.html");
	?>
</div>
```

## 頁尾版權區
將2014改為目前年分

```php
Copyright © 2019健康促進網社群平台
```