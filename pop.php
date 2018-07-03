<fieldset>
	<legend>目前位置：首頁 > 人氣文章區</legend>
	<table style="table-layout:fixed">
		<tr>
			<td>標題</td>
			<td>內容</td>
			<td>人氣</td>
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
					<td class="article"><?=$part?><span class="all" style="display:none"><?=$row["text"]?></span></td>
					<td><span id="lik<?=$row['id']?>"><?=$likes?></span>個人說<img src="images/02B03.jpg" width="20px"/></td>
					<?php
						if(isset($_SESSION["acc"]))
						{
							$result3 = mysqli_query($link, "select * from good where user = '".$_SESSION["acc"]."' and article = '".$row["id"]."'");
							if(mysqli_num_rows($result3) > 0) 
							{
								?>
								<td><a onclick="like('<?=$row['id']?>', '1')" id="like<?=$row['id']?>">收回讚</a></td> 
								<?php 
							}
							else 
							{
								?>
								<td><a onclick="like('<?=$row['id']?>', '2')" id="like<?=$row['id']?>">讚</a></td> 
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
			echo "<a href='?do=pop&p=".$lp."'><</a>";
			for($i=1; $i<=$pages; $i++)
			{
				if($i == $p)	 echo "<a href='?do=pop&p=".$i."'><font size='50px'>".$i."</font></a>";
				else echo "<a href='?do=pop&p=".$i."'>".$i."</a>";
			}
			echo "<a href='?do=pop&p=".$np."'>></a>";
		}
	?>
</fieldset>
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
						function like(id, type)
						{
							$.post("api.php?do=like&id="+id, {id, type}, function(r){
								console.log(r);
								if(type === '2')
								{
									$("#like"+id).text("收回讚").attr("onclick", "like('"+id+"', '1')");
									$("#lik"+id).text( $("#lik"+id).text()*1+1 );
								}
								else
								{
									$("#like"+id).text("讚").attr("onclick", "like('"+id+"', '2')");
									$("#lik"+id).text( $("#lik"+id).text()*1-1 );
								}
							})
						}
                        </script>
