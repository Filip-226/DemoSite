<?php namespace App\Http\Controllers\App;

use Auth;
use App\User;
use App\Models\Bank;
use App\Models\Casino;
use App\Models\Transaction;
use App\Models\Transaction_History;
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

	/******************************************** For user's checking ********************************************/
	public function check_useremailaddress() 
	{
		$email = \Input::get('email');
		$isEmailExists = User::SearchUserByEmail($email)->count();
		
		if($isEmailExists == 0) {
			return "true";
		}
		return "false";
	}
	
	public function check_username() 
	{
		$name = \Input::get('name');
		$isNameExists = User::SearchUserByName($name)->count();
		
		if($isNameExists == 0) {
			return \Response::json(['result' => true]);
		}
		return \Response::json(['result' => false]);
	}

	public function check_userpassword()
	{
		$password = \Input::get('password');
		if ((\Hash::check($password, Auth::user()->password)))
			return "true";
		else
			return "false";
	}

	public function check_userbankaccount()
	{
		$bank_account = \Input::get('bank_account');
		$isBankAccountExists = User::SearchUserByBankAccount($bank_account)->count();
		
		if($isBankAccountExists == 0) {
			return "true";
		}
		return "false";
	}
	/******************************************** For user's checking ********************************************/

}
