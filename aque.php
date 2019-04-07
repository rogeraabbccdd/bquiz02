<fieldset>
	<legend>問卷管理</legend>
	<form action="api.php?do=aque" method="post">
        問卷名稱<input type="text" name="quename">
        <div id="ques">
            選項<input type="text" name="sel[]">
        </div>
        <button id="more" type="button" onclick="addmore()">更多</button><br>
        <input type="submit" value="新增"><input type="reset" value="清空">
	</form>
</fieldset>
<script>
function addmore(){
	$("#ques").append('<br>選項<input type="text" name="sel[]">');
}
</script>
