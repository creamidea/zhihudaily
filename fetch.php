<?php
$mysql = new SaeMysql();

function getday($day) {
    global $mysql;
    
    if($day == 'today'){
        $webcode = file_get_contents("http://news.at.zhihu.com/api/1.2/news/latest");
        
        $resource = json_decode($webcode,1);
        $date = $resource['date'];
        $mysql->runSql("UPDATE `words` SET date = '$date' WHERE latest = 'zhihu'");
    }else{
        $webcode = file_get_contents("http://news.at.zhihu.com/api/1.2/news/before/$day");
    }
    return json_decode($webcode, true);
}

function dealday($html,$mysql) {
    global $add;
	global $mysql;
    
    $html_news = count($html['news']);
    for($i=0;$i<$html_news;$i++){
        $news = $html['news'][$i];
        
        if(in_array($news['id'],$add)){
            return false;
        }

        $page = json_decode(file_get_contents($news['url']), true);
        $body = mysql_escape_string($page['body']);
        $title = mysql_escape_string($news['title']);
        
        $true_title = "";
        preg_match_all('/question-title\\">(.+?)</',$page['body'], $matches);
        foreach($matches[1] as $value){
            $true_title .= $value;
        }
        
        $true_title = mysql_escape_string($true_title);
        $share_url = mysql_escape_string($news['share_url']);
        $ga_prefix = mysql_escape_string($news['ga_prefix']);
        $id = mysql_escape_string($news['id']);
        $image = mysql_escape_string($news['image']);
        $image_source = mysql_escape_string($news['image_source']);
        $date = mysql_escape_string($html['date']);

        $sql = "INSERT ignore INTO daily (title,true_title,share_url,ga_prefix,id,body,date,image,image_source) VALUES ('$title','$true_title','$share_url','$ga_prefix','$id','$body','$date','$image','$image_source')";
        $mysql->runSql($sql);
    }
    return $html['date'];
}

$data = $mysql->getData("SELECT id FROM `daily`");
$add = array();
foreach($data as $value){
    $add[] = $value["id"];
}

$day = 'today';
while($day){
    $day = dealday(getday($day),$mysql);
}
