<?php

$config['included'][] = "atp_common_helper.php";

$config['REGEXP_HANDLE'] = '([a-zA-Z0-9]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)' .
'+[a-zA-Z]([a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?';

$config['REGEXP_URL'] = 'https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~\#=]{1,256}\.' .
'[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~\#?&//=]*[-a-zA-Z0-9@%_\+~\#//=])?';


/**
 * atp_get_website_info - expects at least an URL to an external webpage, image, title and description are optional
 * @param mixed $url 
 * @param string $image 
 * @param string $title 
 * @param string $desc 
 * @return array 
 */
function atp_get_website_info($url,$image ="" ,$title="",$desc=""){
    $wc['image'] = '';     $wc['desc'] = '';    $wc['title'] = '';
    $OK_img = false;    $OK_title = false;    $OK_desc = false;
    
    if(strlen($image)> 0){
        $wc['image'] = $image;
        $OK_img = true;
    }    
    if(strlen($title)> 0){
        $wc['title'] = $title;
        $OK_title = true;
    }
    if(strlen($desc)> 0){
        $wc['desc'] = $desc;
        $OK_desc = true;
    }        
    if( $OK_desc and $OK_img and $OK_title  ){
        return $wc;       
    }

    $fp = file_get_contents($url);
    if (!$fp){ 
        return $wc;
    }
    
    $mtags = atp_helper_get_metatags($fp);

    if(!$OK_img){
        if(isset($mtags['og:image'])) {
            $wc['image'] = $mtags['og:image'];
            $OK_img = true;
        }
    }

    if(!$OK_title){
        if(isset($mtags['og:title'])) {
            $wc['title']  = $mtags['og:title'];
            $OK_title = true;
        }
    }

    if(!$OK_desc){
        if(isset($mtags['description'])) {
            $wc['desc']  = $mtags['description'];
            $OK_desc = true;
        }

    }

    if(!$OK_title){
        $res = preg_match("/<title>(.*)<\/title>/siU", $fp, $title_matches);
        if ($res){
            $mtitle = preg_replace('/\s+/', ' ', $title_matches[1]);
            $mtitle = trim($mtitle);
            if(strlen($mtitle)> 0){
                $wc['title'] = $mtitle;
                $OK_title = true;
            }
        } 
    }



    if(!$OK_title) $wc['title'] = explode("/",$url,3)[2];
    if(!$OK_desc) $wc['desc'] = $url;


     return $wc;
}


/**
 * atp_helper_get_metatags - regex extraction of meta tags of a given string
 * @param mixed $str 
 * @return array 
 */

 function atp_helper_get_metatags($str)
 {
   $pattern = '
   ~<\s*meta\s
 
   # using lookahead to capture type to $1
     (?=[^>]*?
     \b(?:name|property|http-equiv)\s*=\s*
     (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
     ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
   )
 
   # capture content to $2
   [^>]*?\bcontent\s*=\s*
     (?|"\s*([^"]*?)\s*"|\'\s*([^\']*?)\s*\'|
     ([^"\'>]*?)(?=\s*/?\s*>|\s\w+\s*=))
   [^>]*>
 
   ~ix';
   
   if(preg_match_all($pattern, $str, $out))
     return array_combine($out[1], $out[2]);
   return array();
 }

 

/**
 * atp_helper_get_mention_facets_from_text - extracts positions the mentions of users in the text given which will be replaced by links
 * @param mixed $text 
 * @return array 
 * @throws RestClientException 
 */
function atp_helper_get_mention_facets_from_text($text){
    global $config;
    $facets = [];

    $pattern = '#(?<=^|\W)(@' . $config['REGEXP_HANDLE'] . ')#';
    preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);

    foreach ($matches[0] as $match) {
        $handle = $match[0];
        $start = $match[1];

        $did = atp_get_user_did_from_handle(substr($handle, 1));
        $facet =[ 
            'did' => $did,
            'start' =>  $start,
            'end' => $start + strlen($handle)
        ];
        $facets[] = $facet; 

    }
    return $facets;
}

/**
 * atp_helper_get_link_facets_from_text  - extracts the positions of uri which will be replaced by links
 * @param mixed $text 
 * @return array 
 */
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
 * atp_helper_get_currentdate_formatted - returns the current date in the format expected by the API
 * @return string 
 */
function atp_helper_get_currentdate_formatted(){
    return date(('Y-m-d\\TH:i:s.u\\Z'));
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



