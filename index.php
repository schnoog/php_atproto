<?php 
require_once(__DIR__ . "/includer.php");



//echo  atp_create_post("OMG. That's really working... my own php atproto implementations makes it to post on bluesky....");

//DebugOut($config);

$text = "Let's try mention someone @schnoog.eu and 2 clickable links... will it work?... http://bsky.app hm..... https://schnoog.eu ..";
//$tmp =  atp_helper_get_link_facets_from_text($text);

//$tmp = atp_helper_get_mention_facets_from_text($text);

$tmp = atp_create_post($text,["de"],true,true);
DebugOut($tmp);



/*
$retval = atp_get_data("app.bsky.feed.getTimeline",["limit" => 50]);
DebugOut($retval);
*/

//DebugOut($config['session']['accessJwt']);

/*
if (!atp_session_get()){
    echo "UNABLE TO ESTABLISH SESSION" . PHP_EOL;
    print_r($config['error']);
}else{
    echo "Session estalished and checked"  . PHP_EOL;
}
*/