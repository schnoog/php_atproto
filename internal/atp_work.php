<?php

$config['included'][] = "atp_work.php";



/**
 * atp_create_file_blob - created a blob from a file
 * @param mixed $filename 
 * @return mixed 
 */
function atp_create_file_blob($filename){
    if (! file_exists($filename)) return false;
    $blob = array();
    $filedata = file_get_contents($filename);
    $filemime = mime_content_type($filename);
    $nsid = 'com.atproto.repo.uploadBlob';
    $data =  $filedata;
    DebugOut($filemime,"MIME");
    $retval = atp_post_data($nsid,$data,$filemime,false);
    DebugOut($retval, "BlobUpload");
    $blob = [
        '$type'=> "blob",
        'ref' => [ '$link' => $retval['blob']['ref']['$link'] ],
        'mimeType'  => $retval['blob']['mimeType'],
        'size'      => $retval['blob']['size'],
    ];
    return $blob;
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

function atp_create_post($text,$langs = null,$add_link_facets = true, $add_mentions_facets = true,$images = array(),$images_alts =array()){
    global $config;
    if (!atp_session_get()) {
        return false;
    }
    $facets = array();
    $blobs = array();
    $imageelements = array();
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

    if(count($images)>0){
        for($x = 0; $x < count($images); $x++){
            $alt = "";
            if(isset($images_alts[$x])) $alt = $images_alts[$x];
            $blob = atp_create_file_blob($images[$x]);
            if(count($blob)>0){
                $blobs[] = [$blob,$alt];
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
    if(count($blobs)>0){
        for($x=0;$x < count($blobs);$x++){
            $imageblob = $blobs[$x][0];
            $imagealt = $blobs[$x][1];
            $imageelements[] = [
                'alt' => $imagealt,
                'image' => $imageblob
            ];
        }
        $record['embed'] = [
            '$type'  => "app.bsky.embed.images",
            "images" => $imageelements
        ];

    }


    DebugOut($record,"RECORD");

    $data = [
        "repo" => $config['session']["did"],
        "collection" =>"app.bsky.feed.post",
        "record" => $record,
    ];


    $ret = atp_post_data($nsid,$data);
    return $ret;
    

}








    
