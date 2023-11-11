# php_atproto

## Implemented endpoints sorted by function

| endpoint                                | function                      | description                                                                            | endpoint-description |
| --------------------------------------- | ----------------------------- | -------------------------------------------------------------------------------------- | -------------------- |
| app.bsky.feed.post                      | atp_create_post               | Creates a post on the own feed                                                         |
| app.bsky.feed.post                      | atp_create_quote              | Creates a quote post                                                                   |
| app.bsky.feed.post                      | atp_create_reply              | Creates a reply to a post                                                              |
| com.atproto.repo.deleteRecord           | atp_delete_post               | deletes an own post                                                                    |
| app.bsky.graph.getBlocks                | atp_get_own_blocks            | Returns ALL blocks of the current used account                                         |
| app.bsky.graph.getBlocks                | atp_get_own_blocks_all        | Returns ALL blocks of the current used account                                         |
| app.bsky.notification.listNotifications | atp_get_own_notifications     | Returns the own notifications (limited)                                                |
| app.bsky.notification.listNotifications | atp_get_own_notifications_all | Returns ALL own notifications                                                          |
| app.bsky.feed.getTimeline               | atp_get_own_timeline          | returns the all entries from the own timeline                                          |
| com.atproto.identity.resolveHandle      | atp_get_user_did_from_handle  | returns the did of a given handle (f.e. schnoog.eu)                                    |
| app.bsky.graph.getFollowers             | atp_get_user_followers        | atp_get_user_followers returns the followers of a user handle (limited)                |
| app.bsky.graph.getFollowers             | atp_get_user_followers_all    | atp_get_user_followers_all returns ALL the followers of a user handle in a handy array |
| app.bsky.feed.getAuthorFeed             | atp_get_user_posts            | get posts from the feed of a user                                                      |
| app.bsky.feed.getAuthorFeed             | atp_get_user_posts_all        | get ALL posts from the feed of a user                                                  |
| https://search.bsky.social/search/posts | atp_search_posts_by_term      | Search posts by searchterm - non API call                                              |
| app.bsky.actor.searchActors             | atp_search_user_by_term       | Returns ALL persons / actors for a search term                                         |
| app.bsky.actor.searchActors             | atp_search_user_by_term_all   |                                                                                        |
