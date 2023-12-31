<?php

$config['included'][] = "atp_net_helper.php";



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