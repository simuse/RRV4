<?php namespace App\Http\Controllers;

use Config;
use Request;
use Route;
use Session;
use App\Reddit;
use App\Classes;


class ProfileController extends Controller {


	public function __construct()
	{

		parent::__construct();

		$this->params = Route::current()->parameters();
		$this->user = $this->params['user'];

	}

	/**
	 * Show the profile page
	 *
	 * @return view
	 */
	public function getProfile()
	{

		// get user
		$reddit = new Reddit();
		$user = $reddit->getUser($this->user);

		$data = array(
			'user' => $user
		);

		return view('profile')->with('data', $data);

	}

}


















