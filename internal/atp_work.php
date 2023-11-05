<?php

$config['included'][] = "atp_work.php";



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
    
    $mtags = atp_getMetaTags($fp);

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



function atp_getMetaTags($str)
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

