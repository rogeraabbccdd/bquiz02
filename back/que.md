---
description: 編輯問卷管理
---

# 問卷管理

開新檔 `aque.php`，製作問卷管理  

## 製作版面
在 `aque.php`，製作最新問卷管理    
```html
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
```

## 處理表單
在 `api.php` 加入處理表單的程式碼  
```php
case "aque":
    // 先新增題目
    $result = All("insert into que values(null, '".$_POST["quename"]."', '0', '0')");
    // 取得題目ID
    $id = $pdo->lastInsertId();
    // 新增選項
    foreach($_POST["sel"] as $sell)
    {
        $result = All("insert into que values(null, '".$sell."', '".$id."', '0')");
    }
    lo("index.php?do=aque");
    break;
```