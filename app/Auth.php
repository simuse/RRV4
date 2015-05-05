<?php namespace App;

use Config;
use Cookie;
use App\Classes\Helpers;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;

/**
 * Auth
 */
class Auth extends Model {

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

			return $this->access_token;

		}

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
	public function requestToken($code)
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
				Cookie::queue('access_token', $response['access_token'], 58);
			}

			return true;

		}

		return false;

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

}




