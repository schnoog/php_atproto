<?php  

$config['included'][] = "atp_graph.php";


/**
 * atp_get_user_followers returns the followers of a user handle (limited)
 * @param mixed $userhandle 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_user_followers($userhandle,$limit = 50,$cursor=""){
    global $config;
    $data = [
        'actor' => $userhandle,
        'limit' => $limit,
        
    ];
    if(strlen($cursor)> 4){
        $data['cursor'] = $cursor;
    }
    $retval = atp_api_get_data($config["nsid"]['getfollowers'],$data);
    return $retval;
}


/**
 * atp_get_user_followers_all returns ALL the followers of a user handle in a handy array
 * @param mixed $userhandle 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_user_followers_all($userhandle){
        global $config;
        $followers = array();
        $singlecall = 100;
        $cursor = "X";  
        while(strlen($cursor) > 0){
            $work = atp_get_user_followers($userhandle,$singlecall,$cursor);
            $cursor = "";
            if(isset($work['cursor']))$cursor = $work['cursor'];
            $runfol = $work['followers'];
            for($x = 0; $x < count($runfol);$x++){
                $followers[] = $runfol[$x];
            }
        }
        return $followers;
}