<fieldset>
	<?php
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
					$n = 1;
					$result = mysqli_query($link, "select * from que where parent = '0'");
					while($row = mysqli_fetch_array($result))
					{
						$result2 = mysqli_query($link, "select sum(vote) from que where parent = '".$row["id"]."'");
						$votes = mysqli_fetch_array($result2)[0];
						echo "
						<tr>
							<td>".$n."</td>
							<td>".$row["text"]."</td>
							<td>".$votes."</td>
							<td><a href='?do=que&r=".$row["id"]."'>結果</a></td>";
						
						if(!empty($_SESSION["acc"]))
							echo "<td><a href='?do=que&v=".$row["id"]."'>參與投票</a></td>";
						else
							echo "<td>請先登入</td>";
						
						$n++;
					}

				?>
			</table>
			<?php
		}
		// result
		elseif(!empty($_GET["r"]) && empty($_GET["v"]))
		{
			$n = 1;
			$result = mysqli_query($link, "select sum(vote) from que where parent = '".$_GET["r"]."'");
			$total = mysqli_fetch_array($result)[0];
			$result = mysqli_query($link, "select * from que where id = '".$_GET["r"]."'");
			$name = mysqli_fetch_array($result)["text"];
			$result = mysqli_query($link, "select * from que where parent = '".$_GET["r"]."'");
			?>
			<legend>目前位置：首頁 > 問卷調查 > <?=$name?></legend>
			<table>
				<?php
				while($row = mysqli_fetch_array($result))
				{
					if($total <	1)	$rate = 0;
					else	$rate = round($row["vote"]/$total, 2)*100;
					echo "
							<tr>
								<td>".$n.".".$row["text"]."</td>
								<td><span style='background-color:#333; width:".$rate."%; display:inline-block'>&nbsp;</span>".$row["vote"]."票(".$rate."%)</td>
							</tr>";
								
					$n++;
				}
				?>
			</table>
			<a href="?do=que" style="border:1px">返回</a>
			<?php
		}
		else
		{
			$result = mysqli_query($link, "select * from que where id = '".$_GET["v"]."'");
			$name = mysqli_fetch_array($result)["text"];
			?>
			<legend>目前位置：首頁 > 問卷調查 > <?=$name?></legend>
			<form action="api.php?do=vote" method="post">
			<b><?=$name?></b><br>
			<?php
			$result = mysqli_query($link, "select * from que where parent = '".$_GET["v"]."'");
			while($row = mysqli_fetch_array($result))
			{
				echo "<input type='radio' name='vote' value='".$row["id"]."'>".$row["text"]."<br>";
			}
			echo "<input type='submit' value='我要投票'></form>";
		}
		?>
</fieldset>	