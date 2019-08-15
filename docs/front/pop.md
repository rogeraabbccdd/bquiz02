---
description: 編輯人氣文章
---

# 人氣文章

:::tip TIP
這裡的滑鼠移入效果直接複製第一題素材的JS，節省時間  
這裡也是，文章超過五則時要顯示分頁  
但是文章只有四則，不用做分頁，做個大數字1就好  
:::

開新檔 `pop.php`，製作人氣文章  
直接複製上一頁最新文章的版型來改就好，多了按讚數，文章內容改為滑鼠滑入顯示  
文章內容效果複製第一題首頁來用比較快   
```php
<fieldset>
	<legend>目前位置：首頁 > 人氣文章區</legend>
	<table style="table-layout:fixed">
		<tr>
			<td>標題</td>
			<td>內容</td>
			<td>人氣</td>
		</tr>
		<?php
			$result = All("select * from article where display = '1' order by good desc");
			foreach($result as $row)
			{
				$result2 = All("select * from good where article = '".$row["id"]."'");
				$likes = count($result2);
				$part = mb_substr($row["text"],0, 20);
				?>
				<tr>
					<td><?=$row["name"]?></td>
					<!-- 滑鼠移入時顯示文章內容，複製第一題首頁最新消息區的程式碼來使用 -->
					<td class="article"><?=$part?><span class="all" style="display:none"><?=$row["text"]?></span></td>
					<td><span id="vie<?=$row['id']?>"><?=$likes?></span>個人說<img src="02B03.jpg" width="20px"/></td>
					<?php
						// 這裡的按讚和最新消息一樣
						if(isset($_SESSION["acc"]))
						{
							$result3 = All("select * from good where user = '".$_SESSION["id"]."' and article = '".$row["id"]."'");
							if(count($result3) > 0)
							{
								?>
								<td><a onclick="good('<?=$row['id']?>', '2', '')" id="good<?=$row['id']?>">收回讚</a></td>
								<?php
							}
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
<!-- 滑鼠移入時顯示文章內容，複製第一題首頁的程式碼來使用 -->
<div id="altt" style="position: absolute; width: 350px; min-height: 100px; background-color: rgb(255, 255, 204); top: 50px; left: 130px; z-index: 99; display: none; padding: 5px; border: 3px double rgb(255, 153, 0); background-position: initial initial; background-repeat: initial initial;"></div>
<script>
$(".article").hover(
	function ()
	{
		$("#altt").html("<pre>"+$(this).children(".all").html()+"</pre>")
		$("#altt").show()
	}
)
$(".article").mouseout(
	function()
	{
		$("#altt").hide()
	}
)
</script>
```