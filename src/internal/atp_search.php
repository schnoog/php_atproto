<?php

$config['included'][] = "atp_search.php";

/**
 * atp_person_searchAll - Returns ALL persons / actors for a search term
 * @param mixed $searchterm 
 * @return array 
 * @throws RestClientException 
 */

 function atp_person_searchAll($searchterm){
    global $config;
    $actors = array();
    $singlecall = 100;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_person_search($searchterm,$singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['actors'];
        for($x = 0; $x < count($runfol);$x++){
            $actors[] = $runfol[$x];
        }
    }
    return $actors;
}

/**
 * atp_person_search - Returns the persons / actors for a search term (limit)
 * @param mixed $searchterm 
 * @param int $limit 
 * @param string $cursor 
 * @return bool 
 * @throws RestClientException 
 */
function atp_person_search($searchterm,$limit = 50,$cursor = ''){
    global $config;
    $getconfig = [
        'q' => $searchterm,
        'limit' => $limit,       
    ];
    if(strlen($cursor)> 1){
        $getconfig['cursor'] = $cursor;
    } 
    $retval = atp_get_data($config['nsid']['searchPerson'],$getconfig);
    return $retval;           
}


/**
 * atp_post_search - Search posts by searchterm - non API call
 * @param mixed $searchterm 
 * @return mixed 
 */
function atp_post_search($searchterm){
    global $config;
    $searchURL = $config['atproto']['searchURL'] . "?q=" . urlencode($searchterm);
    $ret = file_get_contents($searchURL);
    $retval = json_decode(  $ret ,true);
    return $retval;
}

/**
 * atp_get_users_posts - get posts from the feed of a user
 * @param mixed $userhandle 
 * @param int $limit 
 * @param string $cursor 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_users_posts($userhandle,$limit = 50,$cursor = ""){
    global $config;
    $getconfig['limit'] = $limit;
    $getconfig['actor'] = $userhandle;
    if(strlen($cursor)>1) $getconfig['cursor'] = $cursor;
    $retval = atp_get_data($config['nsid']['getAuthorFeed'],$getconfig);
    return $retval;    
}
/**
 * atp_getAll_users_posts - get ALL posts from the feed of a user
 * @param mixed $userhandle 
 * @return array 
 * @throws RestClientException 
 */
function atp_getAll_users_posts($userhandle){
    global $config;
    $feeds = array();
    $singlecall = 50;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_get_users_posts($userhandle,$singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['feed'];
        for($x = 0; $x < count($runfol);$x++){
            $feeds[] = $runfol[$x];
        }
    }
    return $feeds;
}
