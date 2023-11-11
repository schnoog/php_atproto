<?php  

$config['included'][] = "atp_get_own.php";

/**
 * atp_get_own_blocks_all - Returns ALL blocks of the current used account
 * @return array 
 * @throws RestClientException 
 */
function atp_get_own_blocks_all(){
    global $config;
    $actors = array();
    $singlecall = 100;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_get_own_blocks($singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['blocks'];
        for($x = 0; $x < count($runfol);$x++){
            $actors[] = $runfol[$x];
        }
    }
    return $actors;
}

/**
 * atp_get_own_blocks - Returns blocks of the current used account (limited)
 * @param int $limit 
 * @param string $cursor 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_own_blocks($limit = 50,$cursor = ''){
    global $config;
    $getconfig = [
        'limit' => $limit,       
    ];
    if(strlen($cursor)> 1){
        $getconfig['cursor'] = $cursor;
    } 
    $retval = atp_api_get_data($config['nsid']['getBlocks'],$getconfig);
    return $retval;           
}



/**
 * atp_get_own_timeline_all - returns the all entries from the own timeline
 * @return array 
 * @throws RestClientException 
 */
function atp_get_own_timeline_all(){
    global $config;
    $actors = array();
    $singlecall = 100;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_get_own_timeline($singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['feed'];
        for($x = 0; $x < count($runfol);$x++){
            $actors[] = $runfol[$x];
        }
    }
    return ['feed' => $actors];
}

/**
 * atp_get_own_timeline - returns the number of entries defined from the own timeline
 * @param int $limit 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_own_timeline($limit = 50,$cursor =''){
    global $config;
    $cursor ="x";
    $getconfig = [
        'limit' => $limit,       
    ];
    if(strlen($cursor)> 1){
        $getconfig['cursor'] = $cursor;
    } 
    $retval = atp_api_get_data($config['nsid']['get_timeline'],$getconfig);
    return $retval;
}




/**
 * atp_get_own_notifications - Returns the own notifications (limited)
 * @param int $limit 
 * @param string $cursor 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_own_notifications($limit = 50,$cursor=""){
    global $config;
    $data = [
        'limit' => $limit,
        
    ];
    if(strlen($cursor)> 4){
        $data['cursor'] = $cursor;
    }
    $retval = atp_api_get_data($config["nsid"]['getNotifications'],$data);
    return $retval;
}


/**
 * atp_get_own_notifications_all - Returns ALL own notifications
 * @return mixed 
 * @throws RestClientException 
 */
function atp_get_own_notifications_all(){
        global $config;
        $workA= array();
        $singlecall = 100;
        $cursor = "X";  
        while(strlen($cursor) > 0){
            $work = atp_get_own_notifications($singlecall,$cursor);
            $cursor = "";
            if(isset($work['cursor']))$cursor = $work['cursor'];
            $runfol = $work['notifications'];
            for($x = 0; $x < count($runfol);$x++){
                $workA[] = $runfol[$x];
            }
        }
        return ["notifications" => $workA];
}

