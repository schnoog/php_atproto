<?php 

$config['included'][] = "atp_post.php";

/**
 * atp_api_post_data  Expects a NSID and some data, returns whatever the endpoint puts out
 * @param mixed $nsid 
 * @param mixed $data 
 * @return bool 
 * @throws RestClientException 
 */

 function atp_api_post_data($nsid, $data = null,$content_type = 'application/json',$encode_body=true,$ignore_response = false)
 {
     global $config;
     if (!atp_session_get()) {
         return false;
     }
     $debugthis = false;

     $baseurl = $config['atproto']['server'] . $config['atproto']['xrpc-prefix'] . $nsid;
     $headers['Authorization'] = 'Bearer '. $config['session']['accessJwt'];
     if($content_type != 'application/json'){
        $headers["Content-Type"] =  $content_type;
     }

    $clienconfig =     [
                            'base_url' => $baseurl,
                            'headers' => $headers
                        ];
    if(isset($config['check_ssl_cert'])){
        if(!$config['check_ssl_cert'] ){
            $clienconfig['curl_options'] = [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false

            ];
        }
    }
    
    $client = new RestClient($clienconfig); 

    if($encode_body){
        $sendData = json_encode($data);
        DebugOut(json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK ),"Senddata - JSON_REQUEST");
    }else{
        $sendData = $data;
        DebugOut( substr($sendData,0,100),"Senddata - no json",$debugthis);
    }


     
 
     $result = $client->post('', $sendData, array('Content-Type' => $content_type));
     
     $tmpX  = json_decode(json_encode($result,JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK  ), true);
     
     if($tmpX['response_status_lines'][0] == "HTTP/2 200") {
        
        if(!$ignore_response){
         $retval = json_decode(json_encode($result->decode_response()), true);
         DebugOut($retval, "retval", $debugthis);
         return $retval;
        }
        return [];

     } else {
         $config['error'] = $tmpX['response_status_lines'][0];
         DebugOut($tmpX, "ERROR", $debugthis);
         return false;
     }
 }    
 