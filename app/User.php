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

		// Get Cookies
		if ($this->save_method === 'cookie') {
			$this->access_token = Cookie::get('access_token');
			$this->refresh_token = Cookie::get('refresh_token');
		}

	}

	/*
	|--------------------------------------------------------------------------
	| Authentication
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Get Authorization Code
	 * Redirect to Reddit auth
	 *
	 * @todo  double-check with the 'state' parameter
	 *
	 * @return void
	 */
	public static function authorize()
	{

		$url = sprintf('%s?response_type=code&client_id=%s&redirect_uri=%s&duration=%s&scope=%s&state=%s',
			Config::get('reddit.api.endpoint.authorize'),
			Config::get('reddit.api.client_id'),
			Config::get('reddit.api.redirect_uri'),
			Config::get('reddit.api.auth_duration'),
			implode(',', Config::get('reddit.api.scope')),
			Helpers::randomString()
		);

		header("Location: $url");

		die();

	}

	/**
	 * Check if the User has a valid Token
	 *
	 * @return boolean|object
	 */
	public function check()
	{

		if ($this->access_token) {
			$request = $this->client->createRequest('GET', 'https://oauth.reddit.com/api/v1/me.json');
			$request->setHeader('Authorization', 'bearer ' . $this->access_token);

			try {
				$response = $this->client->send($request);
			} catch (Exception $e) {
				d('Caught exception');
				dd($e);
			}

		    if ($response->getReasonPhrase() === 'OK') {
		    	return $response->json();
		    }
		}

		return false;

	}

	/**
	 * Get Access Token
	 *
	 * @return object
	 */
	public function getToken()
	{

		return $this->access_token;

	}

	/**
	 * Refresh User Access Token
	 *
	 * @return boolean
	 */
	public function refreshToken()
	{

		if (!$this->refresh_token) return false;

		try {
			$response = $this->client->post('https://www.reddit.com/api/v1/access_token', [
	    		'body' => [
			        'grant_type' 	=> 'refresh_token',
			        'redirect_uri' 	=> Config::get('reddit.api.redirect_uri'),
			        'refresh_token' => $this->refresh_token
			    ]
			]);
		} catch (Exception $e) {
			d('Caught exception');
			dd($e);
		}

		if ($response->getReasonPhrase() === 'OK') {
			$this->access_token = $response->json()['access_token'];

			if ($this->save_method === 'cookie') {
				$cookie = Cookie::queue('access_token', $this->access_token, 60);
			}
		}

	}

	/**
	 * Revoke Token
	 *
	 * @todo https://github.com/reddit/reddit/wiki/OAuth2
	 * @todo Laravel way to delete cookies
	 *
	 * @return void
	 */
	public static function revokeToken()
	{

		setcookie('access_token', null, -2628000);
		setcookie('refresh_token', null, -2628000);

	}

	/**
	 * Set remote Access Token
	 * Queries Reddit API - Requires an Authorization Code provided after redirect through the Authorize method
	 *
	 * @todo  	handle error
	 *
	 * @param  	string $code
	 * @return 	void
	 */
	public function setToken($code)
	{

		try {
			$response = $this->client->post(Config::get('reddit.api.endpoint.token'), [
	    		'body' => [
			        'code' 			=> $code,
			        'grant_type' 	=> 'authorization_code',
			        'redirect_uri' 	=> Config::get('reddit.api.redirect_uri')
			    ]
			]);
		} catch (Exception $e) {
			d('Caught exception');
			dd($e);
		}

		if ($response->getReasonPhrase() === 'OK') {
			$response = $response->json();

			if ($this->save_method === 'cookie') {
				if (isset($response['refresh_token'])) {
					Cookie::queue('refresh_token', $response['refresh_token'], 2628000);
				}
				Cookie::queue('access_token', $response['access_token'], 60);
			}

			return true;

		}

		return false;

	}

	/*
	|--------------------------------------------------------------------------
	| User Data
	|--------------------------------------------------------------------------
	|
	|
	*/

	/**
	 * Wrapper for the User data requests
	 *
	 * @param  string $url
	 * @return object
	 */
	private function userRequest($url)
	{

		if (!$this->access_token) return false;

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

}




