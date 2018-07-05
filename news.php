<fieldset>
	<legend>目前位置：首頁 > 最新文章區</legend>
	<table style="table-layout:fixed">
		<tr>
			<td>標題</td>
			<td>內容</td>
		</tr>
		<?php
			$result = mysqli_query($link, "select * from article where display = '1'");
			$num = mysqli_num_rows($result);
			$pages = ceil($num/5);
			if(empty($_GET["p"]))	$p = 1;
			else $p = $_GET["p"];
			$s = $p*5-5;
			$lp = $p-1;
			$np = $p+1;
			if($lp < 1)	$lp = 1;
			if($np < 1)	$np = $pages;
			$result = mysqli_query($link, "select * from article where display = '1' order by good desc limit ".$s.",5");
			while($row = mysqli_fetch_array($result))
			{
				$result2 = mysqli_query($link, "select * from good where article = '".$row["id"]."'");
				$likes = mysqli_num_rows($result2); 
				$part = mb_substr($row["text"],0, 20);
				?>
				<tr>
					<td><?=$row["name"]?></td>
					<?php
						if(!empty($_GET["pp"]) && $_GET["pp"] == $row["id"])
						{
							?>
							<td class="article"><?=$row["text"]?></td>
							<?php
						}
						else
						{
							?>
							<td class="article"><a href="?do=news&p=<?=$p?>&pp=<?=$row["id"]?>"><?=$part?></a></td>
							<?php
						}
					?>
					<?php
						if(isset($_SESSION["acc"]))
						{
							$result3 = mysqli_query($link, "select * from good where user = '".$_SESSION["acc"]."' and article = '".$row["id"]."'");
							if(mysqli_num_rows($result3) > 0) 
							{
								?>
								<td><a onclick="good('<?=$row['id']?>', '2', '<?=$_SESSION["acc"]?>')" id="good<?=$row['id']?>">收回讚</a></td> 
								<?php 
							}
							else 
							{
								?>
								<td><a onclick="good('<?=$row['id']?>', '1', '<?=$_SESSION["acc"]?>')" id="good<?=$row['id']?>">讚</a></td> 
								<?php 
							}
						}
					?>
				</tr>
				<?php
			}
		?>
	</table>
	<?php
		if($num > 5)
		{
			echo "<a href='?do=news&p=".$lp."'><</a>";
			for($i=1; $i<=$pages; $i++)
			{
				if($i == $p)	 echo "<a href='?do=news&p=".$i."'><font size='50px'>".$i."</font></a>";
				else echo "<a href='?do=news&p=".$i."'>".$i."</a>";
			}
			echo "<a href='?do=news&p=".$np."'>></a>";
		}
	?>
</fieldset>
<div id="altt" style="position: absolute; width: 350px; min-height: 100px; background-color: rgb(255, 255, 204); top: 50px; left: 130px; z-index: 99; display: none; padding: 5px; border: 3px double rgb(255, 153, 0); background-position: initial initial; background-repeat: initial initial;"></div>
