<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Config;
use Session;
use App\User;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	public function __construct()
	{

		// User
		$this->user = new User();
		$user = $this->user->check();
		$subscriptions = $this->user->getSubscriptions();
		$myMultis = $this->user->getMultis();

		view()->share('user', $user);
		view()->share('subscriptions', $subscriptions);
		view()->share('myMultis', $myMultis);

		// Refresh Token
		if ($user) {
			$this->user->refreshToken();
		}

	}

}
