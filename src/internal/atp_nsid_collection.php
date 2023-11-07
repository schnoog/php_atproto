<?php 

$config['included'][] = "atp_nsid_collection.php";

/*

entries will finally end up as
$config['nsid']['']
f.e.
$config['nsid']['gethandle']

*/

$NSID['bsky']= [
    'rt_fc_link' => "app.bsky.richtext.facet#link",
    'rt_fc_mention' => "app.bsky.richtext.facet#mention",
    'emdeb_images' => "app.bsky.embed.images",
    'embed_external' => "app.bsky.embed.external",
    'get_timeline' => "app.bsky.feed.getTimeline",
    'post' => "app.bsky.feed.post",
    'searchpost' => "app.bsky.feed.searchPosts",
    'gethandle' => "com.atproto.identity.resolveHandle",
    'getfollowers' => 'app.bsky.graph.getFollowers',
    'getAuthorFeed' => 'app.bsky.feed.getAuthorFeed',
    'searchPerson' => 'app.bsky.actor.searchActors',
    'getBlocks' => 'app.bsky.graph.getBlocks',

];



