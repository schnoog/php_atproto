<?php

global $config;
global $NSID;

$config['maindir'] = __DIR__ ."/";
$config['internaldir'] =  $config['maindir'] . "internal/";
$config['projectpath'] = getcwd() . "/";

/**
 * First step: Read the config and create the session array
 */
require_once($config['projectpath'] . "config.php");
$config['session'] = [];
$config['error'] = [];

/**
 * Let's start with including the composer stuff - but only if not installed by composer
 */
$incs = get_included_files();
$isin = false;
for($x=0;$x < count($incs); $x++){
		$inc = $incs[$x];
		if( strpos($inc,"autoload.php") > 0) $isin = true;
		
}
if(!$isin) {
	require_once(__DIR__. "../../vendor/autoload.php");
}

/**
 * And now include all the php files in the internal directory
 */

foreach(glob($config['internaldir'] . "*.php") as $file){
    require_once $file;
}

//echo "<pre>" . print_r(get_included_files(),true)."</pre>";
/**
 * And now bootstrapping
 */
$config['sessionstorage'] =  sys_get_temp_dir() . "/atproto.session";
$config['sessionstorage_validstamp'] = $config['sessionstorage'] . "_check";
$config['tmp_blob_path'] = sys_get_temp_dir();


$config['nsid'] = $NSID[$config['atproto']['service']];





