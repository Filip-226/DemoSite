<?php namespace App\Http\Controllers\User;

use Auth;
use App\User;
use Illuminate\Routing\Controller as BaseController;

class MemberController extends BaseController {

	private $logindetails_redirectTo = 'user.login_details';

	public function __construct()
	{
		//$this->middleware('auth');

		if(session()->has('locale')){
			\App::setLocale(\Session::get('locale'));
		}
		else{
			$lang = \Config('app.fallback_locale');
			\App::setLocale($lang);
			\Session::put('locale', $lang);
		}
	}
	
	public function getActivate($email, $code){
		$existMember = User::where('email', '=', $email)->first();
		
		if($existMember->code == $code && $existMember->is_verified == "0") {
			$member = User::find($existMember->user_id);
			$member->is_verified = 1;
			$member->save();

			\Auth::login($member);
			return \Redirect::route('user.dashboard')->with('error', 'Congratulation! You have successfully activated your account. Please login.');
		} else {
			return \Redirect::route('index')->with('error', 'Account activation unsuccessful.');
		}
	}
	
	public function activateMain() {
		return \View::make('auth.activate')->with('fullscreen', '1');
	}
	
	public function activateAction() {
		$existMember = User::where('email', '=', \Input::get('email'))->first();

		//if($existMember == null){
		//	return Redirect::route('account.activate.index')->with('error', 'Please enter the correct User Id.');
		//}
		
		/*if(\Input::has('action')){
			$action = \Input::get('action');

			if($action == "Resend"){
				$code = str_random(20);

				$member = Member::find($existMember->ID);
				$member->CustomerTypeID = $code;
				$member->save();

				$data = array( 
					'email' => \Input::get('ISPEmail'), 
					'fullname' => $existMember->MemberStatic->FullName,
					'username' => $existMember->UserID,
					'password' => \Input::get('Password'), 
					'code' => $code,
					'link' => URL::route('account.activate.index'),
					'activatelink' => URL::route('account.activate', array($existMember->UserID, $code)),
					'active' => 0
				);

				Mail::send('emails.auth.activate', $data, function($message) use ($data){
					$message->to($data['email'], $data['username'])->subject('Activate your account');
				});
			}
			elseif($action == "Activate"){*/
				if($existMember->code == \Input::get('code') && $existMember->is_verified == "0") {
					$member = User::find($existMember->user_id);
					$member->is_verified = 1;
					$member->save();

					\Auth::login($member);
					return \Redirect::route('user.dashboard')->with('message', 'Congratulation! You have successfully activated your account. Please login.');
				} else {
					return \Redirect::route('index')->with('error', 'Activation unsuccessful. Please enter the correct activation code.');
				}
			//}
		//}
	}

}
