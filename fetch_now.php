<?php
$mem = memcache_init();
$mem->set('today', file_get_contents("http://news.at.zhihu.com/api/1.2/news/latest"), 0, 0);
