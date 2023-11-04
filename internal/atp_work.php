<?php

$config['included'][] = "atp_work.php";


function atp_helper_get_mention_facets_from_text($text){
    global $config;
    $facets = [];

    $pattern = '#(?<=^|\W)(@' . $config['REGEXP_HANDLE'] . ')#';
    preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);

    foreach ($matches[0] as $match) {
        $handle = $match[0];
        $start = $match[1];

        $did = atp_get_did_from_handle(substr($handle, 1));
        $facet =[ 
            'did' => $did,
            'start' =>  $start,
            'end' => $start + strlen($handle)
        ];
        $facets[] = $facet; 

    }
    return $facets;
}


function atp_get_did_from_handle($handle){
    global $config;
    $data = [
                'handle' => $handle,
    ];
    $diddata = atp_get_data('com.atproto.identity.resolveHandle',$data);
    if(!$diddata) return false;
    return $diddata['did'];
}



/**
 * 
 * @param mixed $text 
 * @param mixed $langs 
 * @param bool $add_link_facets 
 * @param bool $add_mentions_facets 
 * @return bool 
 * @throws RestClientException 
 */

function atp_create_post($text,$langs = null,$add_link_facets = true, $add_mentions_facets = true){
    global $config;
    if (!atp_session_get()) {
        return false;
    }
    $facets = array();

    if($add_link_facets){
        $link_facets =  atp_helper_get_link_facets_from_text($text);
        if(count($link_facets)> 0){
            for($x = 0; $x < count($link_facets);$x++){
                $facet = [
                    'index'=>[
                        "byteStart" => $link_facets[$x]['start'],
                        "byteEnd" => $link_facets[$x]['end']
                    ],
                    'features'=>[[
                        '$type'=> "app.bsky.richtext.facet#link",
                        'uri' => $link_facets[$x]['url']
                    ]]
                ];
                $facets[] = $facet;
            }
        }
    }

    if($add_mentions_facets){
        $mention_facets = atp_helper_get_mention_facets_from_text($text);
        if(count($mention_facets)>0){
            for($x=0; $x < count($mention_facets);$x++){
                $facet = [
                    'index'=>[
                        "byteStart" => $mention_facets[$x]['start'],
                        "byteEnd" => $mention_facets[$x]['end']
                    ],
                    'features'=>[[
                        '$type'=> "app.bsky.richtext.facet#mention",
                        'did' => $mention_facets[$x]['did']
                    ]]
                ];
                $facets[] = $facet;


            }
        }
    }


    $nsid = 'com.atproto.repo.createRecord';
    $pdate = date(('Y-m-d\\TH:i:s.u\\Z'));
    $record = [
        '$type'=>'app.bsky.feed.post',
        "text"=>$text,
        "createdAt"=>date(('Y-m-d\\TH:i:s.u\\Z'))
    ];
    if(count($facets)> 0){
        $record['facets'] = $facets;
    }
    DebugOut($record,"RECORD");

    //    $did = json_encode( explode(":",substr($config['session']["did"],4)) );//  substr($config['session']["did"],4)
//    DebugOut($did,"DID");
    $data = [
        "repo" => $config['session']["did"],
        "collection" =>"app.bsky.feed.post",
        "record" => $record,
    ];


    $ret = atp_post_data($nsid,$data);
    return $ret;
    

}








/**
 * atp_post_data  Expects a NSID and some data, returns whatever the endpoint puts out
 * @param mixed $nsid 
 * @param mixed $data 
 * @return bool 
 * @throws RestClientException 
 */

function atp_post_data($nsid, $data = null)
{
    global $config;
    if (!atp_session_get()) {
        return false;
    }
    $debugthis = true;

    $client = new RestClient(array(
        'base_url' => $config['atproto']['server'] . $config['atproto']['xrpc-prefix'] . $nsid,
        'headers' => ['Authorization' => 'Bearer '. $config['session']['accessJwt']],
    ));

    DebugOut(json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ),"JSON_REQUEST");

    $result = $client->post('', json_encode($data), array('Content-Type' => 'application/json'));
    
    $tmpX  = json_decode(json_encode($result,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK  ), true);
    
    if($tmpX['response_status_lines'][0] == "HTTP/2 200") {
        $retval = json_decode(json_encode($result->decode_response()), true);
        DebugOut($retval, "retval", $debugthis);
        return $retval;
    } else {
        $config['error'] = $tmpX['response_status_lines'][0];
        DebugOut($tmpX, "ERROR", $debugthis);
        return false;
    }
}    
    
    /*
    $api = new RestClient([
        'base_url' => $config['atproto']['server'] . $config['atproto']['xrpc-prefix'] . $nsid, 
        
        'headers' => ['Authorization' => 'Bearer '. $config['session']['accessJwt']], 
    ]); 
    if(is_null($data)){
        $result = $api->get("");
    }else{
        $result = $api->get("", $data);
    }      
    if($result->info->http_code == 200){
        DebugOut($result,"result",$debugthis);
        DebugOut("VALID","",$debugthis);
        $retval =  json_decode(json_encode($result->decode_response()), true);
        return $retval;
    }else{
        DebugOut($result,"result",$debugthis);
        DebugOut("INVALID","",$debugthis);
        return false;
    }
    */
