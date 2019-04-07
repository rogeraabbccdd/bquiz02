<fieldset>
	<legend>會員登入</legend>
	<form action="api.php?do=login" method="post">
	<table>
		<tr>
			<td>帳號</td>
			<td><input type="text" name="acc"></td>
		</tr>
		<tr>
			<td>密碼</td>
			<td><input type="password" name="pw"></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="登入"><input type="reset" name="reset" value="清除"></td>
			<td><a href="index.php?do=forget">忘記密碼</a>&emsp;|&emsp;<a href="index.php?do=reg">尚未註冊</a></td>
		</tr>
	</table>
	</form>
</fieldset>