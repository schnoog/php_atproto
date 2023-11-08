<?php 

$config['included'][] = "atp_createpost.php";


/**
 * atp_create_post - Creates a post on the own feed
 * @param mixed $text 
 * @param mixed $langs 
 * @param bool $add_link_facets 
 * @param bool $add_mentions_facets 
 * @param array $images 
 * @param array $images_alts 
 * @param mixed $website_uri 
 * @param mixed $website_title 
 * @param mixed $website_description 
 * @param mixed $website_image 
 * @return bool 
 * @throws RestClientException 
 */
function atp_create_post(
    $text,
    $langs = null,
    $add_link_facets = true, 
    $add_mentions_facets = true,
    $images = array(),
    $images_alts =array(),
    $website_uri = null,
    $website_title = "",
    $website_description = "",
    $website_image = "",
    $additional_root_element = array()
){
global $config;
if (!atp_session_get()) {
    return false;
}
$debugthis = false;
$facets = array();
$blobs = array();
$imageelements = array();
$extdata = array();


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
                    '$type'=> $config['nsid']['rt_fc_link'],
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
                    '$type'=> $config['nsid']['rt_fc_mention'],
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

$wcembed = array();
if(!is_null($website_uri)){

    $wc = atp_get_website_info($website_uri,$website_image,$website_title,$website_description);

    DebugOut($wc,"WC",$debugthis);

    $extdata = [
        'uri' => $website_uri,
        'title' => $wc['title'],
        'description' => $wc['desc'],
     ];   
     if(!is_null($wc['image'])){
        if(strlen($wc['image'])>0){
            $blob = atp_create_file_blob($wc['image']);
            $extdata['thumb'] = $blob;
        }
    }
    $wcembed =[
        '$type' => $config['nsid']['embed_external'],
        'external' =>  $extdata

     ]; 
     $blobs = array();

}



$nsid = 'com.atproto.repo.createRecord';
$pdate = date(('Y-m-d\\TH:i:s.u\\Z'));
$record = [
    '$type'=>$config['nsid']['post'],
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
        '$type'  => $config['nsid']['emdeb_images'],
        "images" => $imageelements
    ];

}

if(count($wcembed) > 0){
    $record['embed'] = $wcembed;
}

if(count($additional_root_element)){
    foreach($additional_root_element as $key => $value){
        if(isset($record[$key])) unset($record[$key]);
        $record[$key] = $value;

    }
}



DebugOut($record,"RECORD",$debugthis);

$data = [
    "repo" => $config['session']["did"],
    "collection" =>$config['nsid']['post'],
    "record" => $record,
];


$ret = atp_api_post_data($nsid,$data);
return $ret;
}




/**
 * atp_create_reply - Creates a reply to a post
 * @param mixed $root_uri 
 * @param mixed $root_cid 
 * @param mixed $parent_uri 
 * @param mixed $parent_cid 
 * @param mixed $text 
 * @param mixed $langs 
 * @param bool $add_link_facets 
 * @param bool $add_mentions_facets 
 * @param array $images 
 * @param array $images_alts 
 * @param mixed $website_uri 
 * @param string $website_title 
 * @param string $website_description 
 * @param string $website_image 
 * @return bool 
 * @throws RestClientException 
 */
function atp_create_reply(
    $root_uri,
    $root_cid,
    $parent_uri,
    $parent_cid,
    $text,
    $langs = null,
    $add_link_facets = true, 
    $add_mentions_facets = true,
    $images = array(),
    $images_alts =array(),
    $website_uri = null,
    $website_title = "",
    $website_description = "",
    $website_image = ""
){

    $data['reply'] = [
        'root' => [
            'uri' => $root_uri,
            'cid' => $root_cid
        ],
        'parent' => [
            'uri' => $parent_uri,
            'cid' => $parent_cid
        ]
    ];

    return atp_create_post(
        $text,$langs,$add_link_facets,$add_mentions_facets,$images,$images_alts,$website_uri,$website_title,$website_description,$website_image,$data
    );
}


/**
 * atp_create_quote - Creates a quote post
 * @param mixed $record_uri 
 * @param mixed $record_cid 
 * @param mixed $text 
 * @param mixed $langs 
 * @param bool $add_link_facets 
 * @param bool $add_mentions_facets 
 * @param array $images 
 * @param array $images_alts 
 * @param mixed $website_uri 
 * @param string $website_title 
 * @param string $website_description 
 * @param string $website_image 
 * @return bool 
 * @throws RestClientException 
 */
function atp_create_quote(
    $record_uri,
    $record_cid,
    $text,
    $langs = null,
    $add_link_facets = true, 
    $add_mentions_facets = true,
    $images = array(),
    $images_alts =array(),
    $website_uri = null,
    $website_title = "",
    $website_description = "",
    $website_image = ""
){
    global $config;
    $data['embed'] = [
        '$type' => $config['nsid']['embed_record'] ,
        'record' => [
            'uri' => $record_uri,
            'cid' => $record_cid
        ]
    ];



    return atp_create_post(
        $text,$langs,$add_link_facets,$add_mentions_facets,$images,$images_alts,$website_uri,$website_title,$website_description,$website_image,$data
    );
}

