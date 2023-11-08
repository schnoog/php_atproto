<?php 
require_once(__DIR__ . "/src/includer.php");

/**
 * 
 * That'S just my playground while developing the library
 * This file isn't needed, feel free to delete it
 * 
 */


/*
Let's define some variables
*/
$text = "This is the text to post, \n containing mentioning @develobot.bsky.social and a link https://github.com/schnoog/php_atproto";
$lang = ['de','en'];
$add_link_facets = true;
$add_mentions_facets = true;
$images = [ __DIR__ . "/pic01.jpg" , __DIR__ . "/pic02.jpg"];  
$images_alts = [ '', 'Alt text for second image']; 
$website_uri  = "https://github.com/schnoog/php_atproto"; 
$website_title = "My user defined title"; 
$website_description = "My user defined description";
$website_image = __DIR__ . "/website_image.png"; 

$pu = "at://did:plc:rp2wjmtsimasnyrxyihbd6xk/app.bsky.feed.post/3kdjicidq7z23";
$pc = "bafyreidelk3zrhlmdz32wal5iuakjqeucri6triclboq7zlula6mkbe6ru";
$ru = $pu;
$rc = $pc;

//reply to a post
//$tmp = atp_create_reply($ru,$rc,$pu,$pc,"My first API reply");
//quote a post
$tmp = atp_create_quote($pu,$pc,"My very first API quote. And again the question: Will it work?");
DebugOut($tmp);


//The most simple text post - parsing of mentions and links is ENABLED by default
//$answer = atp_create_post($text);
//DebugOut($answer);
//Now a post, just like above, but this time with the 2 defined images attached, and the $lang keys
//$text = "now test the new library structure";
//$answer = atp_create_post($text,$lang,true,true,$images,$images_alts);

//And now a post which includes a webcard, for which we only provide the URL
//$answer = atp_create_post($text,$lang,true,true,[],[],$website_uri);

//Why not a post with a full user defined webcard? Own title, description and image
//$answer = atp_create_post($text,null,true,true,[],[],$website_uri,$website_title,$website_description,$website_image);

//Get 27 entries of the own timeline and print it by DebugOut
//$timeline = atp_get_own_timeline(27);
//DebugOut($timeline);


//Get the DID identified for a handle 
//$tmp = atp_get_user_did_from_handle("schnoog.eu");
//DebugOut($tmp);
//$data = [
//    'actor' => 'develobot.bsky.social'
//];


//$tmp = atp_api_get_data($config["nsid"]['getfollowers'],$data);

//$userhandle = 'develobot.bsky.social';
//$userhandle = 'schnoog.eu';
//$tmp = atp_get_user_followers($userhandle,3);
//$tmp = atp_get_user_posts($userhandle);
//$tmp = atp_get_user_posts_all($userhandle);
//$tmp = atp_search_user_by_term("merz",2);
//$tmp = atp_search_user_by_termAll("merz");
//$tmp = atp_get_own_blocks();
//$tmp = atp_get_own_blocks_all();

//$tmp = atp_api_get_data('app.bsky.graph.getBlocks',[]);
//DebugOut($tmp,"FINAL OUTPUT");

//Search for posts containing "Arduino" and print the result
//$answer = atp_search_posts_by_term("Arduino");
//DebugOut($tmp);

