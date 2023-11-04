<?php

$config['included'][] = "helper.php";


function DebugOut($data,$label = "",$dosomething = true){
    if(!$dosomething) return true;
    echo PHP_EOL;
    if(strlen($label)> 0){
        echo $label . PHP_EOL . PHP_EOL;
    }
    print_r($data);
    echo PHP_EOL;


}

