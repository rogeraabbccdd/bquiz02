<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0039) -->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
	include "sql.php";

	$m = date("m 月 d 號 l", $today);

	$totalvis = All("select sum(count) as count from visit")[0][0];

	$todayvis = All("select * from visit where time = '".$today."'")[0]["count"];
?>
<title>健康促進網</title>
<link href="./home_files/css.css" rel="stylesheet" type="text/css">
<script src="./home_files/jquery-1.9.1.min.js"></script>
<script src="./home_files/js.js"></script>
</head>

<body>
<div id="alerr" style="background:rgba(51,51,51,0.8); color:#FFF; min-height:100px; width:300px; position:fixed; display:none; z-index:9999; overflow:auto;">
	<pre id="ssaa"></pre>
</div>
<iframe name="back" style="display:none;"></iframe>
	<div id="all" style="height:768px; width:1024px">
    	<div id="title">
		<?=$m?> | 今日瀏覽: <?=$todayvis?> | 累積瀏覽: <?=$totalvis?> 
		<a href="index.php" style="float:right">回首頁</a>
	</div>
		
        <div id="title2">
		<img src="./home_files/02B01.jpg" width="100%" height="100%" alt="健康促進網 - 回首頁" title="健康促進網 - 回首頁">
        </div>
        <div id="mm">
        	<div class="hal" id="lef">
				<?php
					if(!empty($_GET["do"]) && mb_substr($_GET["do"], 0, 1) == "a")
					{
						?>
						<a class="blo" href="?do=aacc">帳號管理</a>
						<a class="blo" href="?do=apo">分類網誌</a>
						<a class="blo" href="?do=anews">最新文章管理</a>
						<a class="blo" href="?do=aknow">講座管理</a>
						<a class="blo" href="?do=aque">問卷管理</a>
						<?php
					}
					else
					{
						?>
						<a class="blo" href="?do=po">分類網誌</a>
						<a class="blo" href="?do=news">最新文章</a>
						<a class="blo" href="?do=pop">人氣文章</a>
						<a class="blo" href="?do=know">講座訊息</a>
						<a class="blo" href="?do=que">問卷調查</a>
						<?php
					}
				?>
               	                 </div>
            <div class="hal" id="main">
            	<div>
				<marquee width="80%">請民眾踴躍投稿電子報，讓電子報成為大家相互交流、分享的園地！詳見最新文章</marquee>
					<span style="width:18%; display:inline-block;">
					<?php
						if(empty($_SESSION["acc"]))
						{
							?>
							<a href="?do=login">會員登入</a>
							<?php
						}
						else
						{
							echo "歡迎，".$_SESSION["acc"]."<a href='api.php?do=logout'>登出</a>";
							if($_SESSION["id"] == 1)	echo "<a href='?do=admin'>管理</a>";
						}
					?>
                    	                    </span>
						<div class="">
						<?php
							if(!empty($_GET["do"])){
								if($_GET["do"] == "admin") echo "請選擇管理項目";
								else	include($_GET["do"].".php");
							}
							else	include("main.html");
						?>
                		                        </div>
                </div>
            </div>
        </div>
        <div id="bottom">
    	    本網站建議使用：IE9.0以上版本，1024 x 768 pixels 以上觀賞瀏覽 ， Copyright © 2019健康促進網社群平台 All Right Reserved 
    		 <br>服務信箱：health@test.labor.gov.tw<img src="./home_files/02B02.jpg" width="45">
        </div>
    </div>

</body></html>