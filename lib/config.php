<?php
// ** MySQL settings ** //
define('DB_NAME', 'game_ios_user');    // The name of the database
define('DB_USER', 'root');     // Your MySQL username
define('DB_PASSWORD', 'it1S4Qn5xW7y'); // ...and password
define('DB_HOST', '127.0.0.1');    // 99% chance you won't need to change this value
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

$charset = 'utf-8';

date_default_timezone_set('PRC');

define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );


define('OBJECT', 'OBJECT');
define('object', 'OBJECT');

define('ARRAY_A', 'ARRAY_A');
define('ARRAY_N', 'ARRAY_N');

?>
