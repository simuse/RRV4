<?php namespace App;

use Config;
use Request;
use Session;
use Embed\Embed;
use GuzzleHttp\Client;
use GuzzleHttp\Event\EmitterInterface;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Event\BeforeEvent;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Helpers;


class Reddit extends Model {

	public function __construct()
	{

		// http client / Guzzle
		$this->client = new Client();
		// $this->emitter = $this->client->getEmitter();
		// $this->emitter->on('before', function (BeforeEvent $event) {
		//    dd($event);
		// });

		// embed
		$this->embed = new Embed();

		$this->page = Request::get('p');
		$this->previousPage = Session::get('previousPage');

	}

	/**
	 * Single post data
	 *
	 * @param 	string $id
	 * @return 	array
	 */
	public function getPost($id, $sort = 'top')
	{

		// making the request
		try {

			$query = sprintf(Config::get('reddit.api.host') . '/comments/%s.json?sort=%s', $id, $sort);
			$request = $this->client->createRequest('GET', $query);
			$response = $this->client->send($request);

		} catch (Exception $e) {
			d('Caught exception');
			dd($e);
		}

	    // check the response
	    if ($response->getReasonPhrase() !== 'OK') {
	    	return null;
	    }

	    // format the response
	    $json = $response->json();
		$post = $json[0]['data']['children'][0]['data'];
		$comments = $json[1]['data']['children'];
		$post['type'] = $this->getPostType($post);
		$post['timeago'] = Helpers::timeAgo($post['created_utc']);

	    return array(
			'comments'  => $comments,
			'post' 		=> $post
		);

	}

	/**
	 * Collection of posts
	 *
	 * @param  string 	$subreddit
	 * @param  int 		$page
	 * @param  string 	$sort
	 * @param  string 	$time
	 * @param  int 		$limit
	 * @return posts
	 */
	public function getPosts($subreddit = null, $page = null, $sort = null, $time = null, $limit = null)
	{

		// basic params
		$subreddit  = (!empty($subreddit)) ? $subreddit : Config::get('reddit.defaults.subreddit');
		$sort    	= (!empty($sort)) ? $sort : Config::get('reddit.defaults.sort');
		$limit   	= (!empty($limit)) ? $limit : Config::get('reddit.defaults.limit');
	    $qTime	 	= (!empty($time)) ? '&t=' . $time : '';

	    // delimiter params
	    $delimiter = '';
	    if ($this->previousPage < $this->page && Session::has('after')) {
	    	$delimiter = '&after=' . Session::get('after');
	    } else if ($this->previousPage > $this->page && Session::has('before')) {
	    	$delimiter = '&before=' . Session::get('before');
	    }

	    // making the request
	    $query = sprintf(Config::get('reddit.api.host') . '/r/%s/%s.json?%s&limit=%d%s', $subreddit, $sort, $qTime, $limit, $delimiter);
	    $response = $this->client->get($query);

	    // check the response
	    if ($response->getReasonPhrase() !== 'OK') {
	    	return null;
	    }

	    // format the response
	    $json = $response->json();
		$data = $json['data'];

		$posts = array(
			'after'  => $data['after'],
			'before' => $data['before'],
			'posts'  => array(),
		);

		foreach ($data['children'] as $key => $value) {
			$post = $value['data'];
			$post['type'] = $this->getPostType($post);
			$post['timeago'] = Helpers::timeago($post['created_utc']);
			array_push($posts['posts'], $post);
		}

		return $posts;

	}

