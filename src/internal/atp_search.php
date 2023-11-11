<?php

$config['included'][] = "atp_search.php";

/**
 * atp_search_user_by_termAll - Returns ALL persons / actors for a search term
 * @param mixed $searchterm 
 * @return array 
 * @throws RestClientException 
 */

 function atp_search_user_by_term_all($searchterm){
    global $config;
    $actors = array();
    $singlecall = 100;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_search_user_by_term($searchterm,$singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['actors'];
        for($x = 0; $x < count($runfol);$x++){
            $actors[] = $runfol[$x];
        }
    }
    return ['actors' => $actors];
}

/**
 * atp_search_user_by_term - Returns the persons / actors for a search term (limit)
 * @param mixed $searchterm 
 * @param int $limit 
 * @param string $cursor 
 * @return bool 
 * @throws RestClientException 
 */
function atp_search_user_by_term($searchterm,$limit = 50,$cursor = ''){
    global $config;
    $getconfig = [
        'q' => $searchterm,
        'limit' => $limit,       
    ];
    if(strlen($cursor)> 1){
        $getconfig['cursor'] = $cursor;
    } 
    $retval = atp_api_get_data($config['nsid']['searchPerson'],$getconfig);
    return $retval;           
}


/**
 * atp_search_posts_by_term - Search posts by searchterm - non API call
 * @param mixed $searchterm 
 * @return mixed 
 */
function atp_search_posts_by_term($searchterm){
    global $config;
    $searchURL = $config['atproto']['searchURL'] . "?q=" . urlencode($searchterm);
    $ret = file_get_contents($searchURL);
    $retval = json_decode(  $ret ,true);
    return $retval;
}

/**
 * atp_get_user_posts - get posts from the feed of a user
 * @param mixed $userhandle 
 * @param int $limit 
 * @param string $cursor 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_user_posts($userhandle,$limit = 50,$cursor = ""){
    global $config;
    $getconfig['limit'] = $limit;
    $getconfig['actor'] = $userhandle;
    if(strlen($cursor)>1) $getconfig['cursor'] = $cursor;
    $retval = atp_api_get_data($config['nsid']['getAuthorFeed'],$getconfig);
    return $retval;    
}
/**
 * atp_get_user_posts_all - get ALL posts from the feed of a user
 * @param mixed $userhandle 
 * @return array 
 * @throws RestClientException 
 */
function atp_get_user_posts_all($userhandle){
    global $config;
    $feeds = array();
    $singlecall = 50;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_get_user_posts($userhandle,$singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['feed'];
        for($x = 0; $x < count($runfol);$x++){
            $feeds[] = $runfol[$x];
        }
    }
    return ['feed' => $feeds];
}

