<?php

namespace App\Http\Controllers;

use Config;
use Request;
use Route;
use Session;
use App\User;


class LoginController extends Controller {


	public function __construct()
	{

	}

	/**
	 * Authorize User via Reddit
	 *
	 * @return void
	 */
	public function authorize()
	{

		User::authorize();

	}

	/**
	 * Get and save the Access Token
	 *
	 * @return Redirect
	 */
	public function getToken()
	{

		if (Request::has('state') && Request::has('code')) {

			$user = new User();
			$token = $user->setToken(Request::get('code'));
			if ($token) return redirect('/')->with('notification', 'Login successful');

		} else if (Request::has('error')) {
			return redirect('/')->withError('Login failed: you denied access to Reddit');
		}

		return redirect('/')->withError('Login failed: unknown reason');

	}

	/**
	 * Logout
	 *
	 * @return Redirect
	 */
	public function logout()
	{

		User::revokeToken();

		return redirect('/')->with('notification', 'Logged out');

	}

}


















