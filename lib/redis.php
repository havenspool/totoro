<?php

if ( ! isset($redis) ) {
	$redis = new Redis();
	$redis->connect('127.0.0.1', 6379);
	$redis->auth('E!bRSc%XWgCg4ge');
}

?>
