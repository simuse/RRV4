<?php 

namespace App;

use Config;
use Embed\Embed;
// use Essence\Essence;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;


class Reddit extends Model {


	public function __construct()
	{

		$this->client = new Client();
		$this->embed = new Embed();

	}


	/**
	 * [getPost description]
	 * @param  [type]
	 * @return [type]
	 */
	public function getPost($id)
	{
		
		// making the request
		$query = sprintf(Config::get('reddit.host') . '/comments/%s.json', $id);
	    $response = $this->client->get($query);

	    // check the response
	    if ($response->getReasonPhrase() !== 'OK') {
	    	return null;
	    }

	    // format the response
	    $json = $response->json();
		$post = $json[0]['data']['children'][0]['data'];
		$comments = $json[1]['data']['children'];
		$post['type'] = $this->getPostType($post);
		$post['timeago'] = $this->timeAgo($post['created_utc']);

		$formatted = array(
			'comments'  => $comments,
			'post' 		=> $post,
		);

	    return $formatted;

	}


	/**
	 * [getPosts description]
	 * @param  [type]
	 * @param  [type]
	 * @param  [type]
	 * @param  [type]
	 * @param  [type]
	 * @return [type]
	 */
	public function getPosts($subreddit = null, $page = null, $sort = null, $time = null, $limit = null)
	{
		
		// basic params
		$subreddit  = (!empty($subreddit)) ? $subreddit : Config::get('reddit.defaultSubreddit');
		$sort    	= (!empty($sort)) ? $sort : Config::get('reddit.sort');
		$limit   	= (!empty($limit)) ? $limit : Config::get('reddit.limit');
	    $qTime	 	= (!empty($time)) ? '&t=' . $time : '';

	    // delimiter params
	    $delimiter = '';
	    if ($this->previousPage < $this->page && Session::has('after')) {
	    	$delimiter = '&after=' . Session::get('after');
	    } else if ($this->previousPage > $this->page && Session::has('before')) {
	    	$delimiter = '&before=' . Session::get('before');
	    }

	    // making the request
	    $query = sprintf(Config::get('reddit.host') . '/r/%s/%s.json?%s&limit=%d%s', $subreddit, $sort, $qTime, $limit, $delimiter);
	    $response = $this->client->get($query);
	    
	    // check the response
	    if ($response->getReasonPhrase() !== 'OK') {
	    	return null;
	    }

	    // format the response
	    $json = $response->json();
		$posts = $json['data'];

		$formatted = array(
			'after'  => $posts['after'],
			'before' => $posts['before'],
			'posts'  => array(),
		);

		foreach ($posts['children'] as $key => $value) {
			$post = $value['data'];
			$post['type'] = $this->getPostType($post);
			$post['timeago'] = $this->timeAgo($post['created_utc']);
			array_push($formatted['posts'], $post);
		}

		return $formatted;

	}


	/**
	 * Deduct post type from post data object
	 * @todo move all regexes into config file
	 * @todo check this case: 'http://imgur.com/VSor1R7/.jpg'
	 * @todo gifv imgur
	 *
	 * @param  [object] $post [post object]
	 *
	 * @return [string]       [post type]
	 */
	public function getPostType(&$post)
	{

		$url = $post['url'];
		$domain = $post['domain'];
		$extension = substr(strrchr($post['url'], '.'), 1);

		// image
		foreach (Config::get('reddit.imageFormats') as $key => $value) {
			if ($extension === $value) {
				if ($extension === 'gif') {
					return 'gif';
				}
				if ($extension === 'gifv') {
					$post['url'] = substr($url, 0, -1);
					return 'gif';
				}
				return 'image';
			}
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
		// @TODO better youtube regex (see $matches[1])
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

		// instagram
		// @TODO edit html
		if (preg_match('/instagram.com/', $domain)) {
			return 'instagram';
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
	 * Turn timestamp into human-readable time diffence
	 *
	 * @param  time $time [time]
	 *
	 * @return string     [time ago]
	 */
	public function timeAgo($time)
	{

		$time = time() - $time;

	    $tokens = array (
	        31536000 => 'year',
	        2592000 => 'month',
	        604800 => 'week',
	        86400 => 'day',
	        3600 => 'hour',
	        60 => 'minute',
	        1 => 'second'
	    );

	    foreach ($tokens as $unit => $text) {

	        if ($time < $unit) continue;

	        $numberOfUnits = floor($time / $unit);

	        return $numberOfUnits . ' ' . $text . (($numberOfUnits>1) ? 's' : '');

	    }
	}
	
}



















