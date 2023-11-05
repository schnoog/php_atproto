<?php

$config['included'][] = "atp_work.php";


function atp_post_search($searchterm){
    global $config;
    $searchURL = $config['atproto']['searchURL'] . "?q=" . urlencode($searchterm);
    $ret = file_get_contents($searchURL);
    $retval = json_decode(  $ret ,true);
    return $retval;
}


/*

    Somehow I'm unable to "GET" any resonse but
    "Cannot GET /xrpc/app.bsky.feed.searchPosts"
    from app.bsky.feed.searchPosts

	params 
		"cursor": cursor,
		"limit":  limit,
		"q":      q,
	


*/




