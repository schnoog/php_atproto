<?php  

$config['included'][] = "atp_graph.php";


/**
 * atp_graph_getfollowers returns the followers of a user handle
 * @param mixed $userhandle 
 * @return bool 
 * @throws RestClientException 
 */
function atp_graph_getfollowers($userhandle){
    global $config;
    $data = [
        'actor' => $userhandle
    ];
    
    $retval = atp_get_data($config["nsid"]['getfollowers'],$data);
    return $retval;
}

