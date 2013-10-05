<!doctype html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>知乎日报 - 搜索</title>
<meta name="apple-itunes-app" content="app-id=639087967">
<meta name = "viewport" content ="initial-scale=1.0,maximum-scale=1,user-scalable=no">
<link rel="stylesheet" href="http://daily.zhihu.com/css/share.css">
<link href="bootstrap.min.css" rel="stylesheet">
<script src="http://upcdn.b0.upaiyun.com/libs/modernizr/modernizr-2.6.2.min.js"></script>
<base target="_blank">
</head>
<body>
<div class="global-header">
<div class="main-wrap">
<div class="download">
<a target="_self" href="http://zhihudaily.sinaapp.com/search.php" class="button"><span>搜索</span></a>
</div>
<a href="/" target="_self" title="知乎日报"><i class="web-logo"></i></a>
</div>
</div>

<div class="main-wrap content-wrap">
<div class="headline">

<div class="center">
<form class="form-search" method ="get">
<select name="type">
    <option <?php if($_GET["type"] == "标题")(print 'selected="selected"')?>>标题</option>
    <option <?php if($_GET["type"] == "全文")(print 'selected="selected"')?>>全文</option>
</select>
  <input type="text" name="keyword" class="input-small search-query"  value="<?php print $_GET["keyword"]?>">
  <button type="submit" class="btn">搜索</button>
</form>
</div>
    
<?php

if($_GET["keyword"] and $_GET["type"]){
    $mysql = new SaeMysql();
    $keyword = mysql_escape_string($_GET["keyword"]);
    $page = mysql_escape_string($_GET["page"]);
    if(!$page)($page = 1);

    $min = ($page - 1) * 20;
    $max = $page * 20;
    
    if($_GET["type"] == "标题"){
        $data = $mysql->getData("SELECT title,ga_prefix,share_url FROM `daily` WHERE (CONVERT(`title` USING utf8 ) LIKE  '%$keyword%' OR CONVERT(`true_title` USING utf8 ) LIKE  '%$keyword%') LIMIT $min, $max");
    }elseif($_GET["type"] == "全文"){
        $data = $mysql->getData("SELECT title,ga_prefix,share_url FROM `daily` WHERE (CONVERT(`body` USING utf8 ) LIKE  '%$keyword%') LIMIT $min, $max");
    }
    for($i=0;$i<count($data);$i++){
    	echo '<div class="headline-background">';
        echo '<a href="' .$data[$i]['share_url']. '" target="_blank"  class="headline-background-link">';
        echo '<div class="heading">' .substr($data[$i]['ga_prefix'],0,4). '</div>';
        echo '<div class="heading-content">' .$data[$i]['title']. '</div>';
        echo '<i class="icon-arrow-right"></i>';
        echo '</a>';
        echo '</div>';   
    }
    
    echo  '</div>';
    echo  '</div>';
    echo '<div class="footer">';
    echo '<div class="f">';
    
    if($i == 20){
        echo  '<a target="_self" href="http://zhihudaily.sinaapp.com/search.php?keyword=' .$keyword. '&page=' .++$page. '&type=' .$_GET["type"]. '" class="download-btn">下一页</a>';
    }elseif($page != 1 and $i > 0){
        echo  '<a target="_self" href="http://zhihudaily.sinaapp.com/search.php?keyword=' .$keyword. '&page=' .--$page. '&type=' .$_GET["type"]. '" class="download-btn">上一页</a>';
    }
    
}else{
    echo '<div class="center">';
    echo '搜索试运行中，手机显示页面有问题，欢迎大牛<a href="https://github.com/faceair/zhihudaily">贡献代码</a>帮忙解决。';
    echo '</div>';
    echo '</div>';
    echo  '</div>';
    echo '<div class="footer">';
    echo '<div class="f">';
}

?>

</div><br><br>&copy; 2013 知乎 &middot; Powered by <a href="https://github.com/faceair/zhihudaily">faceair</a>
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
<script src="http://upcdn.b0.upaiyun.com/libs/jquery/jquery-1.9.1.min.js"></script>
<script src="http://daily.zhihu.com/js/share.js"></script>
</body>
</html>
