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

		view()->composer(['login'], function($view){
		    view()->share('viewName', $view->getName());
		});

	}


	/**
	 * [getLogin description]
	 * @return [type]
	 */
	public function getLogin()
	{

		// make view
		$data = array();

		return view('login')->with('data', $data);

	}


	/**
	 * [postLogin description]
	 * @todo  : better way to attach params to a URL
	 * @todo  : better random string
	 * @return [type]
	 */
	public function postLogin()
	{

		// get input
		$u = Request::input('username');
		$p = Request::input('password');

		// user
		$user = new User();
		$response = $user->login($u, $p);

		d($response);

		// make view
		$data = array();

		// return view('login')->with('data', $data);

	}



}


















