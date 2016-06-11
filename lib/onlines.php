<?php
require_once( 'redis.php');	
$servers=require_once( 'servers.php');

function deep_in_array($value, $array) {   
    foreach($array as $item) {   
        if(!is_array($item)) {   
            if ($item == $value) {  
                return true;  
            } else {  
                continue;   
            }  
        }   
           
        if(in_array($value, $item)) {  
            return true;      
        } else if(deep_in_array($value, $item)) {  
            return true;      
        }  
    }   
    return false;   
}

$confs=array();
foreach($servers as $server){
    $conf=$server;
    if($conf["status"]!=4){
        if($conf["snake_max2"]<=$conf["snake_onlines"]&&$conf["eagle_onlines"]>=$conf["eagle_max2"])
            $conf["status"]=3;
        else if($conf["snake_max1"]<$conf["snake_onlines"]&&$conf["snake_onlines"]<$conf["snake_max2"]&&$conf["eagle_onlines"]>$conf["eagle_max1"]&&$conf["eagle_onlines"]<$conf["eagle_max2"])
            $conf["status"]=2;
        else
            $conf["status"]=1;     
    }
	array_push($confs,$conf);
}

return $confs;
?>