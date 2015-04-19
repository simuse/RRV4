# To Do

## Controllers
- separate AuthModel & UserModel
- Unfound subreddit

## Views
- header: disable "next" button on last page
- posts: improve wikipedia view
- deal with gifv format
- embed sound formats (soundcloud)
- find a better way to display reddit posts
- unveil: add a default image/iframe

## Javascript
- play/pause animated gifs
- enable infinite scrolling
- enable nsfw hiding (blur?)
- load jQuery from a CDN with a callback
- get a list of all subreddits and make an autocomplete
- enable notification

## Optimisation
*Strategy to limit number of Reddit requests*
- attach an event on Guzzle to increment a number every time a request is sent, so i can know how many requests are done
- find what caching method is best (file, database, redis)
- front page: cache the front page and refresh it every 10 minutes
- user: save user info in a database and only refresh it every hour
- save a timestimp somewhere to know when the token needs refreshing
- dont send a request to know if the user is still connected

## Other
- find a better way to deal with page numbers/after/before (not in Sessions)
