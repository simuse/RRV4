<?php

return [
	
	'auth' => array(
		'duration'		=> 'temporary',
		'redirect_uri'	=> 'http://reddit.simonvreux.be',
		// 'scope'			=> 'identity,edit,flair,history,modconfig,modflair,modlog,modposts,modwiki,mysubreddits,privatemessages,read,report,save,submit,subscribe,vote,wikiedit,wikiread',
		'scope'			=> 'identity,edit,flair,history,mysubreddits,privatemessages,read,report,save,submit,subscribe,vote,wikiread',
		'secret'		=> 'sQSal1bqi0cJNWI6uR5KtOIEeU4',
	),
	
	'defaultSubreddit' 	=> 'all',
	'host' 				=> 'http://www.reddit.com',
	'limit' 			=> 30,
	'sort'				=> 'hot',

	'sortOptions' => array(
		'hot',
		'top',
		'new',
		'rising',
		'controversial',
	),

	'timeOptions' => array(
		'hour',
		'day',
		'week',
		'month',
		'year',
		'all'
	),

	'imageFormats' => array(
		'jpg',
		'gif',
		'gifv',
		'png',
		'jpeg',
		'bmp',
	),

	'regexes' => array(

	),

	'suggested' => array(
		'boobs',
		'funny',
		'askreddit',
		'videos',
		'showerthoughts',
	),

	'videoDomains' => array(
		'youtube.com',
		'm.youtube.com',
		'youtu.be',
		'vimeo.com',
	),

	'errorMessages' => array(
		'postNotFound' => 'Post not found'
	),
];







