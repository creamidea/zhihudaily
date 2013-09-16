<?php
$mysql = new SaeMysql();

function cleanHtml($str){
    $str = trim($str);
    $str = strip_tags($str,"");
    $str = preg_replace("/&.+;/","",$str);
    $str = str_replace("\t","",$str);
    $str = str_replace("\t","",$str);
    $str = str_replace("\r\n","",$str);
    $str = str_replace("\r","",$str);
    $str = str_replace("\n","",$str);
    $str = str_replace(" ","",$str);
    $str = str_replace("	","",$str);
    $str = str_replace("查看知乎讨论"," ",$str);
    $str = str_replace("查看更多讨论"," ",$str);
    return trim($str);
}

function getday($day) {
    if($day == 'today'){
        $webcode = file_get_contents("http://news.at.zhihu.com/api/1.2/news/latest");
        
        file_put_contents('saestor://zhihudaily/' .date('Ymd'). '.txt',$webcode);
    }else{
        $webcode = file_get_contents("http://news.at.zhihu.com/api/1.2/news/before/$day");
    }
    return json_decode($webcode, true);
}

function dealday($html,$mysql,$add) {
    for($i=0;$i<count($html['news']);$i++){
        $news = $html['news'][$i];
        
        if(in_array($news['id'], $add)){
            return false;
        }
            
        $page = json_decode(file_get_contents($news['url']), true);
        $body = mysql_escape_string(cleanHtml($page['body']));
        $title = mysql_escape_string($news['title']);
        
        $true_title = "";
        preg_match_all('/question-title\\">(.+?)</',$page['body'], $matches);
        foreach($matches[1] as $value){
            $true_title .= $value;
        }
        
        $true_title = mysql_escape_string($true_title);
        $share_url = mysql_escape_string($news['share_url']);
        $ga_prefix = mysql_escape_string($news['ga_prefix']);
        $id = $news['id'];
        $sql = "INSERT ignore INTO daily (title,true_title,share_url,ga_prefix,id,body) VALUES ('$title','$true_title','$share_url','$ga_prefix','$id','$body')";
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
    $day = dealday(getday($day),$mysql,$add);
}
