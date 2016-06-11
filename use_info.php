<?php
header ("Content-type: application/json; charset=utf-8");
@ini_set('memory_limit', '1024M');

require_once( './lib/config.php');
require_once( './lib/db.php');
require_once( './lib/redis.php');
require_once( './lib/users.php');

$userId = isset($_GET['userId']) ? $_GET['userId'] : 0;
$token = isset($_GET['token']) ? $_GET['token'] : NULL;

$result = Array();
$result["cmd"] = "use_info";

$users = get_users($userId);
if ($users == null) {
    return_result($result,false,1001);
} else {
    user_info($result,$userName,$users[0],$redis);
}

function user_info($result,$userName,$user,$redis){
	$userInfo = Array();
	$userInfo["userId"] = $user->id;
    $userInfo["coin"] = $user->coin;
	$result["userInfo"] = $userInfo;
	return_result($result,true,null);
}

function return_result($result,$isSuccess,$errorCode){
	$result["isSuccess"] =$isSuccess;
	$result["errorCode"] = $errorCode;
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
	return;
}
?>
