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
				$result2 = All("select * from good where article = '".$row["id"]."'");
				$likes = count($result2);
				$part = mb_substr($row["text"],0, 20);
				?>
				<tr>
					<td><?=$row["name"]?></td>
					<?php
						if(!empty($_GET["id"]) && $_GET["id"] == $row["id"])
						{
							?>
							<td class="article"><?=$row["text"]?></td>
							<?php
						}
						else
						{
							?>
							<td class="article"><a href="?do=news&id=<?=$row["id"]?>"><?=$part?></a></td>
							<?php
						}
					?>
					<?php
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
	<a href='#'><font size='50px'>1</font></a>
</fieldset>