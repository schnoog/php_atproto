<?php  

$config['included'][] = "atp_graph.php";


/**
 * atp_graph_getfollowers returns the followers of a user handle
 * @param mixed $userhandle 
 * @return bool 
 * @throws RestClientException 
 */
function atp_graph_getfollowers($userhandle,$limit = 50,$cursor=""){
    global $config;
    $data = [
        'actor' => $userhandle,
        'limit' => $limit,
        
    ];
    if(strlen($cursor)> 4){
        $data['cursor'] = $cursor;
    }
    $retval = atp_get_data($config["nsid"]['getfollowers'],$data);
    return $retval;
}


/**
 * atp_graph_getAllFollowers returns ALL the followers of a user handle in a handy array
 * @param mixed $userhandle 
 * @return bool 
 * @throws RestClientException 
 */
function atp_graph_getAllFollowers($userhandle){
        global $config;
        $followers = array();
        $singlecall = 100;
        $cursor = "X";  
        while(strlen($cursor) > 0){
            $work = atp_graph_getfollowers($userhandle,$singlecall,$cursor);
            $cursor = "";
            if(isset($work['cursor']))$cursor = $work['cursor'];
            $runfol = $work['followers'];
            for($x = 0; $x < count($runfol);$x++){
                $followers[] = $runfol[$x];
            }
        }
        return $followers;
}