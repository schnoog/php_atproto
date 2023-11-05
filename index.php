<?php 
require_once(__DIR__ . "/includer.php");

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


//DebugOut($config['nsid']);

//The most simple text post - parsing of mentions and links is ENABLED by default
//$answer = atp_create_post($text);

//Now a post, just like above, but this time with the 2 defined images attached, and the $lang keys
//$answer = atp_create_post($text,$lang,true,true,$images,$images_alts);

//And now a post which includes a webcard, for which we only provide the URL
//$answer = atp_create_post($text,$lang,true,true,[],[],$website_uri);

//Why not a post with a full user defined webcard? Own title, description and image
//$answer = atp_create_post($text,null,true,true,[],[],$website_uri,$website_title,$website_description,$website_image);

//Get 27 entries of the own timeline and print it by DebugOut
//$timeline = atp_get_timeline(27);
//DebugOut($timeline);


//Get the DID identified for a handle 
//$tmp = atp_get_did_from_handle("develobot.bsky.social");
//DebugOut($tmp);

//Search for posts containing "Arduino" and print the result
$answer = atp_post_search("Arduino");
DebugOut($answer);
