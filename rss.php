<?php
$mysql = new SaeMysql();
header('Content-type: text/xml; charset=utf-8');

$str .= '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$str .= '<rss version="2.0"' . "\n";
$str .= 'xmlns:content="http://purl.org/rss/1.0/modules/content/"' . "\n";
$str .= 'xmlns:wfw="http://wellformedweb.org/CommentAPI/"' . "\n";
$str .= 'xmlns:dc="http://purl.org/dc/elements/1.1/"' . "\n";
$str .= 'xmlns:atom="http://www.w3.org/2005/Atom"' . "\n";
$str .= 'xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"' . "\n";
$str .= 'xmlns:slash="http://purl.org/rss/1.0/modules/slash/"' . "\n";
$str .= '>' . "\n";
$str .= '<channel>' . "\n";
$str .= '<title>知乎日报</title>' . "\n";
$url = 'http://'  . $_SERVER['SERVER_NAME'] . ($_SERVER["SERVER_PORT"] == 80 ? '' : ':' . $_SERVER["SERVER_PORT"]) . $_SERVER["REQUEST_URI"]; 
$str .= '<atom:link href="' . $url . '" rel="self" type="application/rss+xml" />' . "\n";
$str .= '<link>http://zhihudaily.sinaapp.com/</link>' . "\n";
$str .= '<description>知乎日报</description>' . "\n";
$str .= '<lastBuildDate>'. date(DATE_RSS) . '</lastBuildDate>' . "\n";
$str .= '<language>zh-CN</language>' . "\n";
$str .= '<sy:updatePeriod>faceair</sy:updatePeriod>' . "\n";
$str .= '<generator>http://zhihudaily.sinaapp.com/</generator>' . "\n";

$day = date('Ymd',time() - 3600*24);
$items = $mysql->getData("SELECT * FROM `zhihudaily` WHERE date = '$day' ORDER BY - `date_index`");
foreach($items as $item){ 
    $str .= '<item>' . "\n";
    $str .= '<title><![CDATA[' . $item['title'] . ']]></title>' . "\n";
    $str .= '<link>' . $item['share_url'] . '</link>' . "\n";
    $str .= '<pubDate>' . date(DATE_RSS,mktime(substr($item['ga_prefix'],4,2),0,0,substr($item['date'],4,2),substr($item['date'],6,2),substr($item['date'],0,4))) . '</pubDate>' . "\n";
    $str .= '<dc:creator>知乎日报</dc:creator>' . "\n";
    $str .= '<guid isPermaLink="false">' . $item['share_url'] . '</guid>' . "\n";
    $str .= '<description><![CDATA[' . $item['body'] . ']]></description>' . "\n";
    $str .= '<content:encoded><![CDATA[' . $item['body'] . ']]></content:encoded>' . "\n";
    $str .= '</item>' . "\n";
} 

$str .= '</channel>' . "\n";
$str .= '</rss>' . "\n";
echo $str;
