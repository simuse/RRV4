<?php namespace App\Http\Controllers;

use Config;
use Request;
use Response;
use Session;
use App\Reddit;
use App\Classes;


class ApiController extends Controller {


	public function __construct()
	{

		$this->reddit = new Reddit();

	}

	/**
	 * Get Comments
	 *
	 * @return view
	 */
	public function getComments($id)
	{

		$comments = json_encode($this->reddit->getPost($id));

		return Response::json(['status' => 200, 'comments' => $comments]);

	}

}


















