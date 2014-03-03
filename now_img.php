<?php
header("Content-type:image/gif");
$mem = memcache_init();

echo $mem->get("now_img");
