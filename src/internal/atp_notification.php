<?php  

$config['included'][] = "atp_notification.php";


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