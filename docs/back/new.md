---
description: 編輯最新文章管理
---

# 最新文章管理

:::tip TIP
題目規定這裡要做分頁，一頁3則，全部4個文章所以只有兩頁  
因此一些頁數的判斷就直接寫死  
:::

開新檔 `anews.php`，製作最新文章管理  

## 製作版面
在 `anews.php`，製作最新文章管理  
```php
<fieldset>
	<legend>最新文章管理</legend>
	<form action="api.php?do=anews" method="post">
	<table style="table-layout:fixed">
		<tr>
			<td>編號</td>
			<td>標題</td>
			<td>顯示</td>
			<td>刪除</td>
		</tr>
        <?php
            // 編號從1開始
            $n = 1;

            // 預設頁數為第一頁，有 $_GET["p"] 則以 $_GET["p"] 為頁數
            $p = 1;
			if(!empty($_GET["p"]))	$p = $_GET["p"];
            
            // 因為只有兩頁，所以 SQL 查詢語法直接寫死
            if($p == 1) $sql = "select * from article limit 0 ,3";
            else  $sql = "select * from article limit 3 ,3";
            $result = All($sql);
			foreach($result as $row)
			{
				?>
				<tr>
					<td><?=$n?></td>	
					<td><?=$row["name"]?></td>
					<td><input type="checkbox" name="display[]" value="<?=$row["id"]?>" <?php if($row["display"] == "1") echo "checked";?>></td>
					<td><input type="checkbox" name="del[]" value="<?=$row["id"]?>">
					<input type="hidden" name="id[]" value="<?=$row["id"]?>"></td>
				</tr>
				<?php
				$n++;
			}
		?>
	</table>
    <input type="submit" value="確定修改">
    <!-- 只有兩頁，所以我直接寫死 -->
    <a href='?do=anews&p=1'> < </a>
    <a href='?do=anews&p=1'><?=($p ==1)?"<font size='50px'>1</font>":1?></a>
    <a href='?do=anews&p=2'><?=($p ==2)?"<font size='50px'>2</font>":2?></a>
    <a href='?do=anews&p=2'> > </a>
	</form>
</fieldset>
```

## 處理表單
在 `api.php` 加入處理表單的程式碼  
```php
case "vote":
	All("update que set vote = vote + 1 where id='".$_POST["vote"]."'");
	lo("index.php?do=anews");
	break;
```