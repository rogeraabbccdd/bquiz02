---
description: 編輯最新文章
---

# 最新文章

:::tip TIP
題目說明有提到，文章超過五則時要顯示分頁  
但是文章只有四則，不用做分頁，做個大數字1就好  
:::

開新檔 `news.php`，製作最新文章  

## 版面
在 `news.php`，製作最新文章版面  
```php
<fieldset>
	<legend>目前位置：首頁 > 最新文章區</legend>
	<table style="table-layout:fixed">
		<tr>
			<td>標題</td>
			<td>內容</td>
		</tr>
		<?php
			$result = All("select * from article where display = 1 order by good desc");
			foreach($result as $row)
			{
				// 讚數
				$result2 = All("select * from good where article = '".$row["id"]."'");
				$likes = count($result2);

				// 取文章前20個字
				$part = mb_substr($row["text"],0, 20);
				?>
				<tr>
					<!-- 文章標題 -->
					<td><?=$row["name"]?></td>
					<?php
						// 如果有指定文章id，顯示文章
						if(!empty($_GET["id"]) && $_GET["id"] == $row["id"])
						{
							?>
							<td class="article"><?=$row["text"]?></td>
							<?php
						}
						// 如果沒有指定文章id，顯示部分文字
						// 並設定文字URL的GET為文章ID
						else
						{
							?>
							<td class="article"><a href="?do=news&id=<?=$row["id"]?>"><?=$part?></a></td>
							<?php
						}
					?>
					<?php
						// 如果有登入，顯示讚和收回讚按鈕
						if(isset($_SESSION["acc"]))
						{
							// 檢查使用者有沒有給這個文章讚
                            // 使用素材js.js附的good function，值為文章id、讚(1)或收回(2)、使用者帳號
                            // 使用者帳號用SESSION，所以可以不用傳
							// 如果不想用也可以直接用超連結到api.php，再跳頁回來
							$result3 = All("select * from good where user = '".$_SESSION["id"]."' and article = '".$row["id"]."'");
                            
                            // 如果有按過讚了
							if(count($result3) > 0)
							{
								?>
								<td><a onclick="good('<?=$row['id']?>', '2', '')" id="good<?=$row['id']?>">收回讚</a></td>
								<?php
							}
							// 如果沒有按過讚
							else
							{
								?>
								<td><a onclick="good('<?=$row['id']?>', '1', '')" id="good<?=$row['id']?>">讚</a></td>
								<?php
							}
						}
					?>
				</tr>
				<?php
			}
		?>
	</table>
	<!-- 文章只有四則，不用做分頁，做個大數字1就好 -->
	<a href='#'><font size='50px'>1</font></a>
</fieldset>
```

## 處理按讚

### 修改js
因為上面用到版型提供的按讚AJAX效果，但是版型的連結檔名和我們不一樣，所以要修改  
將 `back.php` 改成 `api.php` 就好  
```javascript
$.post("api.php?do=good&type="+type,{"id":id,"user":user},function()
```

### 處理資料
在 `api.php` 加入處理資料的程式碼
```php
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
```