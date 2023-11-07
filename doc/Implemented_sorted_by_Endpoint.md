# php_atproto

## Implemented endpoints sorted by endpoint

| Returns the persons / actors for a search term (limit) |
| ------------------------------------------------------ | ------------------------- | ------------------------------------------------------------------------------------- |
| app.bsky.actor.searchActors                            | atp_person_search         | Returns ALL persons / actors for a search term                                        |
| app.bsky.actor.searchActors                            | atp_person_searchAll      | Returns ALL persons / actors for a search term                                        |
| app.bsky.feed.getAuthorFeed                            | atp_getAll_users_posts    | get ALL posts from the feed of a user                                                 |
| app.bsky.feed.getAuthorFeed                            | atp_get_users_posts       | get posts from the feed of a user                                                     |
| app.bsky.feed.getTimeline                              | atp_get_timeline          | returns the number of entries defined from the own timeline                           |
| app.bsky.feed.post                                     | atp_create_post           | Creates a post on the own feed                                                        |
| app.bsky.graph.getBlocks                               | atp_getAll_blocks         | Returns ALL blocks of the current used account                                        |
| app.bsky.graph.getBlocks                               | atp_get_blocks            | Returns blocks of the current used account (limited)                                  |
| app.bsky.graph.getFollowers                            | atp_graph_getAllFollowers | atp_graph_getAllFollowers returns ALL the followers of a user handle in a handy array |
| app.bsky.graph.getFollowers                            | atp_graph_getfollowers    | atp_graph_getfollowers returns the followers of a user handle (limited)               |
| com.atproto.identity.resolveHandle                     | atp_get_did_from_handle   | returns the did of a given handle (f.e. schnoog.eu)                                   |
| https://search.bsky.social/search/posts                | atp_post_search           | Search posts by searchterm - non API call                                             |
