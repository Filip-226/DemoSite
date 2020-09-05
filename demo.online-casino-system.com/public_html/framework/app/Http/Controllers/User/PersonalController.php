<?php namespace App\Http\Controllers\User;

use Auth;
use App\User;
use App\Models\Bank;
use App\Models\Casino;
use App\Models\Transaction;
use App\Models\Transaction_History;
use Illuminate\Routing\Controller as BaseController;

class PersonalController extends BaseController {

	private $logindetails_redirectTo = 'user.login_details';

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

	public function index()
	{	
		
	}

	public function logindetails() 
	{	
		$bank_list = Bank::GetAllBank()->get();

		return \View::make('user.member_logindetails')
					->with('bank_list', $bank_list)
					->with('fullscreen', '0');
	}

	public function update_logindetails() {		
		$user = User::find(\Auth::user()->user_id);
		
		if(\Input::get('profile') == 'email') {
			$new_email = \Input::get('email_txt'); 

			$user->email = $new_email;
			$user->save();

			return \Redirect::route($this->logindetails_redirectTo)
					->with('message', \Lang::get('user.update_email_msg'))
					->with('fullscreen', '0');
					
		} else if(\Input::get('profile') == 'password') {
			$new_password = \bcrypt(\Input::get('newpassword_txt'));
			
			$user->password = $new_password;
			$user->save();
				
			return \Redirect::route($this->logindetails_redirectTo)
					->with('message', \Lang::get('user.update_password_msg'))
					->with('fullscreen', '0');

		} else if(\Input::get('profile') == 'details') {
			$new_name = \Input::get('name_txt');
			$new_contact = \Input::get('contact_txt');
			$new_bank = \Input::get('bank_sel');
			$new_bankaccount = \Input::get('bank_account_txt');
			//$new_bankaccount_fullname = \Input::get('bank_fullname_txt');

			//$user->name = $new_name;
			$user->contact_no = $new_contact;
			//$user->bank_id = $new_bank;
			//$user->bank_account = $new_bankaccount;
			//$user->bank_fullname = $new_bankaccount_fullname;
			$user->save();

			return \Redirect::route($this->logindetails_redirectTo)
					->with('message', \Lang::get('user.update_details_msg'))
					->with('fullscreen', '0');
		}
	}
	
	public function account() 
	{	
		$bank_list = Bank::GetAllBank()->get();

		return \View::make('user.member_account')
					->with('bank_list', $bank_list)
					->with('fullscreen', '0');
	}

	public function update_account() {		
		$user = User::find(\Auth::user()->user_id);
		
			//$new_name = \Input::get('name_txt');
			//$new_contact = \Input::get('contact_txt');
			$new_bank = \Input::get('bank_id');
			$new_bankaccount = \Input::get('bank_account');
			//$new_bankaccount_fullname = \Input::get('bank_fullname');

			//$user->name = $new_name;
			//$user->contact_no = $new_contact;
			$user->bank_id = $new_bank;
			$user->bank_account = $new_bankaccount;
			//$user->bank_fullname = $new_bankaccount_fullname;
			$user->save();

			return \Redirect::route($this->logindetails_redirectTo)
					->with('message', \Lang::get('user.update_details_msg'))
					->with('fullscreen', '0');
	}

}
