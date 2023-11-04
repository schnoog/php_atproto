<?php 

$config['maindir'] = __DIR__ ."/";
$config['internaldir'] =  $config['maindir'] . "internal/";

require_once($config['maindir'] . "includer.php");


//print_r($config);
if (!atp_session_get()){
    echo "UNABLE TO ESTABLISH SESSION" . PHP_EOL;
    print_r($config['error']);
}else{
    echo "Session estalished and checked"  . PHP_EOL;
}