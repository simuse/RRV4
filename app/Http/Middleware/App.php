<?php namespace App\Http\Middleware;

use Closure;

class App {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		// share data with view
		view()->composer('*', function($view) {

			// settings for Javascript
		    view()->share('javascriptSettings', [
				'layout' => 'list',
				'root' 	 => url('/'),
				'view'	 => $view->getName()
			]);

		    // view name
		    view()->share('viewName', $view->getName());

		});

		return $next($request);

	}

}
