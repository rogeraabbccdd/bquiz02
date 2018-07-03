目前位置：首頁 > 分類網誌 > 
<?php
	if(!empty($_GET["p"])) $p = $_GET["p"];
	else $p = 1;
	
	if(!empty($_GET["pp"])) $pp = $_GET["pp"];
	else $pp = 1;
	
	if($p == "1")	echo "健康新知";
	elseif($p == "2")	echo "菸害防制";
	elseif($p == "3")	echo "癌症防治";
	elseif($p == "4")	echo "慢性病防治";
?>
<br>
<fieldset style="float:left" width="25%">
	<legend>網誌分類</legend>
	<a href="?do=po&p=1">健康新知</a><br>
	<a href="?do=po&p=2">菸害防制</a><br>
	<a href="?do=po&p=3">癌症防治</a><br>
	<a href="?do=po&p=4">慢性病防治</a>
</fieldset>
<?php
	if(empty($_GET["pp"]))
	{
		?>
<fieldset style="float:right;width:70%">
	<legend>文章列表</legend>
	<?php
		$result = mysqli_query($link, "select * from article where at = '".$p."' and display = '1'");
		while($row = mysqli_fetch_array($result))
		{
			echo "<a href='?do=po&p=".$p."&pp=".$row['id']."'>".$row["name"]."</a><br>";
		}
	
	?>
</fieldset>
<?php
	}
	else
	{
		$result = mysqli_query($link, "select * from article where id = '".$pp."'");
		while($row = mysqli_fetch_array($result))
		{
			?>
		<fieldset style="float:right;width:70%">
			<legend><?=$row["name"]?></legend>
			<?=$row["text"]?>
		</fieldset>
		<?php
		}
	}
?>