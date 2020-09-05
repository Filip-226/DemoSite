<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Bank;
use Illuminate\Routing\Controller as BaseController;

class BankController extends BaseController {

	private $paginate = 20;
	private $redirectTo = 'panel.admin.bank_manage';

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
		$bank_list = Bank::GetAllBank()
						->paginate($this->paginate);
		$bank_list->setPath('manage');

		return view('admin.bank_list')
				->with('bank_list', $bank_list)
				->with('fullscreen', '0');
	}

	public function add() 
	{	
		return \View::make('admin.bank_create')
				->with('fullscreen', '0');
	}

	public function create() 
	{
		$bank_name = \Input::get('name_txt');
		$bank_fullname = \Input::get('fullname_txt');

		try
		{
			$bank = new Bank;
			$bank->name = $bank_name;
			$bank->fullname = $bank_fullname;
			$bank->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('bank.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function edit($id) 
	{
		return \View::make('admin.bank_edit')
				->with('bank', Bank::find($id))
				->with('fullscreen', '0');
	}
	
	public function update($id) 
	{
		$bank_name = \Input::get('name_txt');
		$bank_fullname = \Input::get('fullname_txt');

		try
		{
			$bank = Bank::find($id);
			$bank->name = $bank_name;
			$bank->fullname = $bank_fullname;
			$bank->save();
				
			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('bank.update_success_msg'));
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
			$bank = Bank::find($id);
			$bank->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('bank.delete_success_msg'));
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
			$bank_list = Bank::SearchBankByName(\Input::get('bankname_search_txt'))
								->paginate($this->paginate);
			$bank_list->setPath('actions');

			return view('admin.bank_list')
						->with('bank_list', $bank_list)
						->with('fullscreen', '0');
		}
	}
}
