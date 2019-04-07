---
description: 編輯分類網誌
---

# 分類網誌

開新檔 `po.php`，製作分類網誌
```php
<?php
	// 以變數at代表文章分類
	if(!empty($_GET["at"])) $at = $_GET["at"];
	else $at = 0;

	// 以變數article代表文章ID
	if(!empty($_GET["article"])) $article = $_GET["article"];

	// 在導覽列顯示文章分類
	$atname = array("健康新知", "菸害防制", "癌症防治", "慢性病防治");
?>
<!-- 導覽列 -->
目前位置：首頁 > 分類網誌 > <?=$atname[$at]?>
<br>
<fieldset style="float:left" width="25%">
	<legend>網誌分類</legend>
    <?php
        // 列出網誌分類
		for($i=0; $i<4; $i++)
		{
			echo "<a href='?do=po&at=".$i."'>".$atname[$i]."</a><br>";
		}
	?>
</fieldset>
<?php
	// 如果沒有article，代表沒有指定文章，所以顯示文章列表
	if(empty($article))
	{
		?>
<fieldset style="float:right;width:70%">
	<legend>文章列表</legend>
	<?php
		$result = All("select * from article where at = '".$at."' and display = '1'");
		foreach($result as $row)
		{
			echo "<a href='?do=po&at=".$at."&article=".$row['id']."'>".$row["name"]."</a><br>";
		}

	?>
</fieldset>
<?php
	}
	// 有article，代表有指定文章，所以顯示文章內容
	else
	{
		$row = All("select * from article where id = '".$article."'")[0];
		?>
		<fieldset style="float:right;width:70%">
			<legend><?=$row["name"]?></legend>
			<?=$row["text"]?>
		</fieldset>
		<?php
	}
?>
```