	/**
	 * Find the post type from a post object
	 *
	 * @todo move all regexes into config file
	 * @todo check case: 'http://imgur.com/VSor1R7/.jpg'
	 *
	 * @param  obj $post
	 * @return string
	 */
	public function getPostType(&$post)
	{

		$url = $post['url'];
		$domain = $post['domain'];
		$ext = substr(strrchr($post['url'], '.'), 1);
		$regex = Config::get('reddit.regex');

		// reddit
		if ($post['is_self']) {
			return 'reddit';
		}

		// image
		if (in_array($ext, array('jpg', 'gif', 'png', 'jpeg'))) {
			if ($ext === 'gif') return 'gif';
			return 'image';
		}

		// imgur
		if (preg_match($regex['imgur'], $url)) {

			// imgur album
			if (preg_match($regex['imguralbum'], $url, $matches)) {
				$post['orininalUrl'] = $url;
				$post['url'] = '//imgur.com/a/'. $matches[1] .'/embed';
				return 'album';
			}

			// imgur gifv
			if ($ext === 'gifv') return 'iframe';

			// imgur image
			$post['orininalUrl'] = $url;
			$post['url'] = $url . '.jpg';
			return 'image';
		}

		// gfycat
		if (preg_match($regex['gfycat'], $url, $matches)) {
			$post['orininalUrl'] = $url;
			$post['url'] = 'http://gfycat.com/ifr/'. $matches[1];
			return 'iframe';
		}

		// youtube
		if (preg_match($regex['youtube'], $url, $matches)) {
			$post['originalUrl'] = $url;
			$post['url'] = '//youtube.com/embed/' . $matches[1];
			return 'video';
		}

		// vimeo
		if (preg_match($regex['vimeo'], $url, $matches)) {
			$post['originalUrl'] = $url;
			$post['url'] = '//player.vimeo.com/video/' . $matches[1];
			return 'video';
		}


		// soundcloud
		if (preg_match($regex['soundcloud'], $url)) {
			$post['originalUrl'] = $url;
			$post['url'] = 'http://w.soundcloud.com/player/?url=' . $url . '&auto_play=false&color=915f33&theme_color=00FF00';
			return 'soundcloud';
		}

		// bandcamp
		if (preg_match($regex['bandcamp'], $url)) {
			$oembed = $this->embed->create($url);
			$post['originalUrl'] = $url;
			$post['url'] = $oembed->getProvider('opengraph')->bag->get('video');
			return 'bandcamp';
		}

		// oembed
		$oembed = $this->embed->create($url);
		if ($oembed) {
			// d($oembed);
			$post['oembed'] = $oembed;
			return 'oembed';
		}

		return null;

	}

	/**
	 * User public data
	 * @param  string $user [description]
	 * @return [type]       [description]
	 */
	public function getUser($user = '')
	{

		$userData = array();

		// about
	    $query = sprintf(Config::get('reddit.api.host') . '/user/%s/about.json', $user);
	    $response = $this->client->get($query);
	    if ($response->getReasonPhrase() === 'OK') {
	    	$json = $response->json();
	    	$userData['about'] = $json['data'];
	    }

	    // submitted
	    $query = sprintf(Config::get('reddit.api.host') . '/user/%s/submitted.json', $user);
	    $response = $this->client->get($query);
	    if ($response->getReasonPhrase() === 'OK') {
	    	$json = $response->json();

	    	// format posts
	    	$posts = [];
	    	foreach ($json['data']['children'] as $key => $value) {
	    		$post = $value['data'];
				$post['type'] = $this->getPostType($post);
				$post['timeago'] = Helpers::timeago($post['created_utc']);
				array_push($posts, $post);
	    	}

	    	$userData['submitted'] = $posts;
	    }

	    // comments
	    $query = sprintf(Config::get('reddit.api.host') . '/user/%s/comments.json', $user);
	    $response = $this->client->get($query);
	    if ($response->getReasonPhrase() === 'OK') {
	    	$json = $response->json();

	    	// format comments
	    	$comments = [];
	    	foreach ($json['data']['children'] as $key => $value) {
	    		$comment = $value['data'];
				$comment['timeago'] = Helpers::timeago($comment['created_utc']);
				array_push($comments, $comment);
	    	}

	    	$userData['comments'] = $comments;
	    }

		return $userData;

	}

}



















