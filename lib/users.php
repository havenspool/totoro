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

function get_users($userName,$channel) {
	global $db;
	return $db->get_results("SELECT * FROM `users` WHERE `name`  = '$userName' AND `channel`  =  '$channel'");

}

function get_users_by_userId($userId,$channel) {
	global $db;
	return $db->get_results("SELECT * FROM `users` WHERE `id`  = $userId AND `channel`  =  '$channel'");

}

function get_users_bypasswd($userName,$channel,$passwd) {
	global $db;
	return $db->get_results("SELECT * FROM `users` WHERE `name`  = '$userName' AND `channel`  =  '$channel' and `passwd`  = '$passwd'");
}

function insert_user($userName,$channel,$passwd) {
	global $db;
	$db->hide_errors();
	$cur_date = current_time('timestamp');
	$result = $db->query("insert into users (name,passwd,registerTime,loginTime,channel) VALUES ('$userName', '$passwd','$cur_date','$cur_date', '$channel')");

	if ($result) {
		$id = (int) $db->insert_id;
		return $id;
        } else {
		return false;
	}
}

function update_users_passwd($userName,$passwd) {
	global $db;
	return $db->query("UPDATE `users` set `passwd` = '$passwd' WHERE `name`  = '$userName' ");
}
?>
