---
description: 編輯問卷調查
---

# 問卷調查
開新檔 `que.php`，製作問卷調查  

## 製作版面
在 `que.php` 製作問卷調查版面  
這裡我是把問題清單、投票頁和結果頁都做在同一頁  
如果怕亂掉分開做也可以  
```php
<fieldset>
	<?php
		// 以get變數r(result)代表結果頁面，v(vote)代表投票頁面
		// 如果沒有r也沒有v，代表顯示問卷調查
		if(empty($_GET["r"]) && empty($_GET["v"]))
		{
			?>
			<legend>目前位置：首頁 > 問卷調查</legend>
			<table>
				<tr>
					<td>編號</td>
					<td>問卷題目</td>
					<td>投票總數</td>
					<td>結果</td>
					<td>狀態</td>
				</tr>
				<?php
					// 設定變數n為編號
					$n = 1;
					$result = All("select * from que where parent = '0'");
					foreach($result as $row)
					{
						// 總票數
						$votes = All("select sum(vote) from que where parent = '".$row["id"]."'")[0][0];
						echo "
						<tr>
							<td>".$n."</td>
							<td>".$row["text"]."</td>
							<td>".$votes."</td>
							<td><a href='?do=que&r=".$row["id"]."'>結果</a></td>";

						// 如果有登入，顯示參與投票
						if(!empty($_SESSION["id"]))
							echo "<td><a href='?do=que&v=".$row["id"]."'>參與投票</a></td>";

						// 如果沒有登入，顯示請先登入
						else
							echo "<td>請先登入</td>";

						echo "</tr>";

						// 編號+1
						$n++;
					}
				?>
			</table>
			<?php
		}
		// 如果有r沒有v，代表顯示問卷調查結果
		elseif(!empty($_GET["r"]) && empty($_GET["v"]))
		{
			// 設定變數n為編號
			$n = 1;

			// 總票數，計算每個選項的得票率
			// r為問卷題目id
			$total = All("select sum(vote) from que where parent = '".$_GET["r"]."'")[0][0];

			// 問卷名稱
			$name =All("select text from que where id = '".$_GET["r"]."'")[0][0];

			// 查詢各選項
			$result = All("select * from que where parent = '".$_GET["r"]."'");
			?>
			<legend>目前位置：首頁 > 問卷調查 > <?=$name?></legend>
			<table>
				<?php
				foreach($result as $row)
				{
					// 如果總票數是0，得票率為0
					if($total <	1)	$rate = 0;
					// 計算得票率
					else	$rate = round($row["vote"]/$total, 2)*100;
					echo "
							<tr>
								<td>".$n.".".$row["text"]."</td>
								<td>
									<span style='background-color:#333; width:".$rate."%; display:inline-block'> </span>
									".$row["vote"]."票(".$rate."%)
								</td>
							</tr>";

					// 編號+1
					$n++;
				}
				?>
			</table>
			<a href="?do=que" style="border:1px">返回</a>
			<?php
		}
		// 如果沒有r有v，代表顯示投票頁面
		else
		{
			// v為問卷題目id
			// 題目名稱
			$name = All("select text from que where id = '".$_GET["v"]."'")[0][0];
			?>
			<legend>目前位置：首頁 > 問卷調查 > <?=$name?></legend>
			<!-- 傳送表單到api.php -->
			<form action="api.php?do=vote" method="post">
			<b><?=$name?></b><br>
			<?php
			// 從資料庫找每個選項
			$result = All("select * from que where parent = '".$_GET["v"]."'");
			foreach($result as $row)
			{
				echo "<input type='radio' name='vote' value='".$row["id"]."'>".$row["text"]."<br>";
			}
			?>
			<input type='submit' value='我要投票'></form>
			<?php
		}
	?>
</fieldset>
```

## 處理投票
在 `api.php` 加入處理投票的程式碼  
```php
case "vote":
	All("update que set vote = vote + 1 where id='".$_POST["vote"]."'");
	lo("index.php?do=que");
	break;
```