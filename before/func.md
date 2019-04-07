---
description: SQL資料庫"測試"完成後，開始"測試"PHP，寫好共用function以及資料庫連接、session等程式碼
---

# 編寫共用程式碼

## 建立檔案sql.php

建立檔案sql.php，放入共用程式碼

## 寫入必要程式碼

```php
/*** 開啟資料庫連接 ***/
$pdo = new PDO("mysql:host=localhost;dbname=dbxx;charset=utf8", "root", "");

/* 開始session */
session_start();

// 今天日期，因為題目要計算各日進站人數
$today = strtotime('today GMT+8');
```

## 寫入function

由於考試有四個小時的時間限制，將一些常用語法寫成 function 來縮短字數，節省打字時間  
```php
// 節省 fetchAll 字數
// 只寫fetchAll就夠了，因為fetchAll有含query，所以更新和刪除資料也能用
function All($sql)
{
	global $pdo;
	return $pdo->query($sql)->fetchAll();
}

// 節省 header跳頁 字數
// 其他題版型自訂的Javascript跳頁函式名稱也叫lo
function lo($l)
{
	return header("location:".$l);
}
```

## 寫入session控制

```php
// 每日進站人數
// 以 $_SESSION["v"] 判斷是否已經算過人數
if(empty($_SESSION["v"]))
{
	// 隨便給值，不是空值就好
	$_SESSION["v"] = "123";
	
	// 資料庫更新今日人數
	All("update visit set count = count + 1 where time = '".$today."'");

	// 如果更新指令沒有影響到任何資料，代表今天還沒有訪客
	// 所以新增今天的欄位
	if($pdo->rowCount() < 1)
		$result = All("insert into visit values(null, '".$today."', '1')");
}
```

