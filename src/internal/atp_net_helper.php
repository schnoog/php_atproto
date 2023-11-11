<?php

$config['included'][] = "atp_net_helper.php";



function atp_get_own_timeline_all(){
    global $config;
    $actors = array();
    $singlecall = 100;
    $cursor = "X";  
    while(strlen($cursor) > 0){
        $work = atp_get_own_timeline($singlecall,$cursor);
        $cursor = "";
        if(isset($work['cursor']))$cursor = $work['cursor'];
        $runfol = $work['feed'];
        for($x = 0; $x < count($runfol);$x++){
            $actors[] = $runfol[$x];
        }
    }
    return ['feed' => $actors];
}

/**
 * atp_get_own_timeline - returns the number of entries defined from the own timeline
 * @param int $limit 
 * @return bool 
 * @throws RestClientException 
 */
function atp_get_own_timeline($limit = 50,$cursor =''){
    global $config;
    $cursor ="x";
    $getconfig = [
        'limit' => $limit,       
    ];
    if(strlen($cursor)> 1){
        $getconfig['cursor'] = $cursor;
    } 
    $retval = atp_api_get_data($config['nsid']['get_timeline'],$getconfig);
    return $retval;
}


/**
 * atp_create_file_blob - created a blob from a file
 * @param mixed $filename 
 * @return mixed 
 */
function atp_create_file_blob($filename){
    global $config;
    $tmpfile = false;
    if(strpos($filename,"http") === 0){
        $filedata = file_get_contents($filename);
        $tmpname = $config['tmp_blob_path'] . "/" . time() . "_" . basename($filename);
        file_put_contents($tmpname,$filedata);
        $filename = $tmpname;
        $tmpfile = true;

      //  DebugOut(['REMOTE IMAGE'],"REMOTE IMAGE");
    }else{
      //  DebugOut(['LOCAL IMAGE'],"LOCAL IMAGE");

    }

    //if (! file_exists($filename)) return false;
    $blob = array();
    $filedata = file_get_contents($filename);
    $filemime = mime_content_type($filename);
    $nsid = 'com.atproto.repo.uploadBlob';
    $data =  $filedata;
    //DebugOut($filemime,"MIME");
    $retval = atp_api_post_data($nsid,$data,$filemime,false);
    //DebugOut($retval, "BlobUpload");
    $blob = [
        '$type'=> "blob",
        'ref' => [ '$link' => $retval['blob']['ref']['$link'] ],
        'mimeType'  => $retval['blob']['mimeType'],
        'size'      => $retval['blob']['size'],
    ];

    if($tmpfile){
        if(file_exists($filename)) unlink($filename);
    }

    return $blob;
}


/**
 * atp_get_user_did_from_handle - returns the did of a given handle (f.e. schnoog.eu)
 * @param mixed $handle 
 * @return mixed 
 * @throws RestClientException 
 */
function atp_get_user_did_from_handle($handle){
    global $config;
    $data = [
                'handle' => $handle,
    ];
    $diddata = atp_api_get_data($config['nsid']['gethandle'],$data);
    if(!$diddata) return false;
    return $diddata['did'];
}