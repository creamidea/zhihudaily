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
			<a target="_blank" href="https://www.google.com.hk/search?q=%E7%9E%8E%E6%89%AF+site%3Adaily.zhihu.com" class="button"><span>搜索</span></a>
			<a target="_blank" href="./rss.xml" class="rss"><span>RSS</span></a>
		</div>
		<a href="./" target="_self" title="知乎日报"><i class="web-logo"></i></a>
	</div>
</div>

<div class="main-wrap content-wrap">
	<div class="headline">

		<div class="img-wrap">
<?php
if(!isset($_GET["before"])){
    $mem = memcache_init();
    $data = json_decode($mem->get('today'),true);
    $day = $data['date'];
    $news = $data['news'];
}else{
	$day = date('Ymd',strtotime($_GET["before"]) - 3600*24);
	$mysql = new SaeMysql();
    $news = $mysql->getData("SELECT * FROM `zhihudaily` WHERE date = '$day' ORDER BY - `date_index`");
    if(count($news) == 0){
    	$data = json_decode(file_get_contents("http://zhihudaily.sinaapp.com/fetch_day.php?before=" . $_GET["before"]),true);
    	$day = $data['date'];
    	$news = $data['news'];
    }
}
if(count($news) == 0){
	echo '<script type="text/javascript">window.location.href="/"</script>';
}

$weekarray = array("日","一","二","三","四","五","六");
$display_date = date('Y.m.d',strtotime($day)) . " 星期".$weekarray[date("w",strtotime($day))];
$image_source = $news['0']['image_source'];
$image = $news['0']['image'];

echo '			<h1 class="headline-title">' .$display_date. '</h1>
			<span class="img-source">图片：' .$image_source. '</span>
			<img src="now_img.php" alt="' .$image_source.'">
		</div>'."\n";

for($i=0;$i<count($news);$i++){
echo '		<div class="headline-background">
			<a href="' .$news[$i]['share_url']. '" target="_blank"  class="headline-background-link">
			<div class="heading-content">' .$news[$i]['title']. '</div>
			</a>
		</div>'."\n";
}

?>
        
	</div>

</div>

<div class="footer">
	<div class="f">
		<?php echo '<a target="_self" href="./index.php?before=' .$day. '" class="page-btn">前一天</a>';?>
	</div>
	<br>&copy; 2013 知乎 &middot; Powered by <a href="https://github.com/faceair/zhihudaily">faceair</a>
</div>
</body>
</html>
