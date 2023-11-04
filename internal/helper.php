<?php

$config['included'][] = "helper.php";

$config['REGEXP_HANDLE'] = '([a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)' .
'+[a-zA-Z]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?';

$config['REGEXP_URL'] = 'https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~\#=]{1,256}\.' .
'[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~\#?&//=]*[-a-zA-Z0-9@%_\+~\#//=])?';





function atp_helper_get_link_facets_from_text($text)
    {
        global $config;
        $facets = [];
        $pattern = '#(?<=^|\W)(' . $config['REGEXP_URL'] . ')#';
        preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $match) {
            $url = $match[0];
            $start = $match[1];

            $facets[]=[
                'url' => $url,
                'start' => $start,
                'end' => $start + strlen($url)
            ];
        }

        return $facets;
}



/**
 * Ugly debug output.....
 * @param mixed $data 
 * @param string $label 
 * @param bool $dosomething 
 * @return true|void 
 */

function DebugOut($data,$label = "",$dosomething = true){
    if(!$dosomething) return true;
    echo PHP_EOL;
    if(php_sapi_name() != "cli") echo "<hr>";
    if(strlen($label)> 0){
        echo $label . PHP_EOL . PHP_EOL;
    }
    if(php_sapi_name() != "cli"){
        echo "<pre>" . print_r($data,true). "</pre>";
    }else{
        print_r($data);
    }
    echo PHP_EOL;
    if(php_sapi_name() != "cli") echo "<hr>";    


}



