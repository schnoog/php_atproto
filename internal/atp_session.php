<?php

$config['included'][] = "atp_session.php";

/**
 * atp_session_get   Loads the session from session storage or creates a new one
 * @return void 
 */
function atp_session_get(){
    global $config;
    $valid = false;
    if(file_exists($config['sessionstorage'])) {
        $config['session'] = json_decode( file_get_contents($config['sessionstorage'])   ,true);
        if(atp_sessioncheck_check()){
            $valid = true;
        }else{
            $valid = atp_session_check();
        }
    }
    if(!$valid){
            if(file_exists($config['sessionstorage'])) unlink($config['sessionstorage']);
        if(atp_session_create()){
            $valid = true;
            atp_sessioncheck_set(true);
        }else{
            atp_sessioncheck_set(false);
            $config['error'] = "Authentification failed";
        }
    }
    return $valid;
}

/**
 * atp_session_create  Creates an ATP Session, stores the token
 * @param bool $forcenew 
 * @return void 
 */
function atp_session_create($forcenew = false)
{
    global $config;
    $nsid = 'com.atproto.server.createSession';
    $client = new RestClient(array(
        'base_url' => $config['atproto']['server'] . $config['atproto']['xrpc-prefix'] . $nsid,
    ));
    $authdata = [
                    'identifier' => $config['atproto']['account'],
                    "password" => $config['atproto']['password'] 
                ];
    $result = $client->post('', json_encode($authdata), array('Content-Type' => 'application/json'));
    $tmpX  = json_decode(json_encode($result), true);
    if($tmpX['response_status_lines'][0] == "HTTP/2 200") { 
        $config['session'] = json_decode(json_encode($result->decode_response()), true);
        $sessionstring = json_encode($config['session']);
        file_put_contents($config['sessionstorage'], $sessionstring);
        DebugOut($config['session']);
        atp_sessioncheck_set();
        return true;
    }else{
        DebugOut($tmpX['response_status_lines'][0],"ERROR");
        return false;
    }   
    
}    




function atp_session_check(){
    global $config;
    $debugthis = false;
    $nsid = 'app.bsky.feed.getTimeline';
    $api = new RestClient([
        'base_url' => $config['atproto']['server'] . $config['atproto']['xrpc-prefix'] . $nsid, 
        
        'headers' => ['Authorization' => 'Bearer '. $config['session']['accessJwt']], 
    ]);       
    $result = $api->get("", ['limit' => "5"]);
    

    if($result->info->http_code == 200){
        DebugOut($result,"result",$debugthis);
        DebugOut("VALID","",$debugthis);
        atp_sessioncheck_set(true);
        return true;
    }else{
        DebugOut($result,"result",$debugthis);
        DebugOut("INVALID","",$debugthis);
        atp_sessioncheck_set(false);
        return false;
    }
        

}


function atp_sessioncheck_set($valid = true){
    global $config;
    if($valid){
        $nts = time();
        file_put_contents($config['sessionstorage_validstamp'] ,$nts);
    }else{
        if(file_exists($config['sessionstorage_validstamp'] )) unlink($config['sessionstorage_validstamp'] );
    }
}

function atp_sessioncheck_check(){
    global $config;
    if(file_exists($config['sessionstorage_validstamp'] )){
        $tmp = file_get_contents($config['sessionstorage_validstamp'] );
        $maxcheck = time() - $config['atproto']['storedsession_validity'];
        if($tmp < $maxcheck){
            unlink($config['sessionstorage_validstamp']);
            return false;
        }
        return true;
    }else{
        return false;
    }
}


/*    
    $api = new RestClient([
        'base_url' => $config['atproto']['server'] . $config['atproto']['xrpc-prefix' . $nsid, 
        'format' => "json", 
         // https://dev.twitter.com/docs/auth/application-only-auth
        'headers' => ['Authorization' => 'Bearer '.OAUTH_BEARER], 
    ]);    

    $result = $client->post('resource', array(
        'json_data_key' => "JSON Data Value"
    ));

*/



