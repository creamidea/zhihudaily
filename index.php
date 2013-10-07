<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>知乎日报</title>
<meta name = "viewport" content ="initial-scale=1.0,maximum-scale=1,user-scalable=no">
<link rel="stylesheet" href="style.css">
<script src="http://upcdn.b0.upaiyun.com/libs/modernizr/modernizr-2.6.2.min.js"></script>
</head>

<body>
<div class="global-header">
	<div class="main-wrap">
		<div class="search">
			<a target="_self" href="http://zhihudaily.sinaapp.com/search.php" class="button"><span>搜索</span></a>
			<a target="_self" href="http://zhihudaily.sinaapp.com/rss.xml" class="rss"><span>RSS</span></a>
		</div>
		<a href="/" target="_self" title="知乎日报"><i class="web-logo"></i></a>
	</div>
</div>

<div class="main-wrap content-wrap">
	<div class="headline">

		<div class="img-wrap">
<?php 
$mysql = new SaeMysql();

if(!$_GET["before"]){
    $day = date('Ymd');
}else{
	$day = date('Ymd',strtotime($_GET["before"]) - 3600*24);
}

$webcode = $mysql->getData("SELECT * FROM `daily` WHERE date = '$day' ORDER BY `daily`.`ga_prefix` DESC");
if(count($webcode) == 0){
	echo '<script type="text/javascript">window.location.href="http://zhihudaily.sinaapp.com/"</script>'; 
}

$weekarray = array("日","一","二","三","四","五","六");
$display_date = date('Y.m.d',strtotime($day)) . " 星期".$weekarray[date("w",strtotime($day))];
$image_source = $webcode['0']['image_source'];
$image = $webcode['0']['image'];

echo '			<h1 class="headline-title">' .$display_date. '</h1>
			<span class="img-source">图片：' .$image_source. '</span>
			<img src="' .$image. '" alt="' .$image_source.'">
		</div>'."\n";

for($i=0;$i<count($webcode);$i++){
echo '		<div class="headline-background">
			<a href="' .$webcode[$i]['share_url']. '" target="_blank"  class="headline-background-link">
			<div class="heading-content">' .$webcode[$i]['title']. '</div>
			</a>
		</div>'."\n";
}

?>
        
	</div>

</div>

<div class="footer">
    <div class="f">
		<?php echo '<a target="_self" href="http://zhihudaily.sinaapp.com/index.php?before=' .$day. '" class="page-btn">前一天</a>';?>
    </div>
	<br>&copy; 2013 知乎 &middot; Powered by <a href="https://github.com/faceair/zhihudaily">faceair</a>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?a13705bcaca5f671b8a02a8a5d2ee39d";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</div>
</body>
</html>
