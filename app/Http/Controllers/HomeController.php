<?php 

namespace App\Http\Controllers;

use Config;
use Request;
use Route;
use Session;
use App\Reddit;


class HomeController extends Controller {


	public function __construct()
	{

		// get route parameters
		$this->params = Route::current()->parameters();
		$this->previousPage = Session::has('previousPage') ? Session::get('previousPage') : null;

		// assign parameters
		$this->subreddit = isset($this->params['subreddit']) ? $this->params['subreddit'] : null;
		$this->page = Request::has('p') ? Request::get('p') : 1;
		$this->sort = isset($this->params['sort']) ? $this->params['sort'] : null;
		$this->time = isset($this->params['time']) ? $this->params['time'] : null;
		$this->limit = Config::get('reddit.limit');
		$this->after = Session::has('after') ? Session::get('after') : null;
		$this->before = Session::has('before') ? Session::get('before') : null;

		// url for the next page
		$this->url = $this->subreddit ? '/r/' . $this->subreddit : '';

		// share with view
		view()->share('subreddit', $this->subreddit);
		view()->share('page', $this->page);
		view()->share('sort', $this->sort);
		view()->share('sortFrom', $this->time);
		view()->share('url', $this->url);

		// share view name
		// @todo: move that to a config or filter file
		view()->composer(['index', 'single'], function($view){
		    view()->share('viewName', $view->getName());
		});

	}


	/**
	 * Show the homepage
	 *
	 * @return view
	 */
	public function getIndex()
	{

		// get posts
		$reddit = new Reddit();
		$posts = $reddit->getPosts(
			$this->subreddit,
			$this->page,
			$this->sort,
			$this->time,
			$this->limit
		);

	    // store some data in session
	    Session::put('after', $posts['after']);
	    Session::put('before', $posts['before']);
	    Session::put('previousPage', $this->page);

		// make view
		$data = array(
			'posts' => $posts['posts'],
		);

		return view('index')->with('data', $data);

	}


	/**
	 * Redirect to subreddit from the header form
	 *
	 * @return
	 */
	public function formToSubreddit()
	{

		$subreddit = Request::get('subreddit');

		if (!empty($subreddit)) {
			return redirect('r/' . $subreddit);
		}

		return $this->index();

	}


	/**
	 * [single description]
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getSingle($id = null)
	{

		// get post
		$reddit = new Reddit();
		$post = $reddit->getPost($id);

		return view('single')->with('data', $post);

	}

}


















