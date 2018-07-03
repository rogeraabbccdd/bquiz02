
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0039) -->
<html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
	include "sql.php";
	include "auth.php";
	$m = date("m 月 d 號 l",strtotime("now"));
	$today = strtotime('today GMT+8');
	
	$result = mysqli_query($link, "select sum(count) as count from visit");
	$totalvis = mysqli_fetch_array($result)["count"];
	
	$result = mysqli_query($link, "select * from visit where time = '".$today."'");
	$todayvis = mysqli_fetch_array($result)["count"];
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
	<div id="all"  style="width:1024px; height:768px">
    	<div id="title">
        <span style="float:left"><?=$m?> | 今日瀏覽: <?=$todayvis?> | 累積瀏覽: <?=$totalvis?> </span> <a href="index.php" style="float:right">回首頁</a>       </div>
        <div id="title2">
        	<img src="./home_files/02B01.jpg" width="100%" height="100%" alt="健康促進網 - 回首頁" title="健康促進網 - 回首頁">
        </div>
        <div id="mm">
        	<div class="hal" id="lef" style="background-image:url(images/02B04.png)">
			<?php
				if(!empty($_GET["do"]) && (
				($_GET["do"] == "admin") || 
				($_GET["do"] == "aacc") || 
				($_GET["do"] == "apo") || 
				($_GET["do"] == "anews") || 
				($_GET["do"] == "aknow") || 
				($_GET["do"] == "aque")))
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
            <div class="hal" id="main" style="height:572px; padding:0">
				
            	<div>
            		<marquee width="82%">請民眾踴躍投稿電子報，讓電子報成為大家相互交流、分享的園地！詳見最新文章</marquee>
					<span style="width:18%; display:inline-block; float:right">
					<?php
						if(empty($_SESSION["acc"]))
						{
							?>
						
                    	                    	<a href="?do=login">會員登入</a>
                    	                    
											<?php
						}
						else 
						{
							echo "歡迎，".$_SESSION["acc"]."<a href='?do=logout' style='border:1px'>登出</a>";
							if($_SESSION["acc"] == "admin" )	echo "<a href='?do=admin' style='border:1px'>管理</a>";
						}
											?>
						</span>
                    	<div class="">
						<?php
							if(!$_GET || $_GET["do"] == "index")
							{
								include "frame.html";
							}
							elseif($_GET["do"] == "login")
							{
								include "login.php";
							}
							elseif($_GET["do"] == "forget")
							{
								include "forget.php";
							}
							elseif($_GET["do"] == "reg")
							{
								include "reg.php";
							}
							elseif($_GET["do"] == "po")
							{
								include "po.php";
							}
							elseif($_GET["do"] == "pop")
							{
								include "pop.php";
							}
							elseif($_GET["do"] == "news")
							{
								include "news.php";
							}
							elseif($_GET["do"] == "que")
							{
								include "que.php";
							}
							elseif($_GET["do"] == "admin")
							{
								echo "請選擇管理項目";
							}
							elseif($_GET["do"] == "aacc")
							{
								include "aacc.php";
							}
							elseif($_GET["do"] == "anews")
							{
								include "anews.php";
							}
							elseif($_GET["do"] == "aque")
							{
								include "aque.php";
							}
						?>
						</div>
                </div>
            </div>
        </div>
        <div id="bottom" style="padding:0">
    	    本網站建議使用：IE9.0以上版本，1024 x 768 pixels 以上觀賞瀏覽 ， Copyright © <script>document.write(new Date().getFullYear())</script>健康促進網社群平台 All Right Reserved 
    		 <br>服務信箱：health@test.labor.gov.tw<img src="./home_files/02B02.jpg" width="45">
        </div>
    </div>

</body></html>