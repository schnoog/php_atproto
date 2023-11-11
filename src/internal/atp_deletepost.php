<?php 

$config['included'][] = "atp_deletepost.php";

/**
 * atp_delete_post - deletes an own post 
 * @param mixed $post_rkey 
 * @return bool 
 * @throws RestClientException 
 */
function atp_delete_post($post_rkey){
    global $config;
    $nsid =  $config['nsid']['deleteRecord'];
    $data = [
	    "repo"=> $config['atproto']['account'] ,
        "collection"=> $config['nsid']['post'],
	    "rkey"=> $post_rkey
    ];
    atp_api_post_data($nsid,$data,'application/json',true,true);
    return true;
}