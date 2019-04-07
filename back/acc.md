---
description: 編輯帳號管理
---

# 帳號管理

開新檔 `aacc.php`，製作帳號管理  

## 製作版面
在 `aacc.php`，製作帳號管理  
這裡其實只要做上面的管理就好，下面的新增帳號直接複製前台註冊頁 `reg.php`  
```php
<fieldset>
	<legend>帳號管理</legend>
	<form method="post" action="api.php?do=delacc">
        <table>
            <tr>
                <td>帳號</td>
                <td>密碼</td>
                <td>刪除</td>
            </tr>
            <?php
                // 選取ID大於1的帳號，因為管理員的ID是1
                $result = All("select * from user where id > 1");
                foreach($result as $row)
                {
                    echo "
                    <tr>
                        <td>".$row["acc"]."</td>
                        <td>".$row["pw"]."</td>
                        <td><input type='checkbox' name='del[]' value='".$row["id"]."'></td>
                    </tr>";
                }
            ?>
        </table>
        <input type="reset" value="清空選取"><input type="submit" value="確定刪除">
	</form>
	<h1>新增會員</h1>
	<p style="color:#F00">*請設定您要註冊的帳號及密碼(最長12個字元)</p>
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
        <input type="reset" name="清除">
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
</fieldset>
```

## 處理帳號管理
在 `api.php` 加入處理帳號管理的程式碼  
```php
case "vote":
	All("update que set vote = vote + 1 where id='".$_POST["vote"]."'");
	lo("index.php?do=aacc");
	break;
```