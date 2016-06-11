<?php

function current_time( $type, $gmt = 0 ) {
	        switch ( $type ) {
	                case 'mysql':
	                        return ( $gmt ) ? gmdate( 'Y-m-d H:i:s' ) : gmdate( 'Y-m-d H:i:s', ( time() + ( 8 * HOUR_IN_SECONDS ) ) );
	                case 'timestamp':
	                        return ( $gmt ) ? time() : time() + ( 8 * HOUR_IN_SECONDS );
	                default:
	                        return ( $gmt ) ? date( $type ) : date( $type, time() + ( 8 * HOUR_IN_SECONDS ) );
	        }
	}


function get_users($userName,$platform) {
	global $db;

//	$news_id = (long) $news_id;
	return $db->get_results("SELECT * FROM `users` WHERE `name`  = '$userName' AND `platform`  =  $platform");

}

function get_users_by_userId($userId,$platform) {
	global $db;

//	$news_id = (long) $news_id;
	return $db->get_results("SELECT * FROM `users` WHERE `id`  = $userId AND `platform`  =  $platform");

}

function get_users_bypasswd($userName,$platform,$passwd) {
	global $db;

//	$news_id = (long) $news_id;
	return $db->get_results("SELECT * FROM `users` WHERE `name`  = '$userName' AND `platform`  =  $platform and `pass`  = '$passwd'");
}

function insert_user($userName,$platform,$password) {
	global $db;
	$db->hide_errors();
	$cur_date = current_time('mysql');
	$result = $db->query("insert into users (name,pass,created,platform,loginTime,active) VALUES ('$userName', '$password','$cur_date', '$platform',0,true)");

	if ($result) {
		$id = (int) $db->insert_id;
		return $id;
        } else {
		return false;
	}
}

function update_users_checkcode($userName,$checkcode,$checktime) {
	global $db;
	return $db->query("UPDATE `users` set `checkcode` = $checkcode,`checktime`=$checktime WHERE `name`  = '$userName' ");
}

function update_users_passwd($userName,$passwd) {
	global $db;
	return $db->query("UPDATE `users` set `pass` = '$passwd' WHERE `name`  = '$userName' ");
}

function get_users_checkcode($userName) {
	global $db;
	return $db->get_results("SELECT * FROM `users` WHERE `name`  = '$userName' ");
}

function get_users_choose($userId) {
	global $db;
	return $db->get_results("SELECT * FROM `users_choose` WHERE `userId`  = '$userId' ORDER BY `curDate` DESC ");
}

function get_users_choosebyserverId($userId,$serverId) {
	global $db;
	return $db->get_results("SELECT * FROM `users_choose` WHERE `userId`  = '$userId' AND `serverId`  = '$serverId'");
}

function insert_users_choose($userId,$serverId) {
	global $db;
	$db->hide_errors();
	$cur_date = current_time('timestamp');
	$result = $db->query("insert into users_choose (userId,serverId,curDate) VALUES ($userId,$serverId,$cur_date)");
	if ($result){
		return true;
    } else {
		return false;
	}
}

function update_users_choose($userId,$serverId) {
	global $db;
	$cur_date = current_time('timestamp');
	$db->query("UPDATE `users_choose` set `curDate` = $cur_date WHERE `userId`  = $userId AND `serverId`  = $serverId ");
}

function get_payment($order_id) {
	global $db;

	return $db->get_row("SELECT * FROM `payments` WHERE `orderId`  = $order_id ");
}

function update_payment($orderId,$timestamp,$type,$_order_id) {
	global $db;
	$db->query("UPDATE `payments` set `type` = $type
               ,`timestamp` = $timestamp , `_order_id` = '$_order_id' WHERE `orderId`  = $orderId");
}

function update_payment_orderid($orderId,$_order_id) {
	global $db;
	$db->query("UPDATE `payments` set  `_order_id` = '$_order_id' WHERE `orderId`  = $orderId");
}

function get_payments_log($orderId) {
	global $db;
	return $db->get_row("SELECT * FROM `payments_log` WHERE `orderId`  = '$orderId' ");
}

function insert_payments_log($orderId,$product_id,$amt,$openid,$openkey,$pf,$pfkey,$zoneid,$server_name,$appkey,$appid,$session_id,$session_type){
	global $db;
	$db->hide_errors();
	$cur_date = current_time('timestamp');
	$result = $db->query("insert into payments_log(orderId,product_id,amt,openid,openkey,pf,pfkey,zoneid,server_name,appkey,appid,session_id,session_type) VALUES ('$orderId','$product_id','$amt','$openid','$openkey','$pf','$pfkey','$zoneid','$server_name','$appkey','$appid','$session_id','$session_type')");
	if ($result){
		return true;
    } else {
		return false;
	}
}

function update_payments_log($orderId,$product_id,$amt,$openid,$openkey,$pf,$pfkey,$zoneid,$server_name,$appkey,$appid,$session_id,$session_type,$createTime){
	global $db;
	$db->query("UPDATE payments_log set createTime=$createTime,product_id='$product_id',amt='$amt',openid='$openid',pf='$pf',pfkey='$pfkey',zoneid='$zoneid',server_name='$server_name',appkey='$appkey',appid='$appid',session_id='$session_id',session_type='$session_type' WHERE orderId  = '$orderId' and openkey='$openkey'");
}

function succ_payments_log($orderId,$openkey,$succ) {
	global $db;
	$db->query("UPDATE `payments_log` set  `success` =$succ WHERE `orderId`  = '$orderId' and `openkey`  = '$openkey'");
}

function succ_payments_log_billo($orderId,$openkey,$succ,$billno,$balance) {
	global $db;
	$db->query("UPDATE payments_log set  success = $succ, billno = '$billno', balance = '$balance'  WHERE orderId  = '$orderId' and openkey  = '$openkey'");
}

function get_payments_log_num($createTime) {
	global $db;
	return $db->get_results("SELECT * FROM payments_log WHERE success  <>1 and createTime > $createTime");
}

function get_payments_log_by_openid($openid) {
	global $db;
	return $db->get_results("SELECT * FROM `payments_log` WHERE `openid`  = '$openid' and (`success`<>1 or `success`<>4)");
}

function get_payments_need_finish($serverId) {
	global $db;
	return $db->get_results("SELECT * FROM payments WHERE status  = 2 and serverId=$serverId");
}

?>
