<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\User;
use App\Models\Bank;
use App\Models\Casino;
use App\Models\User_Casino;
use Illuminate\Routing\Controller as BaseController;

class UserController extends BaseController {

	private $paginate = 20;
	private $redirectTo = 'panel.admin.user_manage';

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
		$user_list = User::GetAllUser()
						->paginate($this->paginate);
		$user_list->setPath('manage');

		return view('admin.user_list')
				->with('user_list', $user_list)
				->with('fullscreen', '0');
	}

	public function send_verification_email($user_name, $user_email)
	{
		$data = array('name' => $user_name,
					 'email' => $user_email,
					 'subject' => 'Verification Completed',
					 'admin_email' => \Config::get('mail.from')["address"],
					 'admin_name' => 'Topup System');

		\Mail::send('emails.verification', $data, function($message) use ($data)
		{
			$message->from($data["admin_email"], $data["admin_name"]);

			$message->to($data["email"], $data["name"])->subject($data["subject"]);
		});
	}

	public function add() 
	{	
		$bank_list = Bank::GetAllBank()->get();
		$casino_list = Casino::GetAllCasino()->get();
		

		return \View::make('admin.user_create')
				->with('bank_list', $bank_list)
				->with('casino_list', $casino_list)
				->with('fullscreen', '0');
	}

	public function create() 
	{
		$user_name = \Input::get('name_txt');
		$user_email = \Input::get('email_txt');
		$user_password = \Input::get('password_txt');
		$user_contact = \Input::get('contact_txt');
		$user_bank = \Input::get('bank_sel');
		$user_bankaccount = \Input::get('bank_account_txt');
		$user_bankaccount_fullname = \Input::get('bank_fullname_txt');
		$casino_id = \Input::get('casino_id');
		$casino_no = \Input::get('casino_no');
		$user_isadmin = (\Input::get('isadmin_chk') == null) ? 0 : 1 ;
		$user_isverified = (\Input::get('isverified_chk') == null) ? 0 : 1 ;
		$emailExist = User::where('email', '=', $user_email);
		if($emailExist->count() == 0) {
			try
			{
				$user = new User;
				$user->name = $user_name;
				$user->email = $user_email;
				$user->password = \bcrypt($user_password);
				$user->contact_no = $user_contact;
				$user->bank_id = $user_bank;
				$user->bank_account = $user_bankaccount;
				$user->bank_fullname = $user_bankaccount_fullname;
				$user->is_admin = $user_isadmin;
				$user->is_verified = $user_isverified;
				$user->save();

				//send verification email to user after verification is done by Admin
				if((bool)$user_isverified)
					$this->send_verification_email($user_name, $user_email);
				
				for($i=0; $i<count($casino_id); $i++) {
					$casino = new User_Casino;
					$casino->user_id = $user->user_id;
					$casino->casino_id = $casino_id[$i];
					$casino->casino_no = $casino_no[$i];
					$casino->save();
					//$user->UserCasino()->save($casino);
				}

				return \Redirect::route($this->redirectTo)
								->with('message', \Lang::get('user.create_success_msg'));
			}
			catch(Exception $e)
			{
				return \Redirect::back()
								->with('error_message', $e->getMessage());
			}
		} else {
				return \Redirect::back()
								->with('error_message', "Email already exist.");
		}
	}
	
	public function edit($id) 
	{
		$bank_list = Bank::GetAllBank()->get();
		$casino_list = Casino::GetAllCasino()->get();
		$usercasino_list = User_Casino::GetAllUserCasino($id)->get();

		return \View::make('admin.user_edit')
				->with('user', User::find($id))
				->with('bank_list', $bank_list)
				->with('casino_list', $casino_list)
				->with('usercasino_list', $usercasino_list)
				->with('fullscreen', '0');
	}
	
	public function update($id) 
	{
		$user_name = \Input::get('name_txt');
		$user_email = \Input::get('email_txt');
		$user_password = \Input::get('password_txt');
		$user_contact = \Input::get('contact_txt');
		$user_bank = \Input::get('bank_sel');
		$user_bankaccount = \Input::get('bank_account_txt');
		$user_bankaccount_fullname = \Input::get('bank_fullname_txt');
		$casino_id = \Input::get('casino_id');
		$casino_no = \Input::get('casino_no');
		$casino_row = \Input::get('casino_row');
		$user_isadmin = (\Input::get('isadmin_chk') == null) ? 0 : 1 ;
		$user_isverified = (\Input::get('isverified_chk') == null) ? 0 : 1 ;
		$usercasino_list = User_Casino::GetAllUserCasino($id)->get();
		
		try
		{
			$user = User::find($id);
			$user->name = $user_name;
			$user->email = $user_email;

			if($user_password != "12345"){
				if ((\Hash::check($user_password, $user->password)) == false)
					$user->password = \bcrypt($user_password);
			}

			$user->contact_no = $user_contact;
			$user->bank_id = $user_bank;
			$user->bank_account = $user_bankaccount;
			$user->bank_fullname = $user_bankaccount_fullname;
			$user->is_admin = $user_isadmin;
			$user->is_verified = $user_isverified;
			$user->save();
			
			//send verification email to user after verification is done by Admin
			if((bool)$user_isverified)
				$this->send_verification_email($user_name, $user_email);
			
			foreach($usercasino_list as $usercasino) {
				if(!in_array($usercasino->user_casino_id, $casino_row)) {
					$uc = User_Casino::find($usercasino->user_casino_id);
					$uc->delete();
				}
			}
			
			for($i=0; $i<count($casino_id); $i++) {
				if($casino_row[$i] == "") {
					$casino = new User_Casino;
					$casino->user_id = $id;
					$casino->casino_id = $casino_id[$i];
					$casino->casino_no = $casino_no[$i];
					$casino->save();
				}
			}

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('user.update_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function delete($id) 
	{
		try
		{
			$user = User::find($id);
			$user->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('user.delete_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}

	public function actions() 
	{
		if(\Input::has('search_btn'))
		{
			$user_name = \Input::get('username_search_txt');
			$user_email = \Input::get('useremail_search_txt');
			$user_contact = \Input::get('usercontact_search_txt');
			$user_ip = \Input::get('userip_search_txt');

			$user_list = User::SearchUserByName($user_name, $user_email, $user_contact, $user_ip)
								->paginate($this->paginate);
			$user_list->setPath('actions');

			return view('admin.user_list')
						->with('user_list', $user_list)
						->with('fullscreen', '0');
		}
	}
}
