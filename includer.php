<?php

$config['maindir'] = __DIR__ ."/";
$config['internaldir'] =  $config['maindir'] . "internal/";

/**
 * First step: Read the config and create the session array
 */
require_once($config['maindir'] . "config.php");
$config['session'] = [];
$config['error'] = [];

/**
 * Let's start with including the composer stuff
 */

require_once($config['maindir'] . "vendor/autoload.php");

/**
 * And now include all the php files in the internal directory
 */

foreach(glob($config['internaldir'] . "*.php") as $file){
    require $file;
}


/**
 * And now bootstrapping
 */
$config['sessionstorage'] =  sys_get_temp_dir() . "/atproto.session";
$config['sessionstorage_validstamp'] = $config['sessionstorage'] . "_check";




