<?php

namespace App;

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
	public function getPost($id, $sort)
	{

		$sort = isset($sort) ? $sort : 'top';

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
	 * @todo gifv imgur
	 *
	 * @param  obj $post
	 * @return string
	 */
	public function getPostType(&$post)
	{

		$url = $post['url'];
		$domain = $post['domain'];
		$extension = substr(strrchr($post['url'], '.'), 1);

		// image
		if (in_array($extension, Config::get('reddit.formats.image'))) {
			if ($extension === 'gif') {
				return 'gif';
			}
			return 'image';
		}

		// imgur
		if (preg_match('/^.*(imgur.com)\/\w{4,}/', $url)) {
			$post['orininalUrl'] = $url;
			$post['url'] = $url . '.jpg';
			return 'image';
		}

		// imgur album
		if (preg_match('/imgur.com\/a\/(\w{4,})/', $url, $matches)) {
			// <iframe class="imgur-album" width="100%" height="550" frameborder="0" src=""></iframe>
			$post['orininalUrl'] = $url;
			$post['url'] = '//imgur.com/a/'. $matches[1] .'/embed';
			return 'album';
		}

		// gfycat
		if (preg_match('/gfycat.com\/(\w{4,})/', $url, $matches)) {
			// <iframe src="http://gfycat.com/ifr/DigitalSpiffyGallowaycow" frameborder="0" scrolling="no" width="294" height="234" style="-webkit-backface-visibility: hidden;-webkit-transform: scale(1);" ></iframe>
			$post['orininalUrl'] = $url;
			$post['url'] = 'http://gfycat.com/ifr/'. $matches[1];
			return 'iframe';
		}

		// reddit
		if (preg_match('/reddit.com\/r\//', $url)) {
			return 'reddit';
		}

		// youtube
		if (preg_match('/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/i', $url, $matches)) {
			$post['originalUrl'] = $url;
			$post['url'] = '//youtube.com/embed/' . $matches[2];
			return 'video';
		}

		// vimeo
		if (preg_match('/https?:\/\/[www\.]?vimeo.com\/(\d+)($|\/)/', $url, $matches)) {
			$post['originalUrl'] = $url;
			$post['url'] = '//player.vimeo.com/video/' . $matches[1];
			return 'video';
		}

		// wikipedia
		if (preg_match('/wikipedia.org/', $domain)) {
			return 'wikipedia';
		}

		// soundcloud
		if (preg_match('/soundcloud.com/', $domain)) {
			return 'soundcloud';
		}

		// oembed
		$oembed = $this->embed->create($url);
		if ($oembed) {
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



















