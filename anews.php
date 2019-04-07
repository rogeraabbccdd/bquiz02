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
            $p = 1;
			if(!empty($_GET["p"]))	$p = $_GET["p"];
            
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
    <a href='?do=anews&p=1'> < </a>
    <a href='?do=anews&p=1'><?=($p ==1)?"<font size='50px'>1</font>":1?></a>
    <a href='?do=anews&p=2'><?=($p ==2)?"<font size='50px'>2</font>":2?></a>
    <a href='?do=anews&p=2'> > </a>
	</form>
</fieldset>