# php_atproto

## Implemented endpoints sorted by endpoint

| endpoint                                | function                     | description                                                                            |
| --------------------------------------- | ---------------------------- | -------------------------------------------------------------------------------------- |
| app.bsky.actor.searchActors             | atp_search_user_by_term      | Returns ALL persons / actors for a search term                                         |
| app.bsky.actor.searchActors             | atp_search_user_by_termAll   | Returns ALL persons / actors for a search term                                         |
| app.bsky.feed.getAuthorFeed             | atp_get_user_posts           | get posts from the feed of a user                                                      |
| app.bsky.feed.getAuthorFeed             | atp_get_user_posts_all       | get ALL posts from the feed of a user                                                  |
| app.bsky.feed.getTimeline               | atp_get_own_timeline         | returns the number of entries defined from the own timeline                            |
| app.bsky.feed.post                      | atp_create_post              | Creates a post on the own feed                                                         |
| app.bsky.graph.getBlocks                | atp_get_own_blocks           | Returns ALL blocks of the current used account                                         |
| app.bsky.graph.getBlocks                | atp_get_own_blocks_all       | Returns ALL blocks of the current used account                                         |
| app.bsky.graph.getFollowers             | atp_get_user_followers       | atp_get_user_followers returns the followers of a user handle (limited)                |
| app.bsky.graph.getFollowers             | atp_get_user_followers_all   | atp_get_user_followers_all returns ALL the followers of a user handle in a handy array |
| com.atproto.identity.resolveHandle      | atp_get_user_did_from_handle | returns the did of a given handle (f.e. schnoog.eu)                                    |
| https://search.bsky.social/search/posts | atp_search_posts_by_term     | Search posts by searchterm - non API call                                              |
