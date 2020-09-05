<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Models\Transaction;
use Illuminate\Routing\Controller as BaseController;

class AjaxController extends BaseController {

	public function __construct()
	{
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

	public function notification()
	{	
		$user = User::whereRaw('created_at > (now() - INTERVAL 10 SECOND)')->count();
		$transaction = Transaction::whereRaw('created_at > (now() - INTERVAL 10 SECOND)')->count();
		
		if(($user + $transaction) > 0)
			return \Response::json(['result' => true]);
		
		return \Response::json(['result' => false]);
	}
	
}
