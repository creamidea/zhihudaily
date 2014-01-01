<?php
$mysql = new SaeMysql();

if(empty($_GET["before"])){
    $webcode = file_get_contents("http://news.at.zhihu.com/api/1.2/news/latest");
}else{
    $webcode = file_get_contents("http://news.at.zhihu.com/api/1.2/news/before/" . $_GET["before"]);
}
$html = json_decode($webcode, true);
$news_count = count($html['news']);
$html['news'] = array_reverse($html['news']);
for( $i = 0;$i < $news_count; $i++ ){
    $news = $html['news'][$i];
    
    $page = json_decode(file_get_contents($news['url']), true);
    $body = mysql_escape_string($page['body']);
    $title = mysql_escape_string($news['title']);
    $share_url = mysql_escape_string($news['share_url']);
    $id = mysql_escape_string($news['id']);
    $image = mysql_escape_string($news['image']);
    $image_source = mysql_escape_string($news['image_source']);
    $date = mysql_escape_string($html['date']);

    $mysql->runSql("INSERT ignore INTO `zhihudaily` (title,share_url,id,body,date,image,image_source,date_index) VALUES ('$title','$share_url','$id','$body','$date','$image','$image_source','$i')");
}
print $webcode;
