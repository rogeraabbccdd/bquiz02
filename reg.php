<p style="color:#F00">*請設定您要註冊的帳號及密碼(最長12個字元)</p>
<!-- form acrion不用設定，因為註冊成功是用ajax -->
<form action="api.php?do=reg" method="post" id="regform">
	<table>
		<tr>
			<td>Step1:登入帳號</td>
			<td><input type="text" name="acc"></td>
		</tr>
		<tr>
			<td>Step2:登入密碼</td>
			<td><input type="password" name="pw"></td>
		</tr>
		<tr>
			<td>Step3:再次確認密碼</td>
			<td><input type="password" name="pw2"></td>
		</tr>
		<tr>
			<td>Step4:信箱(忘記密碼時使用)</td>
			<td><input type="text" name="mail"></td>
		</tr>
	</table>
	<input type="button" value="註冊" id="reg">
	<input type="reset" value="清除">
</form>
<script>
	// 當表單送出時
	$("#reg").on("click", function(e){
		// 檢查空白
		var empty = false;
		$("form input").each(function(){
			if($(this).val() == "")	empty = true;
		})

		if(empty)	alert("不可空白");
		else $("#regform").submit();
	})
</script>