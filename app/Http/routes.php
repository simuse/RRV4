<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


// user
Route::get('/login',						'LoginController@getLogin');
Route::post('/login',						'LoginController@postLogin');

// single post
Route::get('/p/{id}',						'HomeController@getSingle');

// subreddit
Route::get('/r/{subreddit}', 				'HomeController@getIndex');
Route::get('/r/{subreddit}/{sort}',			'HomeController@getIndex');
Route::get('/r/{subreddit}/{sort}/{time}',  'HomeController@getIndex');

// index
Route::get('/', 			 				'HomeController@getIndex');
Route::get('/{sort}', 		 				'HomeController@getIndex');
Route::get('/{sort}/{time}', 				'HomeController@getIndex');

// search form post
Route::post('/', 			 				'HomeController@formToSubreddit');
Route::post('/{sort}', 		 				'HomeController@formToSubreddit');
Route::post('/{sort}/{time}', 				'HomeController@formToSubreddit');
Route::post('/r/{subreddit}', 				'HomeController@formToSubreddit');
Route::post('/r/{subreddit}/{sort}',		'HomeController@formToSubreddit');
Route::post('/r/{subreddit}/{sort}/{time}', 'HomeController@formToSubreddit');


