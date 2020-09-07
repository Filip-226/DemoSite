<?php namespace App\Http\Controllers\Auth;



use Auth;

use App\User;

use App\Models\Bank;

use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Contracts\Auth\Guard;

use Illuminate\Contracts\Auth\Registrar;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;



class AuthController extends Controller {



	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/



	use AuthenticatesAndRegistersUsers;



	protected $redirectTo = '/panel';



	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */

	public function __construct(Guard $auth, Registrar $registrar)

	{

		$this->auth = $auth;

		$this->registrar = $registrar;



		$this->middleware('guest', ['except' => 'getLogout']);

		

		if(session()->has('locale')){

			\App::setLocale(\Session::get('locale'));

		}

		else{

			$lang = \Config('app.fallback_locale');

			\App::setLocale($lang);

			\Session::put('locale', $lang);

		}

	}





	public function getRegister()

	{

		$bank_list = Bank::GetAllBank()->get();



		return view('auth.register')

				->with('bank_list', $bank_list)

				->with('fullscreen', '1');

	}

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }


	public function postRegister(Request $request)

	{
        $validator = $this->validator($request->all());

//		$validator = $this->registrar->validator($request->all());



		$code = str_random(20);

		$request['code'] = $code;

		

		if ($validator->fails())

		{

			$this->throwValidationException(

				$request, $validator

			);

		}

		

		$data = array('name' => $request['name'],

					 'email' => $request['email'],

					 'subject' => 'Welcome to Topup System',

					 'admin_email' => \Config::get('mail.from')["address"],

					 'admin_name' => 'Topup System',

					 'code' => $code,

					 'link' => \URL::route('account.activate.index'),

					 'activatelink' => \URL::route('account.activate', array($request['email'], $code))

					 );



		\Mail::send('emails.activate', $data, function($message) use ($data)

		{

		    $message->from($data["admin_email"], $data["admin_name"]);



		    $message->to($data["email"], $data["name"])->subject($data["subject"]);

		});



		$this->registrar->create($request->all());



		return redirect($this->redirectPath());

	}



	public function getLogin()

	{	

		return view('auth.login')

				->with('fullscreen', '1');

	}



	public function postLogin(Request $request)

	{

		$this->validate($request, [

			'email' => 'required|email', 'password' => 'required',

		]);



		$credentials = $request->only('email', 'password');



		$user_info = User::SearchUserByEmail($request['email'])->first();



		if((bool)$user_info['is_verified'])

		{

			if ($this->auth->attempt($credentials, $request->has('remember')))

			{				

				\Session::put('authenticated', 'TRUE');

				\Session::put('user_type', (Auth::user()->is_admin) ? "Admin" : "User");

				if(!Auth::user()->is_admin && (Auth::user()->bank_id == '' || Auth::user()->bank_account == ''))

					return redirect()->intended('/panel/update-account');

				else

					return redirect()->intended($this->redirectTo);

			}

			else

				$error_msg = $this->getFailedLoginMessage(1);

		}

		else

			$error_msg = $this->getFailedLoginMessage(2);

		



		



		return redirect($this->loginPath())

					->withInput($request->only('email', 'remember'))

					->withErrors([

						'email' => $error_msg,

					]);

	}



	protected function getFailedLoginMessage($error_msg_type)

	{

		if($error_msg_type == 1)

			return \Lang::get('user.credential_error_msg');

		else

			return \Lang::get('user.account_pending_msg');

	}



	public function getLogout()

	{

		\Session::flush();

		$this->auth->logout();



		return redirect('/auth/login');

	}



}