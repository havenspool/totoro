<?php
header ("Content-type: application/json; charset=utf-8");
@ini_set('memory_limit', '1024M');

require_once( './lib/config.php');
require_once( './lib/db.php');
require_once( './lib/redis.php');
require_once( './lib/users.php');

$userName = isset($_GET['userName']) ? $_GET['userName'] : NULL;
$userPwd = isset($_GET['userPwd']) ? $_GET['userPwd'] : NULL;
$version = isset($_GET['version']) ? $_GET['version'] : 0;
$channel = isset($_GET['channel']) ? $_GET['channel'] : NULL;
$retainStr = isset($_GET['retainStr']) ? $_GET['retainStr'] : NULL;


$result = Array();
$result["cmd"] = "user_login";

$users = get_users($userName,$channel);
if ($users == null) {
    $_user = insert_user($userName,$channel,md5($userPwd.$userName));
    if ($_user!=null) {
        $users = get_users($userName,$channel);
        login_succ($result,$userName,$users[0],true,$redis);
    } else {
        return_result($result,false,1001);
    }
} else {
    if(md5($password.$userName) == $users[0]->pass) {
		login_succ($result,$userName,$users[0],$redis);
	}else {
		return_result($result,false,1002);
	}
}

function login_succ($result,$userName,$user,$redis){
	$loginTime = current_time('timestamp',1);
	$token = md5($userName.$loginTime);
	$userInfo = Array();
	$userInfo["userId"] = $user->id;
	$userInfo["token"] = $token;
	$userInfo["loginTime"] = $loginTime;
	$userInfo["unlockTime"] = $user->unlockTime;
    $userInfo["coin"] = 0;

	$tokenkey='login_'.$user_id;
	$tokenvalue=$token . "," . $loginTime;
	send_token_to_local_redis($tokenkey, $tokenvalue,$redis);
	$result["userInfo"] = $userInfo;
	return_result($result,true,null);
}

function return_result($result,$isSuccess,$errorCode){
	$result["isSuccess"] =$isSuccess;
	$result["errorCode"] = $errorCode;
	echo json_encode($result,JSON_UNESCAPED_UNICODE); 
	return;
}

function send_token_to_local_redis($token_key,$token,$redis){
	$redis->set($token_key,$token);
}

?>
