# To Do

## Controllers / Models
- Base
	- Handle Guzzle exceptions
- Reddit
	- post not found
	- leave a comment
	- upvote post
	- upvote comment
	- save post
	- reply to comment
	- format comments and selftext
	- post type: handle "http://imgur.com/gallery/JMdZG"
	- post type: sounds (soundcloud,bandcamp...)
- Home
	- cleanup
	- find a better way to deal with page numbers/after/before (not in Sessions)
	- rich Schema for post types
- User
	- favorite subreddit
	- "ban" (hide) subreddit

## Structure
- CSS
	- reorganise css
	- customize semantic ui
	- cleanup all json files

## Views
- Common
	- better comments
	- better About button+modal
	- disable "next" button on last page
- Posts
	- improve wikipedia view
	- deal with gifv format
	- find a better way to display Self posts
	- add Embed Provider icon
	- better oembed view
	- erreur d'alignement dans le header
	- add a default image/iframe
	- Isotope view, popover has higher zindex than wrap dimmed
- Comments
	- Display date as timeago in comments
	- find a better place for post buttons
	- Schema data for comments



## Javascript
- Posts
	- play/pause animated gifs
	- enable infinite scrolling
	- autoplay mode in fancybox
	- enable nsfw hiding (blur?)
	- hide part of long 'self' post
- Comments
	- load more comments
- Common
	- add Google Analytics
	- autocomplete
	- enable notification
	- close sidebar on click
	- load jQuery from a CDN with a callback
	- add loader on page change

## Optimisation
*Strategy to limit number of Reddit requests*
- attach an event on Guzzle to increment a number every time a request is sent, so i can know how many requests are done
- find what caching method is best (file, database, redis)
- front page: cache the front page and refresh it every 10 minutes
- user: save user info in a database and only refresh it every hour
- save a timestimp somewhere to know when the token needs refreshing
- dont send a request to know if the user is still connected
- fix Gruntfile

## Accessibility
- icon buttons have no text (so without CSS, it says nothing)
