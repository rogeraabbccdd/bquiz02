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
			$n = 1;
			$result = mysqli_query($link, "select * from article");
			$num = mysqli_num_rows($result);
			$pages = ceil($num/3);
			if(empty($_GET["p"]))	$p = 1;
			else $p = $_GET["p"];
			$s = $p*3-3;
			$lp = $p-1;
			$np = $p+1;
			if($lp < 1)	$lp = 1;
			if($np < 1)	$np = $pages;
			$result = mysqli_query($link, "select * from article order by good desc limit ".$s.",3");
			while($row = mysqli_fetch_array($result))
			{
				$result2 = mysqli_query($link, "select * from good where article = '".$row["id"]."'");
				$likes = mysqli_num_rows($result2); 
				$part = mb_substr($row["text"],0, 20);
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
	<?php
		if($num > 5)
		{
			echo "<a href='?do=anews&p=".$lp."'><</a>";
			for($i=1; $i<=$pages; $i++)
			{
				if($i == $p)	 echo "<a href='?do=anews&p=".$i."'><font size='50px'>".$i."</font></a>";
				else echo "<a href='?do=anews&p=".$i."'>".$i."</a>";
			}
			echo "<a href='?do=anews&p=".$np."'>></a>";
		}
	?>
	</form>
</fieldset>
