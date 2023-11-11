## Endpoint list

This is just a small list of endpoints I extracted from
[Bluesky-Social atproto repository](https://github.com/bluesky-social/atproto)


| | Endpoint | Description |
| --- | -------- | ----------- |
|:black_square_button:|app.bsky.actor.defs|A reference to an actor in the network.|
|:black_square_button:|app.bsky.actor.getPreferences|Get private preferences attached to the account.|
|:black_square_button:|app.bsky.actor.getSuggestions|Get a list of actors suggested for following. Used in discovery UIs.|
|:black_square_button:|app.bsky.actor.putPreferences|Sets the private preferences attached to the account.|
|:black_square_button:|app.bsky.actor.searchActors|Find actors (profiles) matching search criteria.|
|:black_square_button:|app.bsky.actor.searchActorsTypeahead|Find actor suggestions for a search term.|
|:black_square_button:|app.bsky.embed.external|A representation of some externally linked content, embedded in another form of content|
|:black_square_button:|app.bsky.embed.images|A set of images embedded in some other form of content|
|:black_square_button:|app.bsky.embed.record|A representation of a record embedded in another form of content|
|:black_square_button:|app.bsky.embed.recordWithMedia|A representation of a record embedded in another form of content, alongside other compatible embeds|
|:black_square_button:|app.bsky.feed.describeFeedGenerator|Returns information about a given feed generator including TOS & offered feed URIs|
|:black_square_button:|app.bsky.feed.generator|A declaration of the existence of a feed generator|
|:black_square_button:|app.bsky.feed.getActorFeeds|Retrieve a list of feeds created by a given actor|
|:black_square_button:|app.bsky.feed.getActorLikes|A view of the posts liked by an actor.|
|:black_square_button:|app.bsky.feed.getAuthorFeed|A view of an actor's feed.|
|:black_square_button:|app.bsky.feed.getFeed|Compose and hydrate a feed from a user's selected feed generator|
|:black_square_button:|app.bsky.feed.getFeedGenerator|Get information about a specific feed offered by a feed generator, such as its online status|
|:black_square_button:|app.bsky.feed.getFeedGenerators|Get information about a list of feed generators|
|:black_square_button:|app.bsky.feed.getFeedSkeleton|A skeleton of a feed provided by a feed generator|
|:black_square_button:|app.bsky.feed.getListFeed|A view of a recent posts from actors in a list|
|:black_square_button:|app.bsky.feed.getPosts|A view of an actor's feed.|
|:black_square_button:|app.bsky.feed.getSuggestedFeeds|Get a list of suggested feeds for the viewer.|
|:white_check_mark:|app.bsky.feed.getTimeline|A view of the user's home timeline.|
|:black_square_button:|app.bsky.feed.searchPosts|Find posts matching search criteria|
|:black_square_button:|app.bsky.feed.threadgate|Defines interaction gating rules for a thread. The rkey of the threadgate record should match the rkey of the thread's root post.|
|:black_square_button:|app.bsky.graph.block|A block.|
|:black_square_button:|app.bsky.graph.follow|A social follow.|
|:black_square_button:|app.bsky.graph.getBlocks|Who is the requester's account blocking?|
|:black_square_button:|app.bsky.graph.getFollowers|Who is following an actor?|
|:black_square_button:|app.bsky.graph.getFollows|Who is an actor following?|
|:black_square_button:|app.bsky.graph.getList|Fetch a list of actors|
|:black_square_button:|app.bsky.graph.getListBlocks|Which lists is the requester's account blocking?|
|:black_square_button:|app.bsky.graph.getListMutes|Which lists is the requester's account muting?|
|:black_square_button:|app.bsky.graph.getLists|Fetch a list of lists that belong to an actor|
|:black_square_button:|app.bsky.graph.getMutes|Who does the viewer mute?|
|:black_square_button:|app.bsky.graph.getSuggestedFollowsByActor|Get suggested follows related to a given actor.|
|:black_square_button:|app.bsky.graph.list|A declaration of a list of actors.|
|:black_square_button:|app.bsky.graph.listblock|A block of an entire list of actors.|
|:black_square_button:|app.bsky.graph.listitem|An item under a declared list of actors|
|:black_square_button:|app.bsky.graph.muteActor|Mute an actor by did or handle.|
|:black_square_button:|app.bsky.graph.muteActorList|Mute a list of actors.|
|:black_square_button:|app.bsky.graph.unmuteActor|Unmute an actor by did or handle.|
|:black_square_button:|app.bsky.graph.unmuteActorList|Unmute a list of actors.|
|:black_square_button:|app.bsky.notification.registerPush|Register for push notifications with a service|
|:black_square_button:|app.bsky.notification.updateSeen|Notify server that the user has seen notifications.|
|:black_square_button:|app.bsky.unspecced.getPopularFeedGenerators|An unspecced view of globally popular feed generators|
|:black_square_button:|app.bsky.unspecced.getTimelineSkeleton|A skeleton of a timeline - UNSPECCED & WILL GO AWAY SOON|
|:black_square_button:|app.bsky.unspecced.searchActorsSkeleton|Backend Actors (profile) search, returning only skeleton|
|:black_square_button:|app.bsky.unspecced.searchPostsSkeleton|Backend Posts search, returning only skeleton|
