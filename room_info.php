<?php
header ("Content-type: application/json; charset=utf-8");
@ini_set('memory_limit', '1024M');

require_once( './lib/config.php');
require_once( './lib/db.php');
require_once( './lib/users.php');

$userId = isset($_GET['userId']) ? $_GET['userId'] : 0;
$token = isset($_GET['token']) ? $_GET['token'] : NULL;

$result = Array();
$result["cmd"] = "room_info";

$users = get_users_byuserId($userId);
if ($users == null) {
    return_result($result,false,1001);
} else {
    room_info($result);
}

function room_info($result){
	$roomsInfoList = Array();
	$roomsInfoList["roomId"] = 10001;
    $roomsInfoList["roomName"] = "招财进宝";
    $roomsInfoList["minCost"] = 1000;
    $roomsInfoList["condition"] = 1;
    $roomsInfoList["onlineNum"] = 10;
    $roomsInfoList["roomNum"] = 100;
	$result["roomsInfoList"] = $roomsInfoList;
	return_result($result,true,null);
}

function return_result($result,$isSuccess,$errorCode){
	$result["isSuccess"] =$isSuccess;
	$result["errorCode"] = $errorCode;
	echo json_encode($result,JSON_UNESCAPED_UNICODE);
	return;
}
?>
