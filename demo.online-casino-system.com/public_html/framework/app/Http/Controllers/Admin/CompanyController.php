<?php namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Bank;
use App\Models\Company;
use Illuminate\Routing\Controller as BaseController;

class CompanyController extends BaseController {

	private $paginate = 20;
	private $redirectTo = 'panel.admin.company_manage';

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
		$company_bank_list = Company::GetAllCompanyBank()
									->paginate($this->paginate);
		$company_bank_list->setPath('manage');

		return view('admin.company_list')
				->with('company_bank_list', $company_bank_list)
				->with('fullscreen', '0');
	}

	public function add() 
	{	
		$bank_list = Bank::GetAllBank()->get();

		return \View::make('admin.company_create')
				->with('bank_list', $bank_list)
				->with('fullscreen', '0');
	}

	public function create() 
	{
		$bank_id = \Input::get('bank_sel');
		$bank_account = \Input::get('bank_account_txt');
		$bank_fullname = \Input::get('bank_fullname_txt');

		try
		{
			$company = new Company;
			$company->bank_id = $bank_id;
			$company->bank_account = $bank_account;
			$company->bank_fullname = $bank_fullname;
			$company->save();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('company.create_success_msg'));
		}
		catch(Exception $e)
		{
			return \Redirect::back()
							->with('error_message', $e->getMessage());
		}
	}
	
	public function edit($id) 
	{
		$bank_list = Bank::GetAllBank()->get();

		return \View::make('admin.company_edit')
				->with('company_bank', Company::find($id))
				->with('bank_list', $bank_list)
				->with('fullscreen', '0');
	}
	
	public function update($id) 
	{
		$bank_id = \Input::get('bank_sel');
		$bank_account = \Input::get('bank_account_txt');
		$bank_fullname = \Input::get('bank_fullname_txt');

		try
		{
			$company = Company::find($id);
			$company->bank_id = $bank_id;
			$company->bank_account = $bank_account;
			$company->bank_fullname = $bank_fullname;
			$company->save();
				
			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('company.update_success_msg'));
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
			$company = Company::find($id);
			$company->delete();

			return \Redirect::route($this->redirectTo)
							->with('message', \Lang::get('company.delete_success_msg'));
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
			$bank_name = \Input::get('bankname_search_txt');
			$bank_account = \Input::get('bankaccount_search_txt');
			$bank_fullname = \Input::get('bankfullname_search_txt');

			$company_bank_list = Company::SearchCompanyBankByDetails($bank_name, $bank_account, $bank_fullname)
								->paginate($this->paginate);
			$company_bank_list->setPath('actions');

			return view('admin.company_list')
						->with('company_bank_list', $company_bank_list)
						->with('fullscreen', '0');
		}
	}
}
