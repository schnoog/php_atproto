<?php

$config['included'][] = "atp_get.php";

/**
 * atp_get_data  Expects a NSID and some data, returns whatever the endpoint puts out
 * @param mixed $nsid 
 * @param mixed $data 
 * @return bool 
 * @throws RestClientException 
 */

function atp_get_data($nsid,$data = null){
    global $config;
    if (!atp_session_get())return false;
    $debugthis = true;
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
}