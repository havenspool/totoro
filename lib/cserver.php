<?php
header ("Content-type: application/json; charset=utf-8");

require_once( './config.php');
require_once( './db.php');
require_once( './redis.php');
require_once( './users.php');

//$cur_date = current_time('timestamp');

//echo $cur_date;

$userId = isset($_GET['userId']) ? $_GET['userId'] : NULL;
$serverId = isset($_GET['serverId']) ? $_GET['serverId'] : NULL;

$server = get_users_choosebyserverId($userId,$serverId);

//print_r($server);

//echo count($server);

//echo "insert into users_choose (userId,serverId,curDate) VALUES ($userId,$serverId,$cur_date)";

//echo "UPDATE `users_choose` set `curDate` = $cur_date WHERE `userId`  = $userId AND `serverId`  = $serverId ";

if ($server == null || count($server)==0) {
	insert_users_choose($userId,$serverId);
} else {
	update_users_choose($userId,$serverId);
}

$result["cmd"] = "cserver";
$result["result"] = true;
echo  json_encode($result);

?>
