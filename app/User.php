<?php 

namespace App;

use Config;
use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;


class User extends Model {

	public function __construct()
	{

		$this->client = new Client();

	}


	/**
	 * [getToken description]
	 * @return [type]
	 */
	public function getToken()
	{

		// random string
		$this->rnd = time() . 'sdgpzikp';
		$this->rnd = str_shuffle($this->rnd);

		// query	
		$query = 'https://www.reddit.com/api/v1/authorize?';
		$query .= 'client_id=' . Config::get('reddit.auth.secret');
		$query .= '&response_type=code';
		$query .= '&state=' . $this->rnd;
		$query .= '&redirect_uri=' . Config::get('reddit.auth.redirect_uri');
		$query .= '&duration=' . Config::get('reddit.auth.duration');
		$query .= '&scope=' . Config::get('reddit.auth.scope');

	    $response = $this->client->get($query);

	    return $response;

	}


	public function login($u = null, $p = null)
	{
		
		$this->username = $u;
		$this->password = $p;
		$this->token = $this->getToken();

		return redirect($this->token->getEffectiveUrl());
		
	}
	

}




