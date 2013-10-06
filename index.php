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
            <a target="_self" href="http://zhihudaily.sinaapp.com/rss.php" class="rss"><span>RSS</span></a>
		</div>
		<a href="/" target="_self" title="知乎日报"><i class="web-logo"></i></a>
	</div>
</div>

<div class="main-wrap content-wrap">
	<div class="headline">

		<div class="img-wrap">
    
<?php 

if(!$_GET["before"]){
    
    if($_GET["refresh"] == "1"){
        unlink('saestor://zhihudaily/' .date('Ymd'). '.txt');
    }
    
    if(is_file('saestor://zhihudaily/' .date('Ymd'). '.txt')){
		$webcode = json_decode(file_get_contents('saestor://zhihudaily/' .date('Ymd'). '.txt'), 1);
    }else{
		$webcode = json_decode(file_get_contents('http://news.at.zhihu.com/api/1.2/news/latest'), 1);
    }
}else{
    $beforeday = date('Ymd',strtotime($_GET["before"]) - 3600*24);
    
    if($_GET["refresh"] == "1"){
        unlink('saestor://zhihudaily/' .$beforeday. '.txt');
    }
    
    if(is_file('saestor://zhihudaily/' .$beforeday. '.txt')){
        $webcode = json_decode(file_get_contents('saestor://zhihudaily/' .$beforeday. '.txt'), 1);
    }else{
    	$resource = file_get_contents('http://news.at.zhihu.com/api/1.2/news/before/' . $_GET["before"]);
        if(!strstr($resource ,'<html><title>404: Not Found</title><body>404: Not Found</body></html>') and $resource != '{}'){
    		$webcode = json_decode($resource, 1);
    		file_put_contents('saestor://zhihudaily/' .$webcode['date']. '.txt',$resource);
        }else{
			echo '<script type="text/javascript">window.location.href="http://zhihudaily.sinaapp.com/"</script>'; 
        }
    }
}

echo '		<h1 class="headline-title">' .$webcode['display_date']. '</h1>
			<span class="img-source">图片：' .$webcode['news']['0']['image_source']. '</span>
			<img src="' .$webcode['news']['0']['image']. '" alt="">
		</div>';

for($i=0;$i<count($webcode['news']);$i++){
echo '	<div class="headline-background">
			<a href="' .$webcode['news'][$i]['share_url']. '" target="_blank"  class="headline-background-link">
			<div class="heading-content">' .$webcode['news'][$i]['title']. '</div>
			</a>
		</div>';
}

?>
        
	</div>

</div>

<div class="footer">
    <div class="f">
		<?php echo '<a target="_self" href="http://zhihudaily.sinaapp.com/index.php?before=' .$webcode['date']. '" class="page-btn">前一天</a>';?>
    </div>
	<br>&copy; 2013 知乎 &middot; Powered by <a href="https://github.com/faceair/zhihudaily">faceair</a> &middot;

<?php
if(!$_GET["before"]){
    echo '<a target="_self" href="http://zhihudaily.sinaapp.com/index.php?refresh=1">强制刷新</a>';
}else{
    echo '<a target="_self" href="http://zhihudaily.sinaapp.com/index.php?before=' .$_GET["before"]. '&refresh=1">强制刷新</a>';
}
?>
    
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
