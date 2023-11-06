<?php 


$config['atproto']['server'] = "https://bsky.social/";
$config['atproto']['xrpc-prefix'] = "xrpc/";
$config['atproto']['account'] = ""; // your handle, mine is "develobot.bsky.social"
$config['atproto']['password'] = "";
$config['atproto']['service'] = "bsky";
$config['atproto']['searchURL'] = "https://search.bsky.social/search/posts";
$config['check_ssl_cert'] = false;

$config['atproto']['storedsession_validity'] = 600;  //the check for a valid stored auth token is valid for this amount of seconds

$config['database']['host'] = "localhost";
$config['database']['name'] = "atproto";
$config['database']['user'] = "atproto";
$config['database']['password'] = "";
$config['database']['port'] = 3306;

