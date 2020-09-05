<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
		$this->middleware('auth');

		if(session()->has('locale')){
			\App::setLocale(\Session::get('locale'));
		}
		else{
			$lang = \Config('app.fallback_locale');
			\App::setLocale($lang);
			\Session::put('locale', $lang);
		}
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return \Redirect::route('user.dashboard');
		//return view('welcome');
	}

}
