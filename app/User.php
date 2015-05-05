<?php namespace App;

use Config;
use Cookie;
use App\Classes\Helpers;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;

/**
 * User
 *
 * @todo catch Guzzle Error
 * @todo move save_method to Config
 */
class User extends Model {

	private $client;

	private $access_token;
	private $refresh_token;
	private $save_method = 'cookie';
	private $token_type;

	public function __construct()
	{

		// Prepare Client
		$this->client = new Client([
		    'defaults' => [
		        'auth'    => [
		        	Config::get('reddit.api.client_id'),
		        	Config::get('reddit.api.secret')
		        ],
		        'headers' => [
		        	'User-Agent' => Config::get('reddit.api.user_agent')
		        ]
		    ]
		]);

	}

	/**
	 * [getToken description]
	 * @return [type] [description]
	 */
	public function getToken() {
		$this->access_token = isset($this->access_token) ? $this->access_token : Cookie::get('access_token');
		return $this->access_token;
	}

	/**
	 * [getToken description]
	 * @return [type] [description]
	 */
	public function getRefreshToken() {
		$this->refresh_token = isset($this->refresh_token) ? $this->refresh_token : Cookie::get('refresh_token');
		return $this->refresh_token;
	}

	/**
	 * Wrapper for the User GET requests
	 *
	 * @param  string $url
	 *
	 * @return object
	 */
	private function userRequest($url)
	{

		if (!$this->getToken()) return false;

		try {
			$request = $this->client->createRequest('GET', $url);
			$request->setHeader('Authorization', 'bearer ' . $this->access_token);
			$response = $this->client->send($request);
		} catch (Exception $e) {
			d('Caught exception');
			dd($e);
		}

		return $response->json();

	}

	/**
	 * Get Karma
	 *
	 * @return object
	 */
	public function getKarma()
	{

	    return $this->userRequest('https://oauth.reddit.com/api/v1/me/karma.json');

	}

	/**
	 * Get User Multis
	 *
	 * @return object
	 */
	public function getMultis()
	{

		return $this->userRequest('https://oauth.reddit.com/api/multi/mine.json');

	}

	/**
	 * Get Prefs
	 *
	 * @return object
	 */
	public function getPrefs()
	{

	    return $this->userRequest('https://oauth.reddit.com/api/v1/me/prefs.json');

	}

	/**
	 * Get Subscriptions
	 *
	 * @return object
	 */
	public function getSubscriptions()
	{

		return $this->userRequest('https://oauth.reddit.com/reddits/mine.json')['data']['children'];

	}

	/**
	 * Get Trophies
	 *
	 * @return object
	 */
	public function getTrophies()
	{

	    return $this->userRequest('https://oauth.reddit.com/api/v1/me/trophies.json');

	}

	/**
	 * Get User
	 *
	 * @return object
	 */
	public function getUser()
	{

	    return $this->userRequest('https://oauth.reddit.com/api/v1/me.json');

	}

	/**
	 * Set Token
	 *
	 * @param string $token
	 */
	public function setToken($value) {
		$this->access_token = $value;
	}

}




