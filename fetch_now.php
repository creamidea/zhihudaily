<?php
$mem = memcache_init();
$today = file_get_contents("http://news.at.zhihu.com/api/1.2/news/latest");
$mem->set('today', $today, 0, 0);

$data = json_decode($today,true);
$mem->set('now_img', file_get_contents($data['news']['0']['image']), 0, 0);
