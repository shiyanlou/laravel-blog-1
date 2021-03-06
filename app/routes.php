<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('login', function()
{
	return View::make('login');
});

Route::post('login', array('before' => 'csrf', function()
{
	$rules = array(
		'email'       => 'required|email',
		'password'    => 'required|min:6',
		'remember_me' => 'boolean',
	);
	$validator = Validator::make(Input::all(), $rules);
	if ($validator->passes())
	{
		if (Auth::attempt(array(
			'email'    => Input::get('email'),
			'password' => Input::get('password'),
			'block'    => 0), (boolean) Input::get('remember_me')))
		{
			return Redirect::intended('home');
		} else {
			return Redirect::to('login')->withInput()->with('message', 'E-mail or password error');
		}
	} else {
		return Redirect::to('login')->withInput()->withErrors($validator);
	}
}));

Route::get('home', array('before' => 'auth', function()
{
	return View::make('home');
}));

Route::get('logout', array('before' => 'auth', function()
{
	Auth::logout();
	return Redirect::to('/');
}));