<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Config;
use Session;
use App\Auth;
use App\User;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct()
	{

		// User
		$this->user = new User();

		$user = null;

		if ($this->user->getToken()) {
			$user = $this->user->getUser();
		} elseif ($this->user->getRefreshToken()) {
			$auth = new Auth();
			$this->user->setToken($auth->refreshToken());
			$user = $this->user->getUser();
		}

		$subscriptions = $this->user->getSubscriptions();
		$myMultis = $this->user->getMultis();

		view()->share('user', $user);
		view()->share('subscriptions', $subscriptions);
		view()->share('myMultis', $myMultis);

	}

}